@extends('admin.layout')

@section('title', 'Thêm Sản Phẩm')

@section('content')

<div class="breadcome-area mb-4">

    <div class="container-fluid">

        <div class="breadcome-list">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h2>Thêm Sản Phẩm</h2>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-12">

            <div class="card p-4">

                <form action="{{ isset($product)
                    ? route('admin.product.update', $product->id)
                    : route('admin.product.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @if(isset($product))
                        @method('PUT')
                    @endif

                    <!-- NAME -->
                    <div class="mb-3">

                        <label>Tên sản phẩm</label>

                        <input type="text"
                            name="name"
                            class="form-control"
                            value="{{ $product->name ?? '' }}"
                            required>

                    </div>

                    <!-- CATEGORY -->
                    <div class="mb-3">

                        <label>Danh mục</label>

                        <select name="category_id" class="form-select" required>

                            <option value="">-- Chọn danh mục --</option>

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- PRICE -->
                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Giá gốc</label>

                            <input type="number"
                                name="price"
                                class="form-control"
                                value="{{ $product->price ?? '' }}"
                                required>

                        </div>

                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mb-3">

                        <label>Mô tả</label>

                        <textarea name="description"
                            class="form-control"
                            rows="4">{{ $product->description ?? '' }}</textarea>

                    </div>

                    <!-- THUMBNAIL -->
                    <div class="mb-3">

                        <label>Ảnh đại diện</label>

                        <input type="file"
                            name="thumbnail"
                            class="form-control">
                            @if(isset($product) && $product->thumbnail)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" width="100">
                                </div>
                            @endif
                    </div>

                    <!-- VARIANTS (COLOR + SIZE + STOCK) -->
                    <h5 class="mt-4">Biến thể sản phẩm</h5>

                    <div class="row">

                        <div class="col-md-4">

                            <label>Màu sắc</label>

                            <select name="color_id" class="form-select">

                                @foreach($colors as $color)

                                    <option value="{{ $color->id }}">
                                        {{ $color->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-4">

                            <label>Size</label>

                            <select name="size_id" class="form-select">

                                @foreach($sizes as $size)

                                    <option value="{{ $size->id }}">
                                        {{ $size->size }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-4">

                            <label>Số lượng</label>

                            <input type="number"
                                   name="stock"
                                   class="form-control"
                                   value="0">

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="mt-4">

                        <button type="submit" class="btn btn-success">

                            <i class="bi bi-save"></i>
                            Lưu sản phẩm

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection