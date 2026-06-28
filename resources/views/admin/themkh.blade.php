@extends('admin.layout')

@section('title', 'Thêm Khách Hàng')

@section('content')

<div class="container-fluid">

    <div class="product-status-wrap">

        <h4>Thêm Khách Hàng</h4>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ isset($user)
            ? route('admin.update', $user->id)
            : route('admin.store') }}"
        method="POST">

        @csrf

        @if(isset($user))
            @method('PUT')
        @endif

            <div class="mb-3">

                <label>Tên khách hàng</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label>Mật khẩu</label>

                <input type="password"
                       name="password"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label>Role</label>

                <select name="role_id"
                        class="form-select">

                    <option value="1">
                        Admin
                    </option>

                    <option value="2">
                        Customer
                    </option>

                </select>

            </div>

            <button type="submit"
                    class="btn btn-success">

                <i class="bi bi-save"></i>
                Lưu Khách Hàng

            </button>

        </form>

    </div>

</div>

@endsection