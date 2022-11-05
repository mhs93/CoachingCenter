@if (count($studentName) > 0)
<table class="table table-bordered col-md-12 mt-6">
    <thead align="center">
        <tr>

            @php
                $x = 0;
            @endphp
            <th>Student/Subject</th>
            @foreach($subjectName as $subject)
                @php
                    $x++;
                @endphp
                <th>
                    {{ $subject['name']}}
                    <input type="hidden" name="subject_id[]" value="{{$subject['id']}}">
                </th>
            @endforeach
            <th>Total</th>
        </tr>

    </thead>
    <tbody align="center">
        @foreach($studentName as $student)
            <tr>
                <td>
                    <b>{{ $student['name']}}</b>
                    <input type="hidden" name="student_id[]" value="{{$student['id']}}">
                </td>
                @for($i = 0; $i< $x; $i++)
                    <td><input type="number" name="mark[]" oninput="calTotal('mark{{$student['id']}}')"  value="" class="form-control mark{{$student['id']}}"></td>
                @endfor
                <th>
                    <input type="text" value="0" name="total[]" class="form-control" readonly id="total_mark{{$student['id']}}" value="">
                </th>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<div>
    <p><h4 align="center">There is no students for this batch</h4></p>
</div>
@endif


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


