@extends('layouts.layout')
@section('title', 'Tasks')
@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Create Tasks</h5>
        <div class="card-body">
            <form action="{{ route('tasksStore') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Title</label>
                    <input type="title" 
                        name="title"
                        class="form-control @error('title') is-invalid @enderror" id="title" 
                        placeholder="Maximum Effort Project"
                        required
                        value="{{ old('title') }}"
                    >
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Deadline</label>
                    <input class="form-control" type="date" name="deadline" required value="{{ date('Y-m-d') }}" id="html5-date-input" min="{{ date('Y-m-d') }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary">Create</button>
            </form>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Manage Tasks</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Task Manager</th>
                <th># of Todos</th>
                <th>Status</th>
            <th>Deadline</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($tasks as $item)
                    <tr class="table-default">
                        <td><i class="fab fa-sketch fa-lg text-warning me-3"></i> <strong>{{ $item->title }}</strong></td>
                        <td>{{ Auth::user()->name }}</td>
                        <td>{{ $todoListCount[($loop->iteration) - 1] }}</td>
                        <td><span class="badge bg-label-{{config('const.status_color.' . $item->status)}} me-1">{{ config('const.status.' . $item->status) }}</span></span></td>
                        <td><strong class="text-danger">{{ date('M d, Y', strtotime($item->deadline)) }}</strong></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('todos', ['id' => encrypt($item->id)]) }}"><i class="bx bx-edit-alt me-1"></i> Add Todo List</a>
                                <a class="dropdown-item" href="javascript:void(0);" id="delete_task" data-id="{{ encrypt($item->id) }}"><i class="bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
    <script>
        $(document).on('click', '#delete_task', function() {
            let task_id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to proceed with this action?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('tasksDestroy') }}`,
                        method: 'POST',
                        data: {
                            id: task_id
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: `${response.message}`,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        }, error(error) {
                            console.log(error);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                   
                }
            });
           
        });
    </script>
@endsection