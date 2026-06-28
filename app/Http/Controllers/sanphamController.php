<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'category',
            'variants.color',
            'variants.size'
        ]);

        // Tên sản phẩm
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Danh mục
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Trạng thái
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $products = $query->paginate(10)->appends($request->all());

        $categories = Category::all();

        return view('admin.sanpham', compact(
            'products',
            'categories'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.themsp', compact(
            'categories',
            'colors',
            'sizes'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'thumbnail' => 'nullable',
        ]);

        // upload ảnh
        $path = $request->file('thumbnail')->store('products', 'public');

        // tạo product
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'sale_price' => $request->sale_price ?? null,
            'description' => $request->description,
            'thumbnail' => $path,
            'status' => 'active'
        ]);

        // tạo variant (1 màu + 1 size ban đầu)
        ProductVariant::create([
            'product_id' => $product->id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'stock' => $request->stock,
            'price_adjust' => 0
        ]);

        return redirect()->route('admin.sanpham')
            ->with('success', 'Thêm sản phẩm thành công');
        }

        public function edit($id)
        {
            $product = Product::findOrFail($id);

            $categories = Category::all();
            $colors = Color::all();
            $sizes = Size::all();

            return view('admin.themsp', compact(
                'product',
                'categories',
                'colors',
                'sizes'
            ));
        }

        public function update(Request $request, $id)
            {
                $product = Product::findOrFail($id);

                $data = [
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'price' => $request->price,
                    'description' => $request->description,
                    'sale_price' => $request->sale_price ?? null,
                ];

                // nếu có upload ảnh mới
                if ($request->hasFile('thumbnail')) {
                    $path = $request->file('thumbnail')->store('products', 'public');
                    $data['thumbnail'] = $path;
                }

                $product->update($data);

                $variant = $product->variants()->first();
                if ($variant) {
                    $variant->update([
                        'color_id' => $request->color_id,
                        'size_id' => $request->size_id,
                        'stock' => $request->stock,
                    ]);
                } else {
                    // nếu chưa có variant thì tạo mới
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id' => $request->color_id,
                        'size_id' => $request->size_id,
                        'stock' => $request->stock,
                        'price_adjust' => 0
                    ]);
                }

                return redirect()->route('admin.sanpham')
                    ->with('success', 'Cập nhật sản phẩm thành công');
            }

        public function destroy($id)
        {
            $product = Product::findOrFail($id);

            // nếu có variants thì xóa luôn (tránh lỗi foreign key)
            $product->variants()->delete();

            // xóa product
            $product->delete();

            return redirect()->route('admin.sanpham')
                ->with('success', 'Xóa sản phẩm thành công');
        }

       public function changeStatus(Request $request, $id)
        {
            
            $request->validate([
                'status' => 'required|in:active,inactive'
            ]);

            $product = Product::findOrFail($id);

            $product->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'status' => $product->status
            ]);
        }
}