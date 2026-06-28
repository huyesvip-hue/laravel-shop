@extends('user.layoutmain')

@section('content')

<div class="container" style="padding-top: 130px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-bag-check me-2"></i>
            Đơn hàng của tôi
        </h2>

        <a href="{{ url('/') }}" class="btn btn-outline-dark rounded-pill px-4">
            Tiếp tục mua sắm
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0">
            {{ session('error') }}
        </div>
    @endif

    {{-- EMPTY --}}
    @if($orders->isEmpty())

        <div class="card border-0 shadow-sm rounded-4 text-center py-5">

            <div class="mb-3">
                <i class="bi bi-cart-x fs-1 text-muted"></i>
            </div>

            <h4 class="fw-bold mb-2">
                Bạn chưa có đơn hàng nào
            </h4>

            <p class="text-muted">
                Hãy khám phá thêm sản phẩm mới
            </p>

            <div>
                <a href="{{ url('/') }}" class="btn btn-dark rounded-pill px-4">
                    Mua sắm ngay
                </a>
            </div>

        </div>

    @endif

    @foreach($orders as $order)

    <div class="order-wrapper mb-4">

        <div class="card border-0 shadow-sm overflow-hidden order-card">

            {{-- HEADER --}}
            <div class="card-header text-white py-3 order-header">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <div>
                        <h5 class="mb-1 fw-bold text-white">
                            <i class="bi bi-receipt me-2"></i>
                            Đơn hàng 
                        </h5>

                        <small class="text-white-50">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </small>
                        <br>
                            <small class="text-white fw-semibold">
                                📍 {{ $order->address }}
                            </small>
                    </div>

                    <div class="d-flex align-items-center gap-2">

                        @php
                            $statusClass = match($order->status) {
                                'pending' => 'warning',
                                'processing' => 'info',
                                'shipping' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                                default => 'secondary'
                            };
                        @endphp

                        <span class="badge bg-light text-dark px-3 py-2 text-uppercase fw-semibold">
                            {{ $order->status }}
                        </span>

                        @if($order->status == 'pending')
                            <form action="{{ route('user.orders.cancel', $order->id) }}"
                                method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                @csrf
                                @method('PATCH')

                                <button class="btn btn-danger btn-sm rounded-pill">
                                    Hủy đơn
                                </button>
                            </form>
                        @endif

                    </div>

                </div>

            </div>

            {{-- BODY --}}
            <div class="card-body p-0 order-body">

                <div class="table-responsive">

                    <table class="table align-middle mb-0 order-table">

                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Màu</th>
                                <th>Size</th>
                                <th>SL</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($order->items as $item)
                            <tr class="order-row">

                                <td width="90">
                                    <img src="{{ asset('storage/'.$item->product_image) }}"
                                        class="order-img">
                                </td>

                                <td class="fw-semibold text-dark">
                                    {{ $item->product_name }}
                                </td>

                                <td class="text-muted">
                                    {{ $item->variant->color->name ?? '-' }}
                                </td>

                                <td class="text-muted">
                                    {{ $item->variant->size->size ?? '-' }}
                                </td>

                                <td>
                                    <span class="qty-badge">
                                        {{ $item->quantity }}
                                    </span>
                                </td>

                                <td>
                                    {{ number_format($item->price) }}đ
                                </td>

                                <td>
                                    <span class="text-danger fw-bold">
                                        {{ number_format($item->price * $item->quantity) }}đ
                                    </span>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="card-footer bg-white border-0 py-3 order-footer">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <div>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2">Chờ xác nhận</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info text-white px-3 py-2">Đang chuẩn bị</span>
                        @elseif($order->status == 'shipping')
                            <span class="badge bg-primary px-3 py-2">Đang giao</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success px-3 py-2">Hoàn thành</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger px-3 py-2">Đã hủy</span>
                        @endif
                    </div>

                    <h5 class="mb-0">
                        Tổng tiền:
                        <span class="text-danger fw-bold fs-5">
                            {{ number_format($order->total) }}đ
                        </span>
                    </h5>

                </div>

            </div>

        </div>

    </div>

    @endforeach
<style>
/* wrapper giữa các đơn */
.order-wrapper {
    position: relative;
    padding-bottom: 10px;
}

/* line phân cách nhẹ */
.order-wrapper::after {
    content: "";
    position: absolute;
    bottom: -6px;
    left: 10%;
    width: 80%;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(102,16,242,0.25), transparent);
}

/* card */
.order-card {
    border-radius: 16px;
    transition: 0.25s;
}

.order-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(102, 16, 242, 0.15);
}

/* header gradient đồng bộ */
.order-header {
    background: linear-gradient(135deg, #0d6efd, #6610f2);
}

/* table style */
.order-table thead {
    background: #eef2ff;
}

.order-table th {
    border: none !important;
    font-weight: 600;
    color: #4b5563;
    padding: 14px;
}

.order-table td {
    border: none !important;
    padding: 14px;
    vertical-align: middle;
}

/* row hover */
.order-row {
    transition: 0.2s;
    background: #fff;
}

.order-row:hover {
    background: #f6f7ff;
}

/* image */
.order-img {
    width: 65px;
    height: 65px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #eee;
}

/* qty badge */
.qty-badge {
    background: #e9ecef;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
}
</style>
</div>

@endsection