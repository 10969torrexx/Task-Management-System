@extends('layouts.layout')
@section('title', 'Teams')
@section('content')
    
    <div class="card">
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
                        <td>{{ $item->title }}</td>
                        <td>
                            <select id="taskAssignment" class="form-select form-select-sm" data-user_id="{{ $item->id }}">
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="button" id="confirm_button" class="btn btn-outline-primary">Confirm</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
    <script>
        $('#confirm_button').on('click', function() {
            let user_id = $('#taskAssignment').data('user_id');
            let task_id = $('#taskAssignment').val();
            $.ajax({
                url: `{{ route('teamsStore') }}`,
                method: 'POST',
                data: {
                    member_id: user_id,
                    task_id: task_id
                },
                success: function(response) {
                    console.log(response);
                }, error(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection