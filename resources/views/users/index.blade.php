@extends('layouts.layout')
@section('title', 'Assigned Tasks')
@section('content')
    <div class="card">
        <h5 class="card-header">Assigned Tasks</h5>
        <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Task Manager</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($tasks as $item)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $loop->iteration }}</strong></td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->taskmanager_name }}</td>
                        <td><span class="badge bg-label-{{config('const.status_color.' . $item->status)}} me-1">{{ config('const.status.' . $item->status) }}</span></td>
                        <td><strong class="text-danger">{{ date('M d, Y', strtotime($item->deadline)) }}</strong></td>
                        <td>
                            <a class="btn btn-outline-primary" href="{{ route('usersTasks', ['id' => $item->id]) }}">View</a>
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
            $.ajax({
                url: `{{ route('tasksDestroy') }}`,
                method: 'POST',
                data: {
                    id: task_id
                },
                success: function(response) {
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