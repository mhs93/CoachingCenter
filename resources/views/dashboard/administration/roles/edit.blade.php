@extends('layouts.dashboard.app')

@section('title', 'Role edit')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.roles.index') }}">Role List</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Edit Role With Permissions</p>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="role">Role name</label>
                    <input type="text" class="form-control" id="role" name="role"
                           value="{{ $role->name }}" placeholder="Insert Role">
                    <input type="hidden" name="id" value="{{$role->id}}" required>
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <hr>

                @forelse ($modules->chunk(2) as $key=>$chunks)
                    <div class="row">
                        @foreach ($chunks as $key=>$module)
                            <div class="col-md-6">
                                <h5>Module: {{ $module->name }}</h5>
                                @foreach ($module->permissions as $key=>$permission)
                                    <div class="mb-3 ml-4">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="form-check-input"
                                                   id="permissions-{{ $permission->id }}"
                                                   name="permissions[]"
                                                   value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $rPermission)
                                                {{ $permission->id == $rPermission->id ? 'checked' : '' }}
                                                @endforeach
                                            >
                                            <label for="permissions-{{ $permission->id }}"
                                                   class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div class="row">
                        <div class="col text-center">
                            <strong>No module found.</strong>
                        </div>
                    </div>
                @endforelse

                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mb-5"></div>
@endsection

