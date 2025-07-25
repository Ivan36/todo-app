@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user me-2"></i>My Profile
                </h4>
            </div>
            <div class="card-body p-4">
                
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <div class="row">
                    {{-- Profile Information --}}
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Profile Information
                                </h5>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-user me-2"></i>Full Name
                                    </label>
                                    <p class="form-control-plaintext">{{ auth()->user()->name }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-envelope me-2"></i>Email Address
                                    </label>
                                    <p class="form-control-plaintext">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar me-2"></i>Member Since
                                    </label>
                                    <p class="form-control-plaintext">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-tasks me-2"></i>Total Tasks
                                    </label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-primary fs-6">{{ auth()->user()->tasks()->count() }} Tasks</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Update Profile Form --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-edit me-2 text-success"></i>Update Profile
                                </h5>

                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('PATCH')

                                    {{-- Name Field --}}
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-user me-2"></i>Full Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', auth()->user()->name) }}" 
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Email Field --}}
                                    <div class="mb-4">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-2"></i>Email Address <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', auth()->user()->email) }}" 
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Submit Button --}}
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-save me-2"></i>Update Profile
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Password Change Section --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h5 class="card-title text-warning">
                                    <i class="fas fa-lock me-2"></i>Change Password
                                </h5>

                                <form method="POST" action="{{ route('profile.password') }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">
                                                    <i class="fas fa-key me-2"></i>Current Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" 
                                                       class="form-control @error('current_password') is-invalid @enderror" 
                                                       id="current_password" 
                                                       name="current_password" 
                                                       required>
                                                @error('current_password')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">
                                                    <i class="fas fa-lock me-2"></i>New Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" 
                                                       class="form-control @error('password') is-invalid @enderror" 
                                                       id="password" 
                                                       name="password" 
                                                       required>
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">
                                                    <i class="fas fa-lock me-2"></i>Confirm Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" 
                                                       class="form-control" 
                                                       id="password_confirmation" 
                                                       name="password_confirmation" 
                                                       required>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-key me-2"></i>Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                            </a>
                            
                            <button type="button" class="btn btn-danger" onclick="confirmDeleteAccount()">
                                <i class="fas fa-user-times me-2"></i>Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDeleteAccount() {
        Swal.fire({
            title: 'Delete Account?',
            text: 'This action cannot be undone. All your tasks will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete my account',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit form for account deletion
                const form = $('<form>', {
                    method: 'POST',
                    action: '{{ route("profile.delete") }}'
                }).append(
                    '@csrf',
                    '@method("DELETE")'
                );
                $('body').append(form);
                form.submit();
            }
        });
    }

    // Add loading state to forms
    $(document).ready(function() {
        $('form').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...').prop('disabled', true);
        });
    });
</script>
@endsection
