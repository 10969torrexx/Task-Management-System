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
                <h5><strong class="text-danger">{{ date('M d, Y', strtotime($tasks->deadline)) }}</strong></h5>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Date Created</label>
                <h5><strong>{{ date('M d, Y', strtotime($tasks->created_at)) }}</strong></h5>
            </div>
            <div class="mb-3">
                <label for="defaultSelect" class="form-label">Task Status</label>
                <select id="task_status" class="form-select">
                    <option selected>{{ config('const.status.'. ($tasks->status)) }}</option>
                    @foreach (config('const.status') as $item)
                        @if (!(($loop->iteration) - 1 == 0))
                            <option value="{{ $loop->iteration - 1 }}">{{ config('const.status.'. ($loop->iteration - 1)) }}</option>
                        @endif
                    @endforeach
                </select>
              </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Todo List</h5>
        <div class="card-body">
            <div class="mb-3 px-4">
               @foreach ($todoLists as $item)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="todolist_checker" data-id="{{ $item->id }}" @if($item->accomplished_flg == 1) checked @endif>
                        <label class="form-check-label" for="defaultCheck3"> {{ $item->name }} </label>
                    </div>
               @endforeach
            </div>
        </div>
    </div>
    <script>
        $(document).on('change', '#task_status', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: `{{ route('updateTasksStatus') }}`,
                method: 'POST',
                data: {
                    id: {{ $tasks->id }},
                    status : $('#task_status').val()
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        location.reload();
                    }
                }, error(error) {
                    console.log(error);
                }
            });
        });
        
        $(document).on('change', '#todolist_checker', function(e) {
            let isChecked = 0;
            let todoId = $(this).data('id')
            e.preventDefault();
            if ($(this).is(':checked')) {
               isChecked = 1;
            } else {
                isChecked = 0;
            }
            $.ajax({
                url: `{{ route('updateTodoStatus') }}`,
                method: 'POST',
                data: {
                    id: todoId,
                    accomplished_flg : isChecked
                },
                success: function(response) {
                    console.log(response);
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