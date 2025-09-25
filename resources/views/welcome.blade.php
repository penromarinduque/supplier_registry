
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

        .logo-container img {
            max-width: 140px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.05);
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

        .main-title {
            color: #2c3e50;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }

        .main-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60%;
            height: 3px;
            background: #198754;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
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
        <div class="logo-container text-center mb-5">
            <div class="row justify-content-center">
                <img src="{{ asset('LOGO.png')}}" alt="DENR Logo" class="img-fluid mb-3">
                <img src="{{ asset('Bagong_Pilipinas_logo.png')}}" alt="Bagong Pilipinas Logo" class="img-fluid mb-3">
            </div>
            <h4 class="logo-text mb-2">Department of Environment and Natural Resources</h4>
            <h5 class="logo-text mb-4">PENRO MARINDUQUE</h5>
        </div>

        <div class="text-center mb-5">
            <h2 class="main-title">Online Attendance System</h2>
            <h5>(For Alternative Working Arrangement)</h5>
        </div>

        <!-- Cards Section -->
        <div class="row justify-content-center g-4">
            <!-- Main Building Card -->
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('timein', ['division' => 'main']) }}" class="text-decoration-none">
                    <div class="card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-building card-icon"></i>
                            <h4 class="card-title text-dark">Office of the PENRO & Management Services Division</h4>
                        </div>
                    </div>
                </a>
            </div>

            <!-- TSD Building Card -->
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('timein', ['division' => 'tsd']) }}" class="text-decoration-none">
                    <div class="card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-house-gear card-icon"></i>
                            <h4 class="card-title text-dark">Technical Services Division</h4>
                        </div>
                    </div>
                </a>
            </div>

            <!-- PAMO Card -->
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('timein', ['division' => 'pamo']) }}" class="text-decoration-none">
                    <div class="card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-buildings card-icon"></i>
                            <h4 class="card-title text-dark">Protected Area Management Office</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>