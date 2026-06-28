@extends('user.layoutmain')

@section('content')

<!-- ***** Main Banner Area Start ***** -->
<div class="page-heading" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-content">
                    <h2>DANH SÁCH SẢN PHẨM</h2>
                    <span>Chào mừng đến với sản phẩm của shop</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Main Banner Area End ***** -->


<!-- ***** Products Area Starts ***** -->
<section class="section" id="products">

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>SẢN PHẨM </h2>
                    <span>Tất cả các sản phẩm ở đây</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="row">

            @forelse($products as $product)
                @if($product->status == 'active')
                <div class="col-lg-4 col-md-6 mb-4">

                    <div class="item">

                        <!-- IMAGE -->
                        <div class="thumb" style="height: 280px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f8f8;">
                            <div class="hover-content">
                                <ul>
                                    <li>
                                        <a href="/product{{ $product->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>
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
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                    alt="{{ $product->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/images/no-image.png') }}"
                                    alt="No Image"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>

                        <!-- CONTENT -->
                        <div class="down-content">
                            <!-- TÊN + COLOR + SIZE (1 HÀNG) -->
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <!-- TÊN -->
                                <h4 style="margin:0; transform: translateY(-20px);">
                                    {{ $product->name }}
                                </h4>
                                <!-- COLOR + SIZE -->
                                <div style="font-size:18px; color:#666; text-align:right;transform: translateY(-15px)">
                                    @if($product->variants->count() > 0)
                                        @php
                                            $firstVariant = $product->variants->first();
                                        @endphp
                                        <div>
                                            Màu: {{ $firstVariant->color->name ?? 'N/A' }}
                                        </div>
                                        <div>
                                            Size: {{ $firstVariant->size->size ?? 'N/A' }}
                                        </div>
                                    @else
                                        <div>No variant</div>
                                    @endif
                                </div>
                            </div>

                            <!-- GIÁ + THÔNG TIN -->
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:-25px;">
                                <!-- GIÁ -->
                                <div>
                                    @if($product->sale_price)
                                     <span style="color:red; font-weight:bold;">
                                            {{ number_format($product->sale_price) }} đ
                                        </span>
                                        <del style="color:#999; font-size:12px; margin-left:5px;">
                                            {{ number_format($product->price) }} đ
                                        </del>
                                    @else
                                        <span style="font-weight:bold;">
                                            {{ number_format($product->price) }} đ
                                        </span>
                                    @endif
                                </div>

                                <!-- THÔNG TIN PHỤ -->
                                @php
                                    $stock = $product->variants->sum('stock');
                                @endphp

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
                    
                </div>
                    @endif
            @empty

                <div class="col-lg-12 text-center">
                    <h4>Không có sản phẩm</h4>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>

</section>
<!-- ***** Products Area Ends ***** -->
 
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