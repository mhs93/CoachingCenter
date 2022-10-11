@extends('layouts.dashboard.app')

@section('title', 'Bank')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex  align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
        </ol>

        <a href="{{ route('admin.bank.create') }}" class="btn btn-sm btn-info">Create bank</a>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Bank</p>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">SL No</th>
                    <th scope="col">Bank Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($banks as $bank)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $bank->bank_name }}</td>
                        
                        <td><input onclick="statusConfirm(' . $bank->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $bank->id . '" getAreaid="' . $bank->id . '" name="status"></td>
                        <td>

                            <a href="{{route('admin.bank.edit',$bank->id)}}" class="btn btn-success btn-sm" ><i class='bx bx-edit-alt'></i></a>

                            <form class="col-6 d-inline" action="{{ route('admin.bank.destroy', $bank->id) }}"  onclick="return confirm('Are you sure Delete this payment category?')" method="POST" >
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm"><i class='bx bx-trash' ></i></button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <div class="alert alert-warning" role="alert">
                        No data here
                    </div>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('jquery/jQuery.js') }}"></script>
        <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- sweetalert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        
    @endpush
@endsection
