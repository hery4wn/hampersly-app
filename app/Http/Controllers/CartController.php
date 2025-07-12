<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Services\MidtransService;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    /**
     * Menambahkan produk ke dalam keranjang.
     * Logika sebenarnya akan kita bangun nanti.
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Ambil keranjang dari session, jika tidak ada, buat array kosong
        $cart = session()->get('cart', []);

        // Cek apakah produk sudah ada di keranjang
        if (isset($cart[$product->id])) {
            // Jika sudah ada, tambahkan kuantitasnya
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            // Jika belum ada, tambahkan sebagai item baru
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image" => $product->image_url
            ];
        }

        // Simpan kembali keranjang ke dalam session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        // Validasi kuantitas
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        // Cek jika produk ada di keranjang, lalu update kuantitasnya
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Kuantitas berhasil diperbarui.');
        }

        return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        // Cek jika produk ada di keranjang, lalu hapus
        if (isset($cart[$id])) {
            unset($cart[$id]); // Hapus item dari array
            session()->put('cart', $cart); // Simpan kembali array yang sudah diubah
            return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function checkout()
    {
        if (empty(session('cart'))) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong!');
        }

        // Definisikan pilihan pengiriman statis
        $shippingOptions = [
            'jne_reg' => ['label' => 'JNE REG', 'price' => 15000],
            'jnt_exp' => ['label' => 'J&T Express', 'price' => 16000],
            'sicepat_reg' => ['label' => 'SiCepat REG', 'price' => 14000],
        ];

        return view('cart.checkout', compact('shippingOptions'));
    }

    public function placeOrder(Request $request)
    {
        // Definisikan pilihan pengiriman lagi di sini agar cocok saat validasi & perhitungan
        $shippingOptions = [
            'jne_reg' => ['label' => 'JNE REG', 'price' => 15000],
            'jnt_exp' => ['label' => 'J&T Express', 'price' => 16000],
            'sicepat_reg' => ['label' => 'SiCepat REG', 'price' => 14000],
        ];

        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_option' => ['required', Rule::in(array_keys($shippingOptions))], // Validasi pilihan kurir
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong!');
        }

        try {
            DB::beginTransaction();

            // Ambil detail kurir yang dipilih
            $selectedCourierKey = $request->shipping_option;
            $selectedCourier = $shippingOptions[$selectedCourierKey];

            // Hitung subtotal produk
            $productSubtotal = 0;
            foreach ($cart as $details) {
                $productSubtotal += $details['price'] * $details['quantity'];
            }

            // Hitung total akhir
            $totalAmount = $productSubtotal + $selectedCourier['price'];

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'DUMMY',
                'total_amount' => $totalAmount, // <-- Gunakan total baru
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_courier' => $selectedCourier['label'], // <-- Simpan nama kurir
                'shipping_cost' => $selectedCourier['price'],   // <-- Simpan biaya kirim
                'payment_method' => 'Payment Gateway',
                'payment_status' => 'unpaid',
            ]);

            $order->order_number = 'HMP-' . now()->format('Ymd') . '-' . $order->id;
            $order->save();

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            $midtrans = new MidtransService();
            $snapToken = $midtrans->getSnapToken($order);
            $order->snap_token = $snapToken;
            $order->save();

            session()->forget('cart');
            DB::commit();

            return redirect()->route('order.payment', $order);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function payment(Order $order)
    {
        // Pastikan order ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.payment', [
            'order' => $order,
            'snapToken' => $order->snap_token
        ]);
    }

    public function success()
    {
        // Pastikan user tidak bisa langsung akses halaman ini tanpa pesan sukses
        if (!session('success')) {
            return redirect()->route('home');
        }
        return view('order.success');
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', ['cartItems' => $cart]);
    }
}
