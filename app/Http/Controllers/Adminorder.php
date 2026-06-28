<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProductVariant;
class Adminorder extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
    {
        $orders = Order::with([
            'user',
            'items.variant.color',
            'items.variant.size'])
            ->latest()
            ->get();

        return view('admin.orderadmin', compact('orders'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Cập nhật trạng thái thành công');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // nếu có items thì xóa luôn 
        $order->items()->delete();

        $order->delete();

        return back()->with('success', 'Xóa đơn hàng thành công');
    }

      /**
     * USER
     */
    public function myOrders()
    {
        $orders = Order::with([
            'items.variant.color',
            'items.variant.size'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        return view('user.donhang', compact('orders'));
    }

   public function cancelMyOrder($id)
    {
        $order = Order::with('items')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // chỉ cho hủy khi đang pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Không thể hủy đơn hàng đã xử lý');
        }

        DB::beginTransaction();

        try {

            // 1. TRẢ LẠI STOCK
            foreach ($order->items as $item) {

                $variant = ProductVariant::find($item->product_variant_id);

                if ($variant) {
                    $variant->stock += $item->quantity;
                    $variant->save();
                }
            }

            // 2. UPDATE STATUS
            $order->update([
                'status' => 'cancelled'
            ]);

            DB::commit();

            return back()->with('success', 'Hủy đơn hàng thành công');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}