<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result PDF</title>

    <style>
        table{
            width: 100%;
        }
        .left{
            text-align: left;
        }
        .right{
            text-align: right;
        }
    </style>
</head>
<body>
    <div>
        <div>
            <span class="left">
                {{-- <img src="{{'data:image/png;base64,'.$image}}" width="118" height="46" alt="Logo"> --}}

                {{-- <img src="{{ public_path('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo"> --}}
                {{-- <img src="{{ asset('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo">
                <img src="{{ public_path('images/codeanddeploy.jpg') }}" style="width: 20%"> --}}
            </span>

            <span class="right">
                <p>{{ setting('site_title') }}</p>
                <p>{{ setting('site_address') }}</p>
            </span>
        </div>

        <div>
            <h3 align="center">
                <p>Result of <span style="color: red">{{ $exam->name }} </span></p> <hr>
                <p>Session: {{ $startDate }} to {{  $endDate }}</p>
                <p>Batch Name: <span style="color: blue">{{ $batch->name }}</span></p> <hr>
            </h3>
            <h3 align="right">
                Date: {{ now()->format('Y-m-d') }}
            </h3>
        </div>

        <div>
            <table class="table table-bordered col-md-12 mt-6" border="1">
                <thead align="center">
                    <th width="100px">Places</th>
                    <th width="250px">Student</th>
                    @foreach ($marks as $key => $mark)
                        @php
                            $subject_id = json_decode($mark->subject_id);
                            $subjects = App\Models\Subject::whereIn('id', $subject_id)->get();
                        @endphp
                        {{-- <th width="100px"> --}}
                            @foreach ($subjects as $k => $subject)
                            <th>
                                {{  $subject->name  }}
                            </th>

                            @endforeach
                            @break
                        {{-- </th> --}}
                    @endforeach
                    <th width="100px">Total</th>
                </thead>
                <tbody align="center">
                    @foreach ($marks as $key => $mark)
                        <tr>
                            <td style="vertical-align: middle;">{{$key + 1}}</td>
                            <td style="vertical-align: middle;">{{$mark->student->name}}</td>
                            @php
                                $subject_id = json_decode($mark->subject_id);
                                $subMark = json_decode($mark->mark);
                                $subjects = App\Models\Subject::whereIn('id', $subject_id)->get();
                            @endphp

                            @foreach ($subjects as $k => $subject)
                                <td>{{$subMark[$k]}} </td>
                            @endforeach
                            <td style="vertical-align: middle;">{{$mark->total}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
