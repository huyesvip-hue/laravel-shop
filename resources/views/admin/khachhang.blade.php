@extends('admin.layout')
@section('content')

<!-- Breadcome -->
<div class="breadcome-area mb-4">
    <div class="container-fluid">
        <div class="breadcome-list">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <div class="breadcomb-wp d-flex align-items-center">

                        <div class="breadcomb-icon me-3">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div class="breadcomb-ctn">
                            <h2>Danh Sách Khách Hàng</h2>
                        </div>

                    </div>

                </div>

                <div class="col-md-6 text-end">

                    <div class="breadcomb-report">

                        <a href="{{ route('admin.khachhang') }}"
                           class="btn btn-primary">

                            <i class="bi bi-plus-circle"></i>
                            Thêm Khách Hàng

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

                    <h4>Danh Sách Khách Hàng</h4>

                    <!-- Search -->
                    <form method="GET" action="" class="mb-4">
                        <div class="mb-4">
                            <div class="row g-3">
                                <!-- Tên -->
                                <div class="col-md-4">
                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        placeholder="Tìm tên khách hàng..."
                                        value="{{ request('name') }}">
                                </div>

                                <!-- Email -->
                                <div class="col-md-4">
                                    <input type="text"
                                        name="email"
                                        class="form-control"
                                        placeholder="Tìm email..."
                                        value="{{ request('email') }}">
                                </div>

                                <!-- Role -->
                                <div class="col-md-2">
                                    <select name="role" class="form-select">
                                        <option value="">Role</option>
                                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>
                                            Customer
                                        </option>
                                    </select>
                                </div>

                                <!-- Button -->
                                <div class="col-md-2">
                                    <button class="btn btn-success w-100">
                                        <i class="bi bi-search"></i>
                                        Tìm kiếm
                                    </button>
                                </div>

                            </div>

                        </div>

                    </form>

                    <!-- Table -->
                    <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Ngày tạo</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($users as $user)

                        <tr>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>

                                @if($user->role?->name == 'admin')

                                    <button class="pd-setting">
                                        Admin
                                    </button>

                                @else

                                    <button class="ps-setting">
                                        Customer
                                    </button>

                                @endif

                            </td>

                            <td>
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>

                            <td class="d-flex gap-2">

                                <a href="{{ route('admin.edit', $user->id) }}"
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="tooltip"
                                    title="Edit">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form action="{{ route('admin.delete', $user->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip"
                                            title="Delete">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection