<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('admin/css/trangadmin.css')}}">
</head>
<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">

    <div class="logo">
        H-SHOP
    </div>

    <div class="menu">
        <a href="/adm">
            <i class="bi bi-speedometer2"></i> Trang chủ
        </a>

        <a href="{{ route('admin.sanpham') }}">Sản phẩm</a>

        <a href="{{ route('admin.khachhang.index') }}"> Khách Hàng</a>

        <a href="{{ route('admin.orderadmin') }}">
            <i class="bi bi-envelope"></i> orders
        </a>
    </div>

</div>

<!-- ================= MAIN ================= -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="d-flex align-items-center gap-4">
            <i class="bi bi-bell fs-5"></i>
            <i class="bi bi-envelope fs-5"></i>

            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                    Admin
                </button>

                <ul class="dropdown-menu dropdown-menu-dark">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <!-- ================= CONTENT ĐỘNG ================= -->
    <div class="p-3">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
</body>
</html>

</body>
</html>