<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Product;
use App\Traits\HasImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    use HasImage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil semua orders milik user yang sedang login
        $orders = Order::with('user')->where('user_id', Auth::id())->paginate(10);

        // Mengambil produk terkait berdasarkan nama dan kuantitas
        $products = Product::all(); // Misalnya mengambil semua produk, atau bisa disesuaikan dengan kebutuhan

        // Kirim data orders dan produk ke view
        return view('customer.order.index', compact('orders', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $this->uploadImage($request, $path = 'public/orders/', $name = 'image');

        // Membuat data order baru
        Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'quantity' => $request->quantity,
            'image' => $image->hashName(),
            'unit' => $request->unit,
        ]);

        return back()->with('toast_success', 'Permintaan Barang Berhasil Diajukan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $image = $this->uploadImage($request, $path = 'public/orders/', $name = 'image');

        // Mengupdate data order
        $order->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
        ]);

        // Jika ada file image, update file image tersebut
        if($request->file($name)){
            $this->updateImage(
                $path = 'public/orders/', $name = 'image', $data = $order, $url = $image->hashName()
            );
        }

        return back()->with('toast_success', 'Permintaan Barang Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        // Menghapus order dan file image terkait
        $order->delete();

        Storage::disk('local')->delete('public/orders/'. basename($order->image));

        return back()->with('toast_success', 'Permintaan Barang Berhasil Dihapus');
    }
}
