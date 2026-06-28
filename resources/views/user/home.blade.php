@extends('user.layoutmain')

@section('content')

<!-- ***** Main Banner Area Start ***** -->
<div class="main-banner" id="top">
    <div class="container-fluid">
        <div class="row">

            <!-- LEFT BANNER -->
            <div class="col-lg-6">
                <div class="left-content">
                    <div class="thumb">
                        <div class="inner-content">
                            <h4>THỜI TRANG XU HƯỚNG 2026</h4>

                            <span>
                                Hàng mới mỗi ngày - Giá tốt - Freeship toàn quốc
                            </span>

                            <div class="main-border-button">
                                <a href="/san_pham">
                                    Mua Ngay
                                </a>
                            </div>
                        </div>

                        <img src="{{ asset('assets/images/cac-loai-giay-nam.jpg') }}">
                    </div>
                </div>
            </div>

            <!-- RIGHT CATEGORY -->
            <div class="col-lg-6">
                <div class="right-content">
                    <div class="row">

                        @foreach($categories->take(3) as $index => $category)

                        <div class="col-lg-6">
                            <div class="right-first-image">
                                
                                <div class="thumb">

                                    <div class="inner-content">
                                        <h4>{{ $category->name }}</h4>

                                        <span>
                                            Sản phẩm mới nhất
                                        </span>
                                    </div>

                                    <div class="hover-content">
                                        <div class="inner">
                                            <h4>{{ $category->name }}</h4>

                                            <p>
                                                Khám phá bộ sưu tập mới nhất
                                            </p>

                                            <div class="main-border-button">
                                                <a href="/san_pham?category_id={{ $category->id }}">
                                                    Xem ngay
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <img src="{{ asset('assets/images/image0' . ($index + 1) . '.jpg') }}" class="img-fluid">

                                </div>
                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ***** Main Banner Area End ***** -->


<!-- ***** Latest Products Start ***** -->
<section class="section" id="products">

    <div class="container">

        <!-- TITLE -->
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2>Sản Phẩm Mới Nhất</h2>

                    <span>
                        Các sản phẩm thời trang nổi bật của shop
                    </span>
                </div>
            </div>
        </div>

        <!-- PRODUCTS -->
        <div class="row">

            @forelse($products as $product)

                @php
                    $variant = $product->variants->first();
                    $stock = $product->variants->sum('stock');
                @endphp

                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="item shadow-sm rounded">

                        <!-- IMAGE -->
                        <div class="thumb position-relative"
                             style="height:320px; overflow:hidden;">

                            {{-- SALE --}}
                            @if($product->sale_price)
                                <div class="sale">
                                    SALE
                                </div>
                            @endif

                            {{-- ACTION --}}
                            <div class="hover-content">
                                <ul>

                                    <!-- DETAIL -->
                                    <li>
                                        <a href="/product{{ $product->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>

                                    <!-- CART -->
                                    <li>
                                        @php
                                            $variant = $product->variants->first();
                                        @endphp

                                        <a href="/cart/add"
                                        class="{{ !$variant || $variant->stock <= 0 ? 'disabled-cart' : '' }}"
                                        @if($variant && $variant->stock > 0)
                                                onclick="addToCart(event, {{ $variant->id }})"
                                        @else
                                                onclick="event.preventDefault(); alert('Sản phẩm đã hết hàng');"
                                        @endif>

                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            {{-- IMAGE --}}
                            @if($product->thumbnail)

                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                    alt="{{ $product->name }}"
                                    style="width:100%; height:280px; object-fit:contain; background:#f8f8f8;">

                            @else

                                <img src="{{ asset('assets/images/no-image.png') }}"
                                    alt="No image"
                                    style="width:100%; height:100%; object-fit:cover;">

                            @endif

                        </div>

                        <!-- CONTENT -->
                        <div class="down-content p-3">

                            <!-- NAME -->
                            <h4 style="
                            font-size:18px;
                            min-height:50px;
                            font-weight:600;">
                            {{ $product->name }}
                        </h4>

                            <!-- CATEGORY -->
                            <div style="
                                color:#777;
                                font-size:16px;
                                margin-bottom:8px;
                                
                            ">
                                {{ $product->category->name ?? 'Không có loại' }}
                            </div>

                            <!-- COLOR SIZE -->
                            @if($variant)

                                <div style="font-size:14px; color:#666; margin-bottom:10px;">

                                    <div>Màu: <b>{{ $variant->color->name ?? 'N/A' }}</b></div>

                                    <div>Size: <b>{{ $variant->size->size ?? 'N/A' }}</b></div>

                                </div>

                            @endif

                            <!-- PRICE -->
                            <div class="mb-2">

                                @if($product->sale_price)

                                    <span style="
                                        color:red;
                                        font-weight:bold;
                                        font-size:18px;
                                    ">
                                        {{ number_format($product->sale_price) }} đ
                                    </span>

                                    <br>

                                    <del style="
                                        color:#999;
                                        font-size:14px;
                                    ">
                                        {{ number_format($product->price) }} đ
                                    </del>

                                @else

                                    <span style="
                                        font-weight:bold;
                                        font-size:18px;
                                    ">
                                        {{ number_format($product->price) }} đ
                                    </span>

                                @endif

                            </div>

                            <!-- STOCK -->
                            <div style="
                                font-size:14px;
                                color:{{ $stock > 0 ? 'green' : 'red' }};">

                                @if($stock > 0)

                                    Còn hàng: {{ $stock }}

                                @else

                                    Hết hàng

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-lg-12 text-center">

                    <h4>Không có sản phẩm</h4>

                </div>

            @endforelse

        </div>

    </div>

