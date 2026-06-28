@extends('user.layoutmain')

@section('content')

<div class="container" style="margin-top:120px;">

    <h2 class="mb-4 fw-bold">Thanh toán</h2>

    <div class="row">

        {{-- LEFT --}}
        <div class="col-md-8">

            @php $total = 0; @endphp

            @foreach($cart as $item)

                @php
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                @endphp

                <div class="border rounded p-3 mb-3 shadow-sm" style="background: #f2f2f2">

                    <div class="d-flex">

                        {{-- IMAGE --}}
                        <div style="margin-right:20px;">
                            <img 
                                src="{{ asset('storage/' . $item['image']) }}" 
                                width="85"
                                height="85"
                                class="rounded border object-fit-cover"
                            />
                        </div>

                        {{-- INFO --}}
                        <div class="flex-grow-1">

                            <h6 class="fw-bold mb-2">
                                {{ $item['name'] }}
                            </h6>

                            <div class="row">

                                {{-- LEFT --}}
                                <div class="col-6">

                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Số lượng:</span>
                                        <span>{{ $item['qty'] }}</span>
                                    </div>

                                    @if(!empty($item['color']))
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Màu:</span>
                                        <span>{{ $item['color'] }}</span>
                                    </div>
                                    @endif

                                </div>

                                {{-- RIGHT --}}
                                <div class="col-6 text-end">

                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Giá:</span>
                                        <span class="text-danger fw-bold">
                                            {{ number_format($item['price']) }}đ
                                        </span>
                                    </div>

                                    @if(!empty($item['size']))
                                    <div class="d-flex justify-content-between">
                                        <span>Size:</span>
                                        <span>{{ $item['size'] }}</span>
                                    </div>
                                    @endif

                                </div>

                            </div>

                            {{-- TOTAL (TÁCH RIÊNG )--}}
                            <div class="mt-2 pt-2 border-top d-flex justify-content-between">

                                <span class="fw-semibold">Tổng:</span>

                                <strong class="text-danger">
                                    {{ number_format($subtotal) }}đ
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- RIGHT --}}
        <div class="col-md-4">

            <div class="border rounded p-4 shadow-sm sticky-top" style="top: 20px;">

                <h4 class="fw-bold">Order Summary</h4>

                <hr>

                <div class="d-flex justify-content-between mb-3">

                    <span>Thành tiền:</span>

                    <strong class="text-danger fs-5">
                        {{ number_format($total) }}đ
                    </strong>

                </div>
                    @php
                        $canCheckout = true;

                        foreach ($cart as $item) {
                            if (isset($item['stock']) && $item['qty'] > $item['stock']) {
                                $canCheckout = false;
                                break;
                            }
                        }
                    @endphp
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf

                    {{-- ĐỊA CHỈ --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Địa chỉ nhận hàng
                        </label>

                        <textarea 
                            name="address"
                            class="form-control"
                            rows="3"
                            placeholder="Nhập địa chỉ nhận hàng..."
                            required
                        ></textarea>
                    </div>

                    <button class="btn btn-danger w-100"
                        @if(!$canCheckout) disabled @endif>

                        Thanh toán
                    </button>

                </form>

                <a href="/giohang"
                   class="btn btn-outline-secondary w-100 mt-2">
                    Trở lại giỏ hàng
                </a>

            </div>

        </div>

    </div>

</div>

@endsection