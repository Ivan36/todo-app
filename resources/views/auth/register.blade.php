@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Name Field --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autocomplete="name" 
                               autofocus
                               placeholder="Enter your full name">
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Email Field --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="email"
                               placeholder="Enter your email address">
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               placeholder="Create a secure password">
                        @error('password')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Confirm Password Field --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>Confirm Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               placeholder="Confirm your password">
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                    </div>
                </form>

                {{-- Login Link --}}
                <div class="text-center mt-3">
                    <p class="mb-0">Already have an account?</p>
                    <a href="{{ route('login') }}" class="btn btn-link">
                        <i class="fas fa-sign-in-alt me-1"></i>Login here
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
            $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2"></i>Creating Account...');
        });
    });
</script>
@endsection
