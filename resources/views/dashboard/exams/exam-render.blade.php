<table class="table-bordered col-md-12 mt-6">
    @foreach($subjectDetails as $subjectDetail)
        <thead align="center">
        <tr>
            <th colspan="2" style="color: red"><span style="color: black">Batch Name: </span> {{$subjectDetail['batch']}}</th>
        </tr>
        <tr>
            <th>Subjects</th>
            <th>Exam Date and Time</th>
        </tr>
        </thead>

        <tbody align="center">

            @foreach($subjectDetail['subject'] as $key=>$subject)
                <tr>
                    <td style="color: blue; font-weight: 400px;">
                        {{$subject['name']}}
                        <input type="hidden" name="subject_id[]" value={{$subject['id']}}>
                    </td>
                    <td>
                        <div>
                            <div class="row">
                                {{-- Date --}}
                                <div class="form-group col-md-4">
                                    <h6>Date <span style="color: red">*</span></h6>
                                    <input type="date" name="date[]" class="form-control" placeholder="Start Time">
                                    @error("date")
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Start Time --}}
                                <div class="form-group col-md-4">
                                    <h6>Start Time <span style="color: red">*</span></h6>
                                    <input type="time" name="start_time[]" class="form-control" placeholder="Start Time">
                                    @error("start_time")
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- End Time --}}
                                <div class="form-group col-md-4">
                                    <h6>End Time <span style="color: red">*</span></h6>
                                    <input type="time" name="end_time[]" class="form-control" placeholder="End Time">
                                    @error("end_time")
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endforeach
</table>


