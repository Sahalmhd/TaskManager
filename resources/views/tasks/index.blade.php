@extends('layouts.master')

@section('title', 'Task List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Task List</h2>
        <button id="openCreateTaskModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Task
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ ucfirst($task->priority) }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button class="dropdown-item edit-task" data-id="{{ $task->id }}">
                                        <i class="fas fa-edit text-warning"></i> Edit
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item text-danger delete-task" data-id="{{ $task->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>

                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Container -->
    <div id="createTaskModalContainer"></div>

    <div id="editTaskModalContainer"></div>


@endsection

@push('scripts')
    <script>
        $.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

$(document).ready(function() {
    //Task Modal
    $("#openCreateTaskModal").click(function() {
        $.ajax({
            url: "{{ route('tasks.create') }}",
            type: "GET",
            success: function(response) {
                $("#createTaskModalContainer").html(response.view);
                $("#createTaskModal").modal("show");
            },
            error: function() {
                toastr.error("Error loading the form.");
            }
        });
    });

    // Create Task
    $(document).on("submit", "#createTaskForm", function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('tasks.store') }}",
            type: "POST",
            data: $("#createTaskForm").serialize(),
            success: function(response) {
                $("#createTaskModal").modal("hide");
                toastr.success("Task created successfully!");
                setTimeout(() => location.reload(), 1500);
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "";
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + "<br>";
                });
                toastr.error(errorMessage);
            }
        });
    });

    // Edit Task Modal
    $(document).on("click", ".edit-task", function() {
        let taskId = $(this).data("id");

        $.ajax({
            url: "{{ route('tasks.edit', ':id') }}".replace(":id", taskId),
            type: "GET",
            success: function(response) {
                $("#editTaskModalContainer").html(response.view);
                $("#editTaskModal").modal("show");
            },
            error: function() {
                toastr.error("Error loading edit form.");
            }
        });
    });

    // Update Task
    $(document).on("submit", "#editTaskForm", function(e) {
        e.preventDefault();
        let taskId = $(this).data("id");

        $.ajax({
            url: "{{ route('tasks.update', ':id') }}".replace(":id", taskId),
            type: "POST",
            data: $(this).serialize(),
            success: function() {
                $("#editTaskModal").modal("hide");
                toastr.success("Task updated successfully!");
                setTimeout(() => location.reload(), 1500);
            },
            error: function(xhr) {
                toastr.error("Error updating task: " + xhr.responseJSON.message);
            }
        });
    });

    // Delete
    $(document).on("click", ".delete-task", function() {
        let taskId = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This task will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('tasks.destroy', ':id') }}".replace(":id", taskId),
                    type: "POST",
                    data: {
                        _method: "DELETE",
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        toastr.success("Task deleted successfully!");
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function() {
                        toastr.error("Error deleting task.");
                    }
                });
            }
        });
    });
});

    </script>
@endpush
