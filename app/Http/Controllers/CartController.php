<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;
class CartController extends Controller
{
    // Xem giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('user.giohang', compact('cart'));
    }

    // Thêm vào giỏ
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $variant = ProductVariant::with(['product', 'color', 'size'])
        ->find($request->product_variant_id);

        if (!$variant) {
            return response()->json(['success' => false]);
        }

        $id = $variant->id;
        $stock = $variant->stock;

        $currentQty = $cart[$id]['qty'] ?? 0;
        $addQty = $request->qty ?? 1;

        // tổng sau khi cộng
        $newQty = $currentQty + $addQty;

        // CHẶN vượt stock
        if ($newQty > $stock) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng vượt quá tồn kho'
            ]);
        }

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $request->qty;
        } else {
            $cart[$id] = [
                "id" => $id,
                "product_id" => $variant->product->id,
                "variant_id" => $variant->id,
                "name" => $variant->product->name,
                "price" => $variant->product->sale_price ?? $variant->product->price,
                "qty" => $request->qty,
                "stock" => $variant->stock,
                "image" => $variant->product->thumbnail,
                "color" => $variant->color->name ?? '',
                "size" => $variant->size->size ?? '',
                "total" => 0
            ];
        }

        $cart[$id]['total'] = $cart[$id]['price'] * $cart[$id]['qty'];

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    // Cập nhật số lượng
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;
        $qty = (int) $request->qty;

        if (!isset($cart[$id])) {
            return response()->json(['success' => false]);
        }

        $cart[$id]['qty'] = $qty;
        $cart[$id]['total'] = $cart[$id]['price'] * $qty;

        session()->put('cart', $cart);

        // tính lại grand total
        $grandTotal = 0;
        foreach ($cart as $item) {
            $grandTotal += $item['total'];
        }

        return response()->json([
            'success' => true,
            'qty' => $qty,
            'item_total' => number_format($cart[$id]['total']) . 'đ',
            'grand_total' => number_format($grandTotal) . 'đ'
        ]);
    }

    // Xóa sản phẩm
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true
        ]);
    }
}