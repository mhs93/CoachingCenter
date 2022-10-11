@extends('layouts.dashboard.app')

@section('title', 'Announcement Details')

@push('css')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
@endpush

@section('breadcrumb')
<nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
    </ol>
</nav>
@endsection

@section('content')

<div class="card ">
    <div class="card-header  ">
      <h5> Announcement Details View</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 ">
                <h5 class="text-muted"> Title : {{$announcement->title}}</h5>
            </div>

            <div class="col-12 col-sm-12 mt-4 ">
                <h5 class="text-muted"> Batch name : {{ $batchSubs }}</h5>
            </div>

            <div class="col-12 col-sm-12 mt-4 ">
                <h5 class="text-muted"> Created At : {{$announcement->created_at->toDayDateTimeString();}}</h5>
            </div>

            <div class="col-12 col-sm-12 mt-4 ">
                <h5 class="text-muted"> Description {!! $announcement->description !!}</h5>
            </div>


        </div>
        <div class="row mt-4">
            <div class="col-12 col-sm-12 ">
                <p>{!!$announcement->message!!}</p>
            </div>
        </div>
    </div>
  </div>

    {{-- announcement --}}

</div>

<div class="mb-5"></div>

@push('js')

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


@endpush

<script type="text/javascript">

    CKEDITOR.replace( 'message' );

</script>


@endsection
