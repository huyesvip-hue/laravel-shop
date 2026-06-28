<!-- layouts/main-layout.html -->

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>H shop!</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/lightbox.css">

    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
<!--

TemplateMo 571 Hexashop

https://templatemo.com/tm-571-hexashop

-->

    </head>
    
    <body class="site-body">
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav" style="margin-left: -100px;">

                    <!-- LOGO -->
                    <a href="/" class="logo">
                        <img src="assets/images/logo.png" alt="Logo">
                    </a>

                    <!-- MENU -->
                    <ul class="nav">

                        <li class="scroll-to-section dropdown">
                            <a href="/san_pham" class="main-link">
                                SẢN PHẨM ▼
                            </a>

                            <!-- HOVER: xổ danh mục -->
                            <ul class="dropdown-menu">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="/san_pham?category_id={{ $category->id }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="scroll-to-section">
                            <a href="/giohang">GIỎ HÀNG</a>
                        </li>

                        <li class="scroll-to-section">
                            <a href="/donhang">ĐƠN HÀNG</a>
                        </li>

                    </ul>

                    
                    <div class="header-icons" style="margin-left: 40px;">
                        <form action="{{ url('/search') }}" method="GET" class="search-box d-flex">
                            <input type="text"
                                name="keyword"
                                placeholder="Tìm sản phẩm hoặc loại"
                                style="padding:5px 10px; border:1px solid #ccc; border-radius:3px;">

                            <button type="submit"
                                    style="margin-left:5px; padding:5px 10px; background:#000; color:#fff; border:none;">
                                🔍
                            </button>
                        </form>

                        <!-- CART -->
                        <a href="/giohang" class="icon-btn">
                            <i class="fa fa-shopping-cart"></i>
                        </a>

                        <!-- LOGIN -->
                        @auth
                        <div class="d-inline-flex align-items-center gap-2 icon-btn">
                            <i class="fa fa-user"></i>
                            <span >> {{ Auth::user()->name }} </span>

                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="ms-2 btn btn-link text-danger p-0" style="font-size:20px;">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ url('/dangnhap') }}" class="icon-btn">
                            <i class="fa fa-user"></i>
                        </a>
                    @endauth

                    </div>
                    
                </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->
    <!-- ================= MAIN CONTENT ================= -->

        <main>
            @yield('content')
        </main>

    <!-- ================= FOOTER ================= -->
   <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="first-item">
                        <div class="logo">
                            <img src="assets/images/white-logo.png" alt="hexashop ecommerce templatemo">
                        </div>
                        <ul>
                            <li><a href="#">An Giang</a></li>
                            <li><a href="#">shopgiay@company.com</a></li>
                            <li><a href="#">010-020-0340</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="under-footer">
                        <p>Copyright © 2026 Shop giày.
                        
                        <br>Liên hệ: <a href="#" target="_parent" title="free css templates">Thông tin</a></p>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ================= SCRIPTS ================= -->

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/accordions.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    <script src="assets/js/slick.js"></script> 
    <script src="assets/js/lightbox.js"></script> 
    <script src="assets/js/isotope.js"></script> 
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>

    <script>
    function toggleDropdown() {
        document.getElementById("dropdownMenu").classList.toggle("show");
    }

    // click ra ngoài thì đóng
    document.addEventListener("click", function(event) {
        const dropdown = document.querySelector(".dropdown");
        const menu = document.getElementById("dropdownMenu");

        if (!dropdown.contains(event.target)) {
            menu.classList.remove("show");
        }
    });
    </script>
<style>
    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #fff;
        min-width: 200px;
        list-style: none;
        padding: 0;
        margin: 0;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        z-index: 9999;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    /* hover item */
    .dropdown-menu li a:hover {
        background: rgba(0,0,0,0.1);
    }

    /* hover SẢN PHẨM */
    .dropdown:hover .dropdown-toggle {
        background: rgba(0,0,0,0.1);
        border-radius: 5px;
    }
</style>
</body>

</html>