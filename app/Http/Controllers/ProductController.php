<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    // Danh sách sản phẩm
    public function index(Request $request)
    {
        $query = Product::with([
                'category',
                'variants.color',
                'variants.size'
            ])
            ->where('status', 'active');

        // LỌC THEO CATEGORY
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(9);

        return view('user.spmain', compact('products'));
    }
    
    public function show($id)
    {
        $product = Product::with('variants.color', 'variants.size')
            ->where('status', 'active')
            ->findOrFail($id);

        return view('user.ctsanpham', compact('product'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $products = Product::with('category')
            ->where('status', 'active')
            ->where(function ($q) use ($keyword) {

                $q->where('name', 'like', "%$keyword%")
                ->orWhereHas('category', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%$keyword%");
                });

            })
            ->paginate(9);

        return view('user.spmain', compact('products', 'keyword'));
    }
}