@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="fw-semibold">Error!</div> {{ session('error') }}
        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
