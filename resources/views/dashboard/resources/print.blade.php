<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource List</title>
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
<div style="background: #ffeb3b40;" class="container">
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
                    <span id="pdf" class="pdf">
                        <a href="{{ route('admin.resources.pdf') }}" class="pdf">Download</a>
                    </span>
               </div>
            </td>
        </tr>
    </table>
    <table id="databox" border="2"  border-collapse="collapse">
        <thead class="t-center">
            <tr>
                <th>SL#</th>
                <th>Title</th>
                <th>Batches</th>
                <th>Subjects</th>
            </tr>
        </thead>
        
        <tbody class="t-center">
            @foreach ($resources as $key=>$resource)
                <tr>
                    @php $key++ @endphp
                    <td>{{ $key++ }}</td>
                    <td>{{ $resource->title }}</td>

                    @php
                        $batch_name = '';
                        $resource_batches = json_decode($resource->batch_id);
                        $bathces = App\Models\Batch::whereIn('id', $resource_batches)->get(['id','name']);
                        foreach($bathces as $key=>$item) {
                            $batch_name .= $item->name.", ";
                        }
                        $batch_name = substr($batch_name, 0, -2);
                        if($resource->subject_id){
                            $subject_name = '';
                            $resource_subjects = json_decode($resource->subject_id);
                            if(in_array("0", $resource_subjects)){
                                $subjects = App\Models\Subject::all();
                                foreach($subjects as $key=>$item) {
                                    $subject_name .= $item->name.", ";
                                }
                            }else{
                                $subjects = App\Models\Subject::whereIn('id', $resource_subjects)->get(['id','name']);
                                foreach($subjects as $key=>$item) {
                                    $subject_name .= $item->name.", ";
                                }
                            }
                        }else{
                            $subjects='';
                        }
                        $subject_name = substr($subject_name, 0, -2);
                    @endphp
                    <td>{{ $batch_name }}</td>
                    <td>{{ $subject_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
