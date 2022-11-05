@extends('layouts.dashboard.app')

@section('title', 'Showing Result Without Exam Name')

@push('css')

@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Result Show</p>
                        <a href="{{ route('admin.marks.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <input type="hidden" value="{{$exam_id}}" id="exam_id">

                            <div class="form-group mt-3">
                                <label for="batch"><b>Select Batch</b> </label>
                                <select name="batch_id" id="batchIdEx"
                                    class="form-control @error('exam_id') is-invalid @enderror">
                                    <option value="">--Select Batch--</option>
                                    @forelse ($batches as $item)
                                        <option value="{{ $item->batch->id }}">{{ $item->batch->name }}</option>
                                    @empty
                                        {{-- <option>No Batch</option> --}}
                                    @endforelse
                                </select>
                                @error('batch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div>
                            @if (count($batches) > 0)
                                {{-- Sub-Form Start --}}
                                <div class="form-group mt-3 col-md-12" id="subForm" >
                                </div>
                                {{-- Sub-Form End --}}
                            @else
                                <div class="form-group mt-3 col-md-12">
                                    <p><h4 align="center">There is no result for this Exam</h4></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @push('js')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#subForm').hide();
            $(document).ready(function() {
                $('#batchIdEx').on('change', function() {
                    $('#subForm').show();
                    let batch_id = $(this).val();
                    let exam_id = $('#exam_id').val();
                    $("#subForm").empty();
                    $.ajax({
                        url: "{{ route('admin.result.resultBatchShowRender') }}",
                        type: 'post',
                        data: { batchId: batch_id, examId: exam_id},
                        success: function(response) {
                            $('#subForm').html(response);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
