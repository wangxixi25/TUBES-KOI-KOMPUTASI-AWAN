<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search', ''); // Mendapatkan nilai pencarian dari input, default kosong jika tidak ada
    
        // Menyaring produk berdasarkan pencarian
        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                         ->orWhere('description', 'like', "%$search%");
        })->get();
    
        $categories = Category::all();
    
        // Mengirimkan variabel ke view
        return view('landing.welcome', compact('products', 'categories', 'search'));
    }    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->first();

        $products = $product->where('category_id', $product->category_id)->where('id', '!=',$product->id)->limit(5)->inRandomOrder()->get();

        $transaction = TransactionDetail::with('transaction', 'product')->where('product_id', $product->id)->get();

        return view('landing.product.show', compact('product', 'products', 'transaction'));
    }
}
