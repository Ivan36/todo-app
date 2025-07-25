@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="fas fa-list-check me-2 text-primary"></i>My Tasks
            </h4>
            <span class="badge bg-primary fs-6">{{ $tasks->count() }} Total Tasks</span>
        </div>

        @if($tasks->count() > 0)
            @foreach($tasks as $task)
                <div class="card mb-3 task-card {{ $task->is_complete ? 'completed' : 'pending' }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-1 {{ $task->is_complete ? 'text-decoration-line-through text-muted' : '' }}">
                                @if($task->is_complete)
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                @else
                                    <i class="fas fa-circle text-muted me-2"></i>
                                @endif
                                {{ $task->title }}
                            </h5>
                            @if($task->description)
                                <p class="mb-0 text-muted">{{ $task->description }}</p>
                            @endif
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Created {{ $task->created_at->diffForHumans() }}
                            </small>
                        </div>

                        <div class="d-flex align-items-center gap-2 ms-3">
                            {{-- Toggle Complete --}}
                            <button class="btn btn-sm btn-outline-{{ $task->is_complete ? 'secondary' : 'success' }} toggle-complete-btn btn-toggle"
                                data-id="{{ $task->id }}"
                                data-complete="{{ $task->is_complete ? '1' : '0' }}"
                                title="{{ $task->is_complete ? 'Mark as incomplete' : 'Mark as complete' }}">
                                @if($task->is_complete)
                                    <i class="fas fa-undo me-1"></i>Mark Incomplete
                                @else
                                    <i class="fas fa-check me-1"></i>Mark Complete
                                @endif
                            </button>

                            @auth
                            {{-- Edit Button (modal trigger) --}}
                            <button class="btn btn-sm btn-primary edit-btn" 
                                data-id="{{ $task->id }}"
                                data-title="{{ $task->title }}"
                                data-description="{{ $task->description }}"
                                title="Edit task">
                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- Delete --}}
                            <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="{{ $task->id }}"
                                title="Delete task">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No tasks yet!</h5>
                <p class="text-muted">Create your first task to get started.</p>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Add New Task
                </h5>
            </div>
            <div class="card-body">
                <form id="addTaskForm" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <i class="fas fa-heading me-2"></i>Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               name="title" id="title" required value="{{ old('title') }}"
                               placeholder="What needs to be done?">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-2"></i>Description
                        </label>
                        <textarea class="form-control" name="description" id="description"
                                  rows="3" placeholder="Add more details about your task...">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-plus me-2"></i>Add Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit-description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Edit Modal Setup
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const description = $(this).data('description');

        $('#edit-id').val(id);
        $('#edit-title').val(title);
        $('#edit-description').val(description);
        $('#editForm').attr('action', '/tasks/' + id);
        $('#editModal').modal('show');
    });

    //update Task Form Submission
    $('#editForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function (response) {
                $('#editModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Task Updated',
                    text: response.message || 'Your task has been updated successfully.'
                }).then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update task.'
                });
            }
        });
    });

    // Add Task Form Submission
    $('#addTaskForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '/tasks',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Clear form
                $('#addTaskForm')[0].reset();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Task Added',
                    text: response.message || 'Your task has been added successfully.'
                }).then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                let errorMessage = 'Failed to add task.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    errorMessage = errors.join(' ');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            }
        });
    });

    // Toggle Complete and Incomplete
    $(document).on('click', '.toggle-complete-btn', function () {
        const id = $(this).data('id');
        const currentStatus = $(this).data('complete');
        const isCurrentlyComplete = currentStatus === '1' || currentStatus === 1;
        const newStatus = !isCurrentlyComplete;
        const actionText = isCurrentlyComplete ? 'mark as incomplete' : 'mark as complete';
        
        console.log('Toggle Debug:', {
            id: id,
            currentStatus: currentStatus,
            isCurrentlyComplete: isCurrentlyComplete,
            newStatus: newStatus,
            buttonText: $(this).text().trim()
        });

        // Show confirmation dialog
        Swal.fire({
            title: 'Confirm Action',
            text: `Are you sure you want to ${actionText} this task?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, ${actionText}!`,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/tasks/' + id + '/toggle',
                    method: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_complete: newStatus
                    },
                    success: function (response) {
                        console.log('Server Response:', response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Task Updated',
                            text: response.message
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update task status.'
                        });
                    }
                });
            }
        });
    });

    // Delete Confirmation
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will permanently delete the task.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = $('<form>', {
                    method: 'POST',
                    action: '/tasks/' + id
                }).append(
                    '@csrf',
                    '@method("DELETE")'
                );
                $('body').append(form);
                form.submit();
            }
        });
    });
</script>
@endsection
