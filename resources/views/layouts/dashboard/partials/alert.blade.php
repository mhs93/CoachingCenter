@if (session('error'))
    <div class="bg-danger text-white alert alert-danger alert-dismissible fade show" role="alert">
        <div class="fw-semibold">Error! {{ session('error') }} </div>
        <button title="Close Button" class="btn btn-small btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

