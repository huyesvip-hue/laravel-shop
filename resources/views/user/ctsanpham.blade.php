@extends('user.layoutmain')

@section('content')

<section class="section" id="product">

<div class="container">
<div class="row">

    <div class="col-lg-8">
        <div style="margin-top:50px;">
            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                 style="width:70%; object-fit:cover; margin-left:200px;">
        </div>
    </div>

    <div class="col-lg-4" style="margin-top:60px;">

            <h4 style="font-weight:800; font-size:22px;">
                {{ $product->name }}
            </h4>

            <div style="margin-bottom:10px;">
                <span style="font-size:22px; font-weight:800; color:#e60000;">
                    {{ number_format($product->sale_price ?? $product->price) }}đ
                </span>

                <div style="margin-top:10px; color:#555; font-size:14px; line-height:1.6;">
                   Mô tả: {!! $product->description !!}
                </div>
            </div>

            @php
                $stock = $product->variants->sum('stock') ?? 0;
                $variantId = $product->variants->first()->id ?? null;
            @endphp

            <div style="margin-top:18px;">
                <h6>Số lượng</h6>

                <div class="quantity">
                    <button type="button" onclick="changeQty(-1)">-</button>

                    <input type="number"
                           id="qty"
                           value="1"
                           min="1"
                           max="{{ $stock }}"
                           oninput="validateQty()">

                    <button type="button" onclick="changeQty(1)">+</button>
                </div>

                <small>Còn: <b>{{ $stock }}</b></small>
            </div>

            <div style="margin-top:15px;">
                <span id="total" style="color:red;font-weight:700;"></span>
            </div>

            <style> .btn-cart { display: inline-block; padding: 10px 22px; border: 1px solid #000; background: #fff; 
            color: #000; text-decoration: none; border-radius: 4px; font-weight: 600; transition: 0.3s; } 
            .btn-cart:hover { background: #000; color: #fff; } </style> 
            <div style="margin-top:12px;"> 
                <a href="#" onclick="addToCart(event)" class="btn-cart"> Thêm vào giỏ hàng </a>
            </div> 

        </div>
    </div>

</div>
</div>

</section>

<!-- ================= SCRIPT ================= -->
<script>
const productPrice = {{ $product->sale_price ?? $product->price ?? 0 }};
const productMaxStock = {{ $stock }};
const productVariantId = {{ $variantId ?? 'null' }};

function changeQty(value) {
    let qtyInput = document.getElementById('qty');
    let newVal = parseInt(qtyInput.value) + value;

    if (newVal < 1) newVal = 1;

    if (newVal > productMaxStock) {
        alert('Đã đạt số lượng tối đa trong kho');
        newVal = productMaxStock;
    }

    qtyInput.value = newVal;
    updateTotal();
}

function validateQty() {
    let qtyInput = document.getElementById('qty');

    if (parseInt(qtyInput.value) > productMaxStock) {
        qtyInput.value = productMaxStock;
        alert('Vượt quá tồn kho');
    }

    if (parseInt(qtyInput.value) < 1) {
        qtyInput.value = 1;
    }

    updateTotal();
}

function updateTotal() {
    let qty = parseInt(document.getElementById('qty').value);
    let total = qty * productPrice;

    document.getElementById('total').innerText =
        total.toLocaleString('vi-VN') + 'đ';
}

function addToCart(event) {
    event.preventDefault();

    let qty = parseInt(document.getElementById('qty').value);

    if (!productVariantId) {
        alert('Sản phẩm không có biến thể');
        return;
    }

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_variant_id: productVariantId,
            qty: qty
        })
    })
    .then(res => res.json())
    .then(data => {

        if (!data.success) {
            alert(data.message || 'Không thể thêm vào giỏ');
            return;
        }

        alert('Thêm vào giỏ hàng thành công');
    });
}

updateTotal();
</script>
@endsection