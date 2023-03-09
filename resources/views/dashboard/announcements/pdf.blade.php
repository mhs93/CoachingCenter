<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement List</title>
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
    </style>

</head>
<body>
<div style="background: #ffeb3b40;" class="container">
    <table class="rec1">
        <tr>
            {{-- <td> <img src="{{ asset('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo"></td> --}}
            <td class="siteaddress" style="text-align:center;">
                <strong>Site Title: {{ setting('site_title') }}</strong>
                <p class="address"><p>Site Address: {{ setting('site_address') }}</p>
            </td>
        </tr>
    </table>
    <table id="databox" border="2"  border-collapse="collapse">
        <thead>
            <tr>
                <th>SL#</th>
                <th>Title</th>
                <th>Batches</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($announcements as $key=>$announcement)
                <tr>
                    @php $key++ @endphp
                    <td>{{ $key++ }}</td>
                    <td>{{ $announcement->title }}</td>

                    @php
                        $subjectIds = json_decode($announcement->batch_id);
                        $batchSubs= '';
                        if(in_array("0", $subjectIds)){
                            $batchSubs = "All Batch, ";
                        }
                        else{
                            $bathces = App\Models\Batch::whereIn('id', $subjectIds)->get(['id','name']);
                            foreach($bathces as $key=>$item) {
                                $batchSubs .= $item->name.", ";
                            }
                        }
                        $batchSubs = substr($batchSubs, 0, -2);
                    @endphp
                    <td>{{ $batchSubs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
