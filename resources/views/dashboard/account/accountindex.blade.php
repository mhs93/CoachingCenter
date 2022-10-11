@extends('layouts.dashboard.app')

@section('title', 'Accounts')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex  align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
        </ol>

        <a href="{{ route('admin.account.create') }}" class="btn btn-sm btn-info">Create account</a>
    </nav>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <p class="m-0">Account</p>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">SL No</th>
                    <th scope="col">Account</th>
                    <th scope="col">Bank</th>
                    <th scope="col">Account Holder</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($accounts as $account)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $account->account_no }}</td>
                        <td>
                            @isset($account->bank->bank_name)
                                {{ $account->bank->bank_name }}
                            @endisset
                        </td>
                        <td>{{ $account->account_holder }}</td>
                        <td>
                            @php
                               $balance = \App\Helper\Accounts::postBalance($account->id);
                            @endphp
                            {{ $balance }}
                        </td>
                        <td>
                            @if($account->status)
                                <span class="btn btn-sm btn-success text-white">Active</span>
                            @else
                                <span class="btn btn-sm btn-danger text-whit">Deactivate</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.account.edit',$account->id)}}" class="btn btn-success btn-sm" ><i class='bx bx-edit-alt'></i></a>

                            <form class="col-6 d-inline" action="{{ route('admin.account.destroy', $account->id) }}"  onclick="return confirm('Are you sure Delete this account?')" method="POST" >
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
@endsection


@push('js')
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush


