<h5 align="center">Exam Name: {{ $exam->name }}</h5>
<h5 align="center">Batch Name: {{ $batch->name }}</h5>
@if (count($marks) > 0)
    <table class="table table-bordered col-md-12 mt-6">
        <thead align="center">
            <th>Places</th>
            <th>Students</th>
            <th width="25%">Subjects/Mark</th>
            <th>Total</th>
        </thead>
        <tbody align="center">
            @foreach ($marks as $key => $mark)
                <tr>
                    <td style="vertical-align: middle;">{{$key + 1}}</td>
                    <td style="vertical-align: middle;">{{$mark->student->name}}</td>
                    <td>
                        @php
                            $subject_id = json_decode($mark->subject_id);
                            $subMark = json_decode($mark->mark);
                            $subjects = App\Models\Subject::whereIn('id', $subject_id)->get();
                        @endphp
                            @foreach ($subjects as $k => $subject)
                            <div class="row">
                                <div class="col-md-8" style="text-align: right;">{{$subject->name}} : </div>
                                <div class="col-md-4" style="text-align: left;">{{$subMark[$k]}}</div>
                            </div>
                        @endforeach
                    </td>
                    <td style="vertical-align: middle;">{{$mark->total}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@else
<div>
    <p><h4 align="center">There is no marks for this batch</h4></p>
</div>
@endif

