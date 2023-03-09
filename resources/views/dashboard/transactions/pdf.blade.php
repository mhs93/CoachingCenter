<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction List</title>
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
                <th>SL. No</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Transaction Type</th>
                <th>Payment Type</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($transactions as $key => $data)
                <tr>
                    @php $key++ @endphp
                    <td class="t-center">{{ $key++ }}</td>
                    <td class="t-center">{{ $data->date }}</td>
                    <td class="t-center">{{ $data->amount }}</td>

                    <td class="t-center">
                        @if( $data->transaction_type == 1 )
                            {{"Credit"}}
                        @elseif ($data->transaction_type == 2 )
                            {{"Debit"}}
                        @else
                            {{"Initail Balance"}}
                        @endif
                    </td>

                    <td class="t-center">
                        @if( $data->payment_type == 1 )
                            {{"Check"}}
                        @else
                            {{"Cash"}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
</body>
</html>
