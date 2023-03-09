<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
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
        <thead class="t-center">
            <tr>
                <th>SL#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Reg No</th>
                <th>Subjects</th>
                <th>Salary</th>
            </tr>
        </thead>

        <tbody class="t-center">
            @foreach ($teachers as $key=>$teacher)
                <tr>
                    @php $key++ @endphp
                    <td>{{ $key++ }}</td>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->contact_number }}</td>
                    <td>{{ $teacher->reg_no }}</td>

                    @php
                        $subjectIds = json_decode($teacher->subject_id);
                        $batchSubs= '';
                        if(in_array("0", $subjectIds)){
                            $batchSubs = "All Subject, ";
                        }else{
                            $subjects = App\Models\Subject::whereIn('id',$subjectIds)->get(['id','name']);
                            foreach($subjects as $key=>$item) {
                                $batchSubs .= $item->name.", ";
                            }
                        }
                        $batchSubs = substr($batchSubs, 0, -2);
                    @endphp
                    <td>{{ $batchSubs }}</td>

                    <td>{{ $teacher->monthly_salary }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
