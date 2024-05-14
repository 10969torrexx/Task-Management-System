@extends('layouts.layout')
@section('title', 'Teams')
@section('content')
    
    <div class="card mb-3">
        <h5 class="card-header">Members</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Current Task</th>
                <th>New Task</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($members as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ !empty($item->title) ? $item->title : config('const.not_assigned') }}</td>
                        <td>
                            @if (!empty($tasks) && count($tasks) > 0)
                                <select id="taskAssignment" class="form-select form-select-sm" data-user_id="{{ $item->id }}">
                                    @foreach ($tasks as $task)
                                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                                    @endforeach
                                </select>
                            @else
                                {{ config('const.no_task') }} 
                            @endif
                        </td>
                        <td>
                            <button type="button" id="confirm_button" class="btn btn-outline-primary" data-user_id="{{ $item->id }}">Confirm</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>

    <div class="card mb-3">
        <h5 class="card-header">Task Assignment</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Task</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($taskAssigned as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->assigned_to_name }}</td>
                        <td>{{ $item->user_email }}</td>
                        <td>{{ !empty($item->title) ? $item->title : config('const.not_assigned') }}</td>
                        <td><span class="badge bg-label-primary me-1">{{ config('const.status.'.$item->status) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>


    <script>
        $(document).on('click', '#confirm_button', function() {
            let user_id = $(this).data('user_id');
            let task_id = $('#taskAssignment').val();
            $.ajax({
                url: `{{ route('tasksAssignTask') }}`,
                method: 'POST',
                data: {
                    assigned_to: user_id,
                    task_id: task_id
                },
                success: function(response) {
                    console.log(response);
                    if (response.status === 200) {
                        location.reload();
                    }
                }, error(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection