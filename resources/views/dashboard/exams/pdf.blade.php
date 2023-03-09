<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam List</title>
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
        .rec1 tr td{
            padding-top: 20px;
        }
        #databox{
            border-collapse: collapse;
            margin-top:40px;
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
            float: right;
            margin-right: 25px;
            width: 50px;
            padding: 5px;
            background: #00CFDD;
            border-radius: 7px;
            color: #fff;
        }
        @media print {
            .print{
                display: none;
            }
        }
    </style>

</head>
<body>
<div style="background: #ffeb3b40;" class="container">
    <table class="rec1">
        {{-- <tr>
            <td>
                <img src="{{ asset('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo">
            </td>
        </tr> --}}
        <tr>
            <td style="text-align:center;" colspan="2"><strong>{{ setting('site_title') }}</strong></td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2"><p class="address" ><p>{{ setting('site_address') }}</p></td>
        </tr>
    </table>
    <table id="databox" border="2"  border-collapse="collapse">
        <tr>
            <th>SL. No</th>
            <th>Exam Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Mark Status</th>
        </tr>
        @foreach ($exams as $key=>$data)
            <tr>
                @php $key++ @endphp
                <td class="t-center">{{ $key++ }}</td>
                <td class="t-center">{{ $data->name }}</td>
                {{-- <td class="t-center">{{ $data->start_date->format('Y-m-d')}}</td> --}}
                <td class="t-center">{{ $data->start_date }}</td>
                <td class="t-center">{{ $data->end_date }}</td>
                <td class="t-center">
                    @if( $data->mark_status == 1 )
                        {{"Mark Given"}}
                    @else
                        {{"Mark Not Given"}}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
