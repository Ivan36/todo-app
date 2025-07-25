<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TODO App - @yield('title', 'Manage Your Tasks')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- SweetAlert2 --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Custom Styles --}}
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .welcome-text {
            color: #28a745;
            font-weight: 500;
        }
        .task-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .task-card.completed {
            border-left-color: #28a745;
            background-color: #f8f9fa;
        }
        .task-card.pending {
            border-left-color: #007bff;
        }
        .btn-toggle {
            transition: all 0.3s ease;
        }
        .btn-toggle:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-light">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-tasks me-2"></i>TODO App
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle welcome-text" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>Welcome, {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button type="button" class="dropdown-item" onclick="confirmLogout()">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-light">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-light">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container py-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-light text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} TODO App. Built with Laravel & Bootstrap. Eng.Ivan</p>
        </div>
    </footer>
    
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

    {{-- Global Scripts --}}
    <script>
        // Logout confirmation dialog
        function confirmLogout() {
            Swal.fire({
                title: 'Logout Confirmation',
                text: 'Are you sure you want to logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-sign-out-alt me-1"></i>Yes, logout',
                cancelButtonText: '<i class="fas fa-times me-1"></i>Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Logging out...',
                        text: 'Please wait',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Create and submit logout form
                    const form = $('<form>', {
                        method: 'POST',
                        action: '{{ route("logout") }}'
                    }).append(
                        $('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: '{{ csrf_token() }}'
                        })
                    );
                    $('body').append(form);
                    form.submit();
                }
            });
        }
    </script>

    {{-- Optional: Add page-specific scripts --}}
    @yield('scripts')
</body>
</html>
