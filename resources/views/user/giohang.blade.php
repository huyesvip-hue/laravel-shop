@extends('user.layoutmain')

@section('content')

<!-- ***** Banner ***** -->
<div class="page-heading" id="top" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-content">
                    <h2>GIỎ HÀNG</h2>
                    <span>Hãy mua sắm các sản phẩm của tôi</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ***** Cart Section ***** -->
<section class="section" id="products" style="background: #f2f2f2">

<div class="container">

    <!-- TITLE -->
    <div class="row">
        <div class="col-lg-12">
            <div class="section-heading text-center">
                <h2>GIỎ HÀNG</h2>
                <span>Tất cả các mặt hàng đã thêm</span>
            </div>
        </div>
    </div>

    <!-- CART LIST -->
    <div class="cart-list">

        @php $grandTotal = 0; @endphp

        @forelse($cart as $id => $item)

            @php $grandTotal += $item['total']; @endphp

            <div class="cart-item">

                <!-- IMAGE -->
                <div class="cart-image">
                    @if(!empty($item['image']))
                        <img src="{{ asset('storage/' . $item['image']) }}">
                    @else
                        <img src="{{ asset('assets/images/no-image.png') }}">
                    @endif
                </div>

                <!-- INFO -->
                <div class="cart-info">
                    <h4>{{ $item['name'] }}</h4>

                    <div class="variant">
                        <span><b>Màu:</b> {{ $item['color'] ?? 'N/A' }}</span>
                        <span><b>Size:</b> {{ $item['size'] ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- PRICE -->
                <div class="cart-price">
                    {{ number_format($item['price']) }}đ
                </div>

                <!-- QTY -->
                <div class="cart-qty">
                    <div class="qty-box">
                        <button class="qty-btn"
                                onclick="changeQty({{ $id }}, -1)">
                            -
                        </button>

                        <span id="qty-{{ $id }}">{{ $item['qty'] }}</span>

                        <button class="qty-btn"
                                onclick="changeQty({{ $id }}, 1, {{ $item['stock'] }})">
                            +
                        </button>
                    </div>
                </div>

                <!-- TOTAL -->
                <div class="cart-total">
                    <span id="total-{{ $id }}">{{ number_format($item['total']) }}đ</span>
                </div>

                <!-- ACTION -->
                <div class="cart-action">

                    <a href="{{ url('/product' . ($item['product_id'] ?? $item['id'] ?? 0)) }}">
                        <i class="fa fa-eye"></i>
                    </a>

                    <button class="delete-btn" onclick="removeItem({{ $id }})">
                        <i class="fa fa-trash"></i>
                    </button>

                </div>

            </div>

        @empty

            <div class="empty-cart">
                <h4>Giỏ hàng trống</h4>
            </div>

        @endforelse

    </div>

    <!-- grand TOTAL -->
    @if(count($cart) > 0)
    <div class="cart-summary">

        <h4>
            Tổng tiền:
            <span id="grandTotal">{{ number_format($grandTotal) }}đ</span>
        </h4>

        <a href="{{ route('checkout.page') }}" class="btn btn-danger mt-3">
            Thanh toán
        </a>
    </div>
@endif

</div>

</section>

<!-- STYLE -->
<style>

.cart-list{margin-top:30px}

.cart-item{
    display:flex;
    align-items:center;
    gap:20px;
    padding:20px;
    border:1px solid #eee;
    border-radius:12px;
    margin-bottom:20px;
    background:#fff;
}

.cart-image img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:10px;
}

.cart-info{flex:1}

.cart-info h4{font-size:18px}

.variant{font-size:14px;color:#666;display:flex;gap:15px}

.cart-price,
.cart-qty,
.cart-total{
    min-width:120px;
    text-align:center;
    font-weight:600;
}

.qty-box{
    display:flex;
    align-items:center;
    gap:10px;
    justify-content:center;
}

.qty-btn{
    width:30px;
    height:30px;
    background:#222;
    color:#fff;
    border:none;
    cursor:pointer;
}

.qty-btn:hover{background:#f33f3f}

.delete-btn{
    margin-left:10px;
    width:42px;
    height:42px;
    background:#f33f3f;
    color:#fff;
    border:none;
    border-radius:50%;
    cursor:pointer;
}

.cart-action a{
    width:42px;
    height:42px;
    background:#222;
    color:#fff;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    text-decoration:none;
}

.cart-summary{
    text-align:right;
    margin-top:30px;
    padding-top:20px;
    border-top:2px solid #eee;
}

.cart-summary h4{font-size:26px}

.cart-summary span{color:red}

.empty-cart{text-align:center;padding:50px}

</style>

<!-- JS -->
<script>

function changeQty(id, type, stock)
{
    let qtyEl = document.getElementById('qty-' + id);

    let qty = parseInt(qtyEl.innerText);

    qty += type;

    // Không nhỏ hơn 1
    if(qty < 1) qty = 1;

    // Không vượt quá tồn kho
    if(qty > stock){
        alert('Đã đạt số lượng tối đa trong kho');
        return;
    }

    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id: id,
            qty: qty
        })
    })
    .then(res => res.json())
    .then(data => {

        if(!data.success) return;

        qtyEl.innerText = data.qty;

        document.getElementById('total-' + id).innerText = data.item_total;

        document.getElementById('grandTotal').innerText = data.grand_total;
    });
}

    function removeItem(id)
    {
        if(!confirm('Bạn có chắc muốn xoá sản phẩm này không?')) return;

        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
</script>

@endsection