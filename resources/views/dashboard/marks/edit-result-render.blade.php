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

                <td style="vertical-align: middle;">
                    {{$mark->student->name}}
                    <input type="hidden" name="student_id[]" value="{{$mark->student->id}}">
                </td>


                <td>
                    @php
                        $subject_id = json_decode($mark->subject_id);
                        $subMark = json_decode($mark->mark);
                        $subjects = App\Models\Subject::whereIn('id', $subject_id)->get();
                    @endphp

                    @foreach ($subjects as $k => $subject)
                        <div class="row">
                            <div class="col-md-8" style="text-align: right;">
                                {{$subject->name}} :
                                <input type="hidden"  name="subject_id[]" value="{{$subject->id}}">
                            </div>
                            <div class="col-md-4" style="text-align: left;">
                                <input type="number" name="mark[]" value="{{$subMark[$k]}}"
                                    class="form-control mark{{$mark->student->id}}"
                                    oninput="calTotal('mark{{ $mark->student->id }}')">
                            </div>
                        </div>
                    @endforeach

                </td>
                <td style="vertical-align: middle;">
                    <input type="text" value=" {{$mark->total}} " name="total[]" id="total_mark{{$student['id']}}" class="mark form-control" readonly id="total_mark{{$mark->student->id}}" value="">
                </td>
            </tr>
            @endforeach


    </tbody>
</table>

<script>
    var x;
    function calTotal(mark){
        console.log(mark)
        var sum = 0;
        $('.'+mark).each(function(){
            if( isNaN(parseFloat($(this).val()) ) ){
                sum+=0
            }else{
                sum += parseFloat($(this).val());
            }
        });
        $('#total_'+mark).val(sum)
    }
</script>
