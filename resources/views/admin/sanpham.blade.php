@extends('admin.layout')

@section('title', 'Product Edit')

@section('content')

<!-- ================= BREADCRUMB ================= -->

<!-- Breadcome -->
<div class="breadcome-area mb-4">

    <div class="container-fluid">

        <div class="breadcome-list">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <div class="breadcomb-wp d-flex align-items-center">

                        <div class="breadcomb-icon me-3">

                            <i class="bi bi-box-seam-fill"></i>

                        </div>

                        <div class="breadcomb-ctn">

                            <h2>Danh Sách Sản Phẩm</h2>
                        </div>

                    </div>

                </div>

                <div class="col-md-6 text-end">

                    <div class="breadcomb-report">

                        <a href="{{ route('admin.product.create') }}"
                           class="btn btn-primary">

                            <i class="bi bi-plus-circle"></i>

                            Thêm Sản Phẩm

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Product Status -->
<div class="product-status mg-b-30">

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-12">

                <div class="product-status-wrap">

                    <h4>Danh Sách Sản Phẩm</h4>

                    <!-- Search -->
                    <form method="GET" action="" class="mb-4">
                        <div class="row g-3">

                            <!-- Tên sản phẩm -->
                            <div class="col-md-4">
                                <input type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="Tìm tên sản phẩm..."
                                    value="{{ request('name') }}">
                            </div>

                            <!-- Danh mục -->
                            <div class="col-md-3">
                                <select name="category_id" class="form-select">
                                    <option value="">Danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">Trạng thái</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <!-- Button -->
                            <div class="col-md-2">
                                <button class="btn btn-success w-100">
                                    <i class="bi bi-search"></i> Tìm kiếm
                                </button>
                            </div>

                        </div>
                    </form>

                    <!-- Table -->
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="100">
                                    Ảnh
                                </th>

                                <th>
                                    Tên sản phẩm
                                </th>

                                <th>
                                    Danh mục
                                </th>

                                <th>
                                    Giá
                                </th>

                                <th>
                                    Biến thể
                                </th>

                                <th>
                                    Trạng thái
                                </th>

                                <th width="120">
                                    Thao tác
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                        @foreach($products as $product)

                            <tr>

                                <td>
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                        style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                                </td>

                                <td>

                                    {{ $product->name }}

                                </td>

                                <td>

                                    {{ $product->category->name }}

                                </td>

                                <td>

                                    @if($product->sale_price)

                                        <del class="text-muted">

                                            {{ number_format($product->price) }}đ

                                        </del>

                                        <br>

                                        <span class="text-danger fw-bold">

                                            {{ number_format($product->sale_price) }}đ

                                        </span>

                                    @else

                                        <span class="fw-bold">

                                            {{ number_format($product->price) }}đ

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @foreach($product->variants as $variant)

                                        <div class="border-bottom py-1">

                                            {{ $variant->color->name }}
                                            -
                                            {{ $variant->size->size }}

                                            (
                                            Stock:
                                            {{ $variant->stock }}
                                            )

                                        </div>

                                    @endforeach

                                </td>

                                <td>
                                    <select class="form-select form-select-sm status-change"
                                    data-id="{{ $product->id }}"
                                    data-old="{{ $product->status }}">
                                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>
                                        Hoạt động
                                    </option>
                                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>
                                        Ngừng hoạt động
                                    </option>
                                </select>

                                </td>

                                <td style="width:160px; text-align:center; vertical-align:middle;">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        
                                        <a href="{{ route('admin.product.edit', $product->id) }}"
                                        class="btn btn-sm btn-warning d-flex align-items-center justify-content-center">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.product.delete', $product->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                                            class="m-0">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger d-flex align-items-center justify-content-center">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-center mt-4">
                                {{ $products->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@section('scripts')
<script>
$(document).on('change', '.status-change', function () {

    let select = $(this);
    let id = select.data('id');
    let newStatus = select.val();
    let oldStatus = select.data('old');

    if (!confirm('Bạn có chắc muốn đổi trạng thái?')) {
        select.val(oldStatus);
        return;
    }

    $.ajax({
        url: "{{ url('/adm/product/status') }}/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            status: newStatus
        },

        success: function(res) {

            alert(res.message);

            select.data('old', res.status);
            select.val(res.status);
        },

        error: function() {

            alert('Cập nhật thất bại');

            select.val(oldStatus);
        }
    });

});
</script>
@endsection

@endsection