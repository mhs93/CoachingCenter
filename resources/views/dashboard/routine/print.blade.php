<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Routine List</title>
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
                text-align: left !important;
            }
        }
    </style>

</head>
<body>
<div style="" class="container">
    <table class="rec1">
        <tr>
            <td> <img src="{{ asset('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo"></td>
            <td class="siteaddress" style="text-align:center;">
                <strong>{{ setting('site_title') }}</strong>
                <p class="address"><p>{{ setting('site_address') }}</p>
            </td>
            <td>
               <div class="print_download">
                    <a title="Print" class="print btn btn-sm btn-info float-right mr-1 d-print-none"
                        href="#" onclick="javascript:window.print();" data-abc="true">
                        Print
                    </a>
                    <span id="pdf" class="pdf">
                        <a href="{{ route('admin.routine.pdf') }}" class="pdf">Download</a>
                    </span>
               </div>
            </td>
        </tr>
    </table>
    <table id="databox" border="2"  border-collapse="collapse">
        <thead>
            <tr>
                <th class="t-center">Day</th>
                <th class="t-center">Subject</th>
                <th class="t-center">Batch</th>
                <th class="t-center">Start Time</th>
                <th class="t-center">End Time</th>
            </tr>
            {{-- <div>
                <span width="100px" class="span">Day</span>
                <span width="100px">Subject</span>
                <span width="100px">Batch</span>
            </div> --}}
        </thead>

        <tbody>
            @php
                $batch_id      = '';
                $subject_id    = '';
                $batch_count   =  0;
                $subject_count =  0;
            @endphp
            @foreach ($routines as $key=>$item)
                {{-- <div>
                    <span width="100px">
                        @if($item->day == 1)
                            Saturday
                        @elseif ($item->day == 2)
                            Sunday
                        @elseif ($item->day == 3)
                            Monday
                        @elseif ($item->day == 4)
                            Tuesday
                        @elseif ($item->day == 5)
                            Wednesday
                        @elseif ($item->day == 6)
                            Thursday
                        @elseif ($item->day == 7)
                            Friday
                        @endif
                    </span>

                    <span width="100px">
                        @if ($subject_id != $item->subject->id)
                            {{ $item->subject->name }}
                        @else
                            <span></span>
                        @endif

                        @php
                            $subject_id = $item->subject->id;
                        @endphp
                    </span>

                    <span width="100px">
                        @if ($batch_id != $item->batch->id)
                            {{ $item->batch->name }}
                        @else
                            <span></span>
                        @endif

                        @php
                            $batch_id = $item->batch->id;
                        @endphp
                    </span>
                </div> --}}
                <tr>
                    <td class="t-center">
                        @if($item->day == 1)
                           Saturday
                        @elseif ($item->day == 2)
                            Sunday
                        @elseif ($item->day == 3)
                            Monday
                        @elseif ($item->day == 4)
                            Tuesday
                        @elseif ($item->day == 5)
                            Wednesday
                        @elseif ($item->day == 6)
                            Thursday
                        @elseif ($item->day == 7)
                            Friday
                        @endif
                    </td>

                    @if ($subject_id != $item->subject->id)
                        <td class="t-center">
                            {{ $item->subject->name }}
                        </td>
                    @else
                        <td></td>
                    @endif

                    @php
                        $subject_id = $item->subject->id;
                    @endphp

                    @if ($batch_id != $item->batch->id)
                        <td class="t-center">
                            {{ $item->batch->name }}
                        </td>
                    @else
                        <td></td>
                    @endif
                    @php
                        $batch_id = $item->batch->id;
                    @endphp
                    <td class="t-center">{{ $item->start_time}}</td>
                    <td class="t-center">{{ $item->end_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
