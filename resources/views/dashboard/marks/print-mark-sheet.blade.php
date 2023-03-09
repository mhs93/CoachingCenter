<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Sheet</title>
    <style>
        .headiing{
            text-align: center;
        }
        table{
            width: 100%;
        }
        .recipt{
            border-bottom: 1px solid #000;
            width: 100%;
        }
        .dotborder{
            border-bottom: 1px dotted #000;
        }
        .dobremove{
            background: #fff;
            padding: 3px;
        }

        #databox{
            border-collapse: collapse;
            margin-top:10px;
        }
        .t-center{
            text-align: center;
        }
        .total{
            padding-left: 10px;
            padding-right: 10px;
            border-left: 1px solid #000;
        }
        #f-table{
            margin-top:40px;
        }
        .foot{
            border-top: 1px solid #000;
        }
        .addres{
            margin-right: 100px;
        }
        .print{
            text-align: center;
            margin-right: 10px;
            width: 50px;
            padding: 5px;
            background: #5facb3;
            border-radius: 7px;
            color: #fff;
            text-decoration: none;
        }

        .print:hover{
            background-color: black;
            color: white;
        }
        .pdf{
            text-align: center;
            width: 50px;
            padding: 5px;
            background: #a4b3b4;
            border-radius: 7px;
            color: #fff;
            text-decoration: none;
        }

        .pdf:hover{
            background-color: rgb(64, 17, 17);
            color: white;
        }
        .print_download{
            float: right;
        }
        @media print {
            .print{
                display: none;
            }
            #pdf{
                display: none;
            }
            .siteaddress{
                text-align: center !important;
            }
        }
    </style>

</head>
<body>
    <div  class="container">
    <table class="rec1">
        <tr>
            <td> <img src="{{ asset('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo"></td>
            <td class="siteaddress" style="text-align:center;">
                <strong>Site Title: {{ setting('site_title') }}</strong>
                <p class="address"><p>Site Address: {{ setting('site_address') }}</p>
            </td>
            <td>
               <div class="print_download">
                    <a title="Print" class="print btn btn-sm btn-info float-right mr-1 d-print-none"
                        href="#" onclick="javascript:window.print();" data-abc="true">
                        Print
                    </a>
               </div>
            </td>
        </tr>
    </table>

    <div style="text-align: center">
        <p>
            Result of <span style="color: red">{{ $exam->name }} </span> &nbsp;&nbsp;
            Session: {{ $startDate }} to {{  $endDate }} &nbsp;&nbsp;
            Batch Name: <span style="color: blue">{{ $batch->name }}
        </p>
    </div>

    <table id="databox" border="2"  border-collapse="collapse">
        <thead align="center">
            <th width="100px">Places</th>
            <th width="250px">Student</th>
            @foreach ($marks as $key => $mark)
                @php
                    $subject_id = json_decode($mark->subject_id);
                    $subjects = App\Models\Subject::whereIn('id', $subject_id)->get();
                @endphp
                    @foreach ($subjects as $k => $subject)
                    <th>
                        {{  $subject->name  }}
                    </th>

                    @endforeach
                    @break
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
    </table>
</div>
    <div style="text-align: right">
        <p>Authority Signature</p>
        <p>___________________</p>
    </div>
    </tbody>
</body>
</html>
