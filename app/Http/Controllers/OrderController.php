<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\ProductVariant;
class OrderController extends Controller
{
    public function showCheckout()
    {
        $cart = session()->get('cart', []);

        return view('user.checkout', compact('cart'));
    }
    
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $user = Auth::user();
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $address = $request->address;

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để thanh toán');
        }

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng đang rỗng');
        }

        DB::beginTransaction();

        try {

            $total = 0;

            // 1. KIỂM TRA TỒN KHO TRƯỚC
            foreach ($cart as $item) {

                $variant = ProductVariant::find($item['variant_id'] ?? $item['id']);

                if (!$variant) {
                    return back()->with('error', 'Sản phẩm không tồn tại');
                }

                if ($variant->stock < $item['qty']) {
                    return back()->with(
                        'error',
                        $item['name'].' không đủ số lượng trong kho'
                    );
                }

                $total += $item['price'] * $item['qty'];
            }

            // 2. TẠO ORDER
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'address' => $address,
                'status' => 'pending',
            ]);

            // 3. TẠO ORDER ITEMS + TRỪ STOCK
            foreach ($cart as $item) {

                $variant = ProductVariant::find($item['variant_id'] ?? $item['id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'product_name' => $item['name'],
                    'product_image' => $item['image'] ?? null,
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                ]);

                // TRỪ KHO
                $variant->stock -= $item['qty'];
                $variant->save();
            }

            session()->forget('cart');

            DB::commit();

            return redirect('/donhang')
                ->with('success', 'Đặt hàng thành công');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}