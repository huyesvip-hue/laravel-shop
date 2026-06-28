@extends('admin.layout')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Quản lý đơn hàng</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach($orders as $order)

    <div class="card mb-4 shadow-sm">

        {{-- HEADER ORDER --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <strong>Order {{ $order->id }}</strong>
                - Khách hàng
                ID: {{ optional($order->user)->id ?? 'N/A' }} -
                {{ optional($order->user)->name ?? 'Khách' }}
                <br>

                    <small class="text-white fw-semibold">
                        📍 {{ $order->address ?? 'Chưa có địa chỉ' }}
                    </small>

            </div>

            <div class="d-flex align-items-center gap-1 ms-auto">

                <form action="{{ route('admin.orders.status', $order->id) }}"
                    method="POST"
                    class="d-flex align-items-center gap-1 m-0"
                    onsubmit="return confirm('Cập nhật trạng thái đơn hàng?')">
                    @csrf
                    <select name="status"
                            class="form-select form-select-sm"
                            style="width: 130px;">
                        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Chờ xác thực</option>
                        <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Đã xác thực</option>
                        <option value="shipping" {{ $order->status=='shipping'?'selected':'' }}>Đang Giao</option>
                        <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Hoàn thành</option>
                        <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Hủy đơn</option>
                    </select>
                    <button class="btn btn-success btn-sm">
                        Cập nhật
                    </button>
                </form>

                {{-- DELETE --}}
                <form action="{{ route('admin.orders.destroy', $order->id) }}"
                    method="POST"
                    class="m-0"
                    onsubmit="return confirm('Xóa đơn hàng này?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        Xóa
                    </button>
                </form>
            </div>
        </div>

        {{-- BODY ITEMS --}}
        <div class="card-body p-0">

            <table class="table table-bordered align-middle mb-0">

                <thead class="table-dark">
                    <tr>
                        <th>Ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Màu</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($order->items as $item)

                    <tr>

                        {{-- IMAGE --}}
                        <td>
                            <img src="{{ asset('storage/'.$item->product_image) }}"
                                 width="60"
                                 height="60"
                                 style="object-fit:cover;border-radius:8px;">
                        </td>

                        {{-- PRODUCT NAME --}}
                        <td>
                            {{ $item->product_name }}
                        </td>

                        {{-- COLOR --}}
                        <td>
                            {{ $item->variant->color->name ?? '-' }}
                        </td>

                        {{-- SIZE --}}
                        <td>
                            {{ $item->variant->size->size ?? '-' }}
                        </td>

                        {{-- QTY --}}
                        <td>
                            {{ $item->quantity }}
                        </td>

                        {{-- PRICE --}}
                        <td>
                            {{ number_format($item->price) }}đ
                        </td>

                        {{-- SUBTOTAL --}}
                        <td>
                            <strong class="text-danger">
                                {{ number_format($item->price * $item->quantity) }}đ
                            </strong>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- FOOTER TOTAL --}}
        <div class="card-footer text-end">

            <h5 class="mb-0">
                Tổng tiền:
                <span class="text-danger">
                    {{ number_format($order->total) }}đ
                </span>
            </h5>

        </div>

    </div>

    @endforeach

</div>

@endsection