@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="fas fa-sign-in-alt me-2"></i>Welcome Back
                </h4>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email Field --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email Address <span class="text-danger">*</span>
                        </label>
                        <input id="email" 
                               type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="Enter your email address">
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password <span class="text-danger">*</span>
                        </label>
                        <input id="password" 
                               type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" 
                               required
                               placeholder="Enter your password">
                        @error('password')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>

                {{-- Register Link --}}
                <div class="text-center mt-3">
                    <p class="mb-0">Don't have an account?</p>
                    <a href="{{ route('register') }}" class="btn btn-link">
                        <i class="fas fa-user-plus me-1"></i>Register here
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add some visual feedback for form validation
    $(document).ready(function() {
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2"></i>Logging in...');
        });
    });
</script>
@endsection
