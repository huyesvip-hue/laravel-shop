<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <style>
        body{
            background:#152036;
            font-family:'Roboto',sans-serif;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .nk-auth-card{
            background:#1b2a47;
            border-radius:12px;
            width:100%;
            max-width:420px;
            padding:40px;
        }

        .nk-auth-logo{
            font-size:28px;
            font-weight:700;
            color:#fff;
        }

        .nk-auth-logo span{
            color:#03a9f4;
        }

        .form-control{
            background:#152036;
            border:1px solid #253a5c;
            color:#fff;
            border-radius:8px;
        }

        .form-control:focus{
            border-color:#03a9f4;
            box-shadow:none;
        }

        .form-label{
            color:#8a9bb5;
            font-size:13px;
        }

        .btn-login{
            background:#03a9f4;
            border:none;
            color:#fff;
            border-radius:8px;
            padding:10px;
            width:100%;
        }

        .btn-login:hover{
            background:#0290d1;
        }
    </style>
</head>

<body>

<div class="nk-auth-card">

    <div class="text-center mb-4">

        <div class="nk-auth-logo">
            H<span>shop</span>
        </div>

        <p class="text-secondary mt-2">
            Sign in to your account
        </p>

    </div>

    {{-- ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger py-2">
            {{ session('error') }}
        </div>
    @endif

    {{-- LOGIN FORM --}}
    <form action="{{ route('login.submit') }}" method="POST">

        @csrf

        {{-- USERNAME --}}
        <div class="mb-3">

            <label class="form-label">
                Username
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                placeholder="Enter username"
                required
            >

        </div>

        {{-- PASSWORD --}}
        <div class="mb-4">

            <label class="form-label">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Enter password"
                required
            >

        </div>

        <button type="submit" class="btn-login">
            Sign In
        </button>
        <a href="{{ url('/register') }}" class="btn btn-outline-light w-100 mt-2">
            Create account
        </a>

    </form>

</div>

</body>

</html>