
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Alternative Attendance System for tracking and managing employee attendance for PENRO Marinduque">

    <title>Alternative Attendance System</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favico.ico" type="image/x-icon">
    <link rel="icon" href="images/favico.ico" type="image/x-icon">
    <!-- <link rel="apple-touch-icon" href="images/DENR-LOGO.jpg"> -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="{{ asset('adminlte3/dist/img/favico.ico') }}" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(135deg, rgba(238, 242, 247, 0.8), rgba(208, 225, 249, 0.8)), url({{ asset('1.jpg') }}) no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        

        .card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 2.5rem;
            color: #198754;
            margin-bottom: 1rem;
        }

       

        .logo-text {
            color: #2c3e50;
            font-weight: 600;
        }
        
        .user-info {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.9);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .action-buttons {
            margin-top: 2rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <!-- Logo Section -->
        @include('components.header1')
        @include('components.title1')
        
        <div class="mx-auto d-flex justify-content-center action-buttons">
            @auth
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-primary">Enter</a>&nbsp;
            @endauth
            @guest
                <a href="{{ route('auth.login') }}" class="btn btn-primary ">Login</a>&nbsp;
            @endguest
            <a href="{{ route('suppliers.register') }}" class="btn btn-outline-primary ">Register Supplier</a>
        </div>

        
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>