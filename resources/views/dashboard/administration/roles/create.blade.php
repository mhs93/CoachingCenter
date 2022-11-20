@extends('layouts.dashboard.app')

@section('title', 'Role create')

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
        <div class="card-header d-flex justify-content-between">
            <p class="m-0">Create Role With Permissions</p>
            <a class="btn btn-sm btn-info" href="{{ route('admin.roles.index') }}">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role">Role name</label>
                    <input type="text" class="form-control mt-2" id="role" name="name" placeholder="Enter Role Name" required>
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
                                            >
                                            <label for="permissions-{{ $permission->id }}"
                                                   class="form-check-label">{{ $permission->title }}</label>
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
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mb-5"></div>
@endsection

