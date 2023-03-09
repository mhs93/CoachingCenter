<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch List</title>
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
    <div  class="container">
        <table class="rec1">
            <tr>
                {{-- <td> <img src="{{ asset('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo"></td> --}}
                <td class="siteaddress" style="text-align:center">
                    <strong> {{ setting('site_title') }}</strong>
                    <p class="address"><p>website: {{ setting('site_address') }}</p>
                </td>
            </tr>
        </table>
        <table id="databox" border="2"  border-collapse="collapse">
            <thead class="t-center">
                <tr>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Subject Fee</th>
                </tr>
            </thead>

            <tbody class="t-center">
                @foreach ($subjects as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->fee }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