</section>
<!-- ***** Latest Products End ***** -->


<!-- ***** Explore Area Starts ***** -->
<section class="section" id="explore">

    <div class="container">

        <div class="row">

            <div class="col-lg-6">

                <div class="left-content">

                    <h2>Khám Phá Bộ Sưu Tập</h2>

                    <span>
                        Các mẫu thời trang hot trend mới nhất dành cho bạn.
                    </span>

                    <div class="quote">
                        <i class="fa fa-quote-left"></i>

                        <p>
                            Chất lượng tạo nên thương hiệu.
                        </p>
                    </div>

                    <p>
                        Hàng ngàn sản phẩm đang chờ bạn khám phá.
                    </p>

                    <div class="main-border-button">
                        <a href="/san_pham">
                            Xem tất cả sản phẩm
                        </a>
                    </div>

                </div>

            </div>


            <div class="col-lg-6">

                <div class="right-content">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="first-image">
                                <img src="{{ asset('assets/images/banner-giay-dep.jpg') }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="second-image">
                                <img src="{{ asset('assets/images/giaynam.jpg') }}">
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</section>
<!-- ***** Explore Area Ends ***** -->


<!-- ***** Subscribe Area Starts ***** -->
<div class="subscribe">
    <div class="container">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-6">
                        <ul>
                            <li>
                                Địa chỉ:<br>
                                <span>AN GIANG</span>
                            </li>

                            <li>
                                Hotline:<br>
                                <span>0123 456 789</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-6">
                        <ul>
                            <li>
                                Giờ mở cửa:<br>
                                <span>08:00 - 22:00</span>
                            </li>

                            <li>
                                Facebook:<br>
                                <span>Shop Fashion</span>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>

    </div>


<!-- ***** Subscribe Area Ends ***** -->
<script>
function addToCart(event, product_variant_id) {

    event.preventDefault();

    fetch('/cart/add', {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },

        body: JSON.stringify({
            product_variant_id: product_variant_id,
            qty: 1
        })

    })

    .then(res => res.json())

    .then(data => {

        window.location.href = "/giohang";

    });

}
</script>
@endsection