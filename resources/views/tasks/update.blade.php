@extends('layouts.layout')
@section('title', 'Tasks')
@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Created Tasks</h5>
        <div class="card-body">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Title</label>
                <h5>{{ $tasks->title }}</h5>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Deadline</label>
                <h5><strong class="text-danger">{{ date('M d, Y H:i:s', strtotime($tasks->deadline)) }}</strong></h5>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Date Created</label>
                <h5><strong>{{ date('M d, Y H:i:s', strtotime($tasks->created_at)) }}</strong></h5>
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Todo List</h5>
        <div class="card-body">
            <div class="mb-3 px-4">
                <form action="{{ route('todoListsStore') }}" method="POST"> @csrf
                    <div class="input-group">
                        <input type="text" value="{{ $tasks->id }}" name="task_id" class="form-control d-none">
                        <input type="text" id="todo_name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('email') }}" required placeholder="Todo name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button class="btn btn-outline-primary" type="submit" id="button-add">Add</button>
                    </div>
                </form>
            </div>
            <div class="mb-3 px-4">
               <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Todo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($todoLists as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-right">
                                    <button class="btn btn-outline-danger float-right" id="delete_todo" data-id="{{ encrypt($item->id) }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
               </table>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '#delete_todo', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: `{{ route('todoListsDestroy') }}`,
                method: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == 200) {
                        location.reload();
                    }
                }, error(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection