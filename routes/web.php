<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Http\Controllers\sanPhamController;
use App\Http\Controllers\KhachHangController;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Adminorder;
use App\Http\Controllers\DashboardController;

Route::get('/dangnhap', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::middleware(['prevent.admin'])->group(function () {
    
Route::get('/', function () {

    $products = Product::where('status', 'active')
        ->latest()
        ->take(4)
        ->get();

    $categories = Category::all();

    return view('user.home', compact(
        'products',
        'categories'
    ));
});
Route::get('/san_pham', [ProductController::class, 'index']);

Route::get('/product{id}', [ProductController::class, 'show'])
    ->name('product.show');

Route::get('/giohang', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout.page');

Route::post('/checkout', [OrderController::class, 'checkout'])
    ->middleware('auth')
    ->name('checkout');

    // USER: xem đơn hàng của mình
Route::get('/donhang', [Adminorder::class, 'myOrders'])
    ->name('user.donhang');

    // USER: hủy đơn hàng (chỉ pending)
Route::patch('/my-orders/{id}/cancel', [Adminorder::class, 'cancelMyOrder'])
    ->name('user.orders.cancel');

Route::get('/search', [ProductController::class, 'search']);
});


//admin
Route::middleware(['admin'])->prefix('adm')->group(function () {
    
Route::get('/', [DashboardController::class, 'dashboard']);

    Route::get('/sanpham', [SanPhamController::class, 'index'])
    ->name('admin.sanpham');
    
    Route::post('/product/status/{id}', [SanPhamController::class, 'changeStatus'])
    ->name('admin.product.status');

    Route::get('/khachhang', [KhachHangController::class, 'index'])
    ->name('admin.khachhang.index');

    Route::get('/themkh', [KhachHangController::class, 'create'])
        ->name('admin.khachhang');

    Route::post('/store', [KhachHangController::class, 'store'])
        ->name('admin.store');

    Route::get('/edit{id}', [KhachHangController::class, 'edit'])->name('admin.edit');

    Route::put('/update{id}', [KhachHangController::class, 'update'])->name('admin.update');

    Route::delete('/delete{id}', [KhachHangController::class, 'destroy'])->name('admin.delete');

    Route::get('/themsp', [SanPhamController::class, 'create'])
        ->name('admin.product.create');
        
    Route::post('/themsp', [SanPhamController::class, 'store'])
        ->name('admin.product.store');

    Route::get('/spedit{id}', [SanPhamController::class, 'edit'])
        ->name('admin.product.edit');

    Route::put('/sanpham/{id}', [SanPhamController::class, 'update'])
        ->name('admin.product.update');

    Route::delete('/spdelete{id}', [SanPhamController::class, 'destroy'])
        ->name('admin.product.delete');

    Route::get('/orders', [Adminorder::class, 'index'])
        ->name('admin.orderadmin');

    Route::post('/orders/{id}/status', [Adminorder::class, 'updateStatus'])
        ->name('admin.orders.status');

    Route::delete('/admin/orders/{id}', [Adminorder::class, 'destroy'])
        ->name('admin.orders.destroy');

});