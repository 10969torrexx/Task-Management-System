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
                    <input class="form-control @error('deadline') is-invalid @enderror" id="deadline"  type="datetime-local" value="" name="deadline" id="html5-datetime-local-input">
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
                <th>Members</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($tasks as $item)
                    <tr class="table-default">
                        <td><i class="fab fa-sketch fa-lg text-warning me-3"></i> <strong>{{ $item->title }}</strong></td>
                        <td>{{ Auth::user()->name }}</td>
                        <td>
                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Lilian Fuller">
                                <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                                </li>
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Sophia Wilkerson">
                                <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                                </li>
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Christina Parker">
                                <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                                </li>
                            </ul>
                        </td>
                        <td><span class="badge bg-label-primary me-1">{{ config('const.status.'.$item->status) }}</span></td>
                        <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
@endsection