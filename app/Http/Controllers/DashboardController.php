<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function dashboard()
    {
        $labels = [];
        $data = [];

        // 7 ngày gần nhất
        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i)->format('Y-m-d');

            $labels[] = Carbon::now()->subDays($i)->format('d/m');

            $data[] = Order::whereDate('created_at', $date)
            ->where('status', 'completed')
            ->sum('total');
        }

        return view('admin.index_admin', [

            'totalOrders' => Order::count(),

            'revenue' => Order::where('status', 'completed')->sum('total'),

            'totalUsers' => User::where('role_id', 2)->count(),

            'totalProducts' => Product::count(),

            'orders' => Order::latest()->take(5)->get(),

            // REAL CHART DATA
            'chartLabels' => $labels,
            'chartData' => $data,
        ]);
    }
}