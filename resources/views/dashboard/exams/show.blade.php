@extends('layouts.dashboard.app')

@section('title', 'Exam Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Exam Information</p>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-sm btn-dark">Back to list</a>
        </div>
        <div class="card-body">
            <div class="row">
                <table id="table" class="table table-bordered data-table" style="width: 100%">
                    <tbody>
                        <tr>
                            <td>Exam Name</td>
                            <td colspan="5">{{ $exam->name }}</td>
                        </tr>

                        <tr>
                            <td>Start Date</td>
                            <td colspan="5">{{ $exam->start_date }}</td>
                        </tr>

                        <tr>
                            <td>End Date</td>
                            <td colspan="5">{{ $exam->end_date }}</td>
                        </tr>

                        <tr>
                            <td>Status</td>
                            <td colspan="5">{{ $exam->status ? 'Active' : 'Inactive' }}</td>
                        </tr>

                        <tr>
                            <td>Exam Note</td>
                            <td colspan="5"><b>{!! $exam->note !!}</b></td>
                        </tr>

                        <tr>
                            <table class="table table-bordered">
                                <tbody>
                                    @foreach($exam->examDetails as $key => $examDetail )
                                        <tr>
                                            <td>
                                                @if($key !=0)
                                                    @if($exam->examDetails[$key - 1]->batch->id != $examDetail->batch->id)
                                                        Batch: {{$examDetail->batch->name}}
                                                    @endif
                                                @else
                                                    Batch: {{$examDetail->batch->name}}
                                                @endif

                                            </td>

                                            <td>
                                                Subject: {{$examDetail->subject->name}}
                                            </td>

                                            <td>
                                                Date: {{$examDetail->date}}
                                            </td>
                                            {{-- <td>
                                                Start Date: {{$examDetail->start_date}}
                                            </td> --}}

                                            <td>
                                                Start Time: {{$examDetail->start_time}}
                                            </td>
                                            

                                            {{-- <td>
                                                End Date: {{$examDetail->end_date}}
                                            </td> --}}

                                            <td>
                                                End Time: {{$examDetail->end_time}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- @foreach($exam->examDetails as $key => $examDetail )
                            <tr>
                                <td>
                                    @if($key !=0)
                                        @if($exam->examDetails[$key - 1]->batch->id != $examDetail->batch->id)
                                          {{$examDetail->batch->name}}
                                        @endif
                                    @else
                                        {{$examDetail->batch->name}}
                                    @endif

                                </td>
                                <td>{{$examDetail->subject->name}}</td>
                                <td>{{$examDetail->start_date}}</td>
                                <td>{{$examDetail->start_time}}</td>
                                <td>{{$examDetail->end_date}}</td>
                                <td>{{$examDetail->end_time}}</td>
                            </tr>
                        @endforeach --}}
