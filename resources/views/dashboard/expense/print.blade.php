<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
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
    {{--<div class="headiing">--}}
    {{--<h2 style="text-align:center;">Receipt Sample for Fees</h2>--}}
    {{--</div>--}}
    <table class="rec1">
        <tr>
            <td style="text-align:center;" colspan="2"><strong>Receipt</strong></td>
            <a title="Print" class="print btn btn-sm btn-info float-right mr-1 d-print-none"
               href="#" onclick="javascript:window.print();" data-abc="true">Print </a>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2"><strong>Wardan Coaching Center</strong></td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2"><p class="address" >Address:House-22,Road-17,sector-13 uttara.    Phone:01700910000</p></td>
        </tr>
        <tr>
            <td  colspan="2"><p class="recipt">Receipt No.#inc{{$data->id}}</p></td>
        </tr>
        <tr>
            {{--<td class="dotborder"><span class="dobremove">Name of Student</span> <span>{{$data->student->name}}</span></td>--}}
            {{--<td class="dotborder"><span class="dobremove">Batch</span>  <span>{{$data->student->batch->name}}</span></td>--}}
        </tr>
        <tr>
            {{--<td class="dotborder"><span class="dobremove">Reg. No.</span> <span>{{$data->student->reg_no}}</span></td>--}}
            {{--<td class="dotborder"><span class="dobremove">Phone</span> <span>{{$data->student->reg_no}}</span></td>--}}
            <td class="dotborder"><span class="dobremove">Date of payment</span>  <span>{{$data->created_at}}</span></td>
        </tr>
    </table>
    <table id="databox" border="2"  border-collapse="collapse">
        <tr>
            <th>SL. No</th>
            <th>Particulars</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td class="t-center">1</td>
            <td>{{$data->expense_purpose}}</td>
            <td class="t-center">{{$data->amount}}</td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right;"><span class="total"><strong>Total</strong></span></td>
            <td class="t-center"><strong>{{$data->amount}}/=</strong></td>
        </tr>
    </table>
    <div style="text-align: right">In words: </div>
    <table id="f-table">
        <tr>
            <td>Paid By: <u>@if($data->payment_type == 1)
                        {{"Cheque"}}
                    @else
                        {{"Cash"}}
                    @endif</u></td>
            {{--<td style="text-align: right;">In words: One thousand taka</td>--}}
        </tr>
        <tr>
            <td><p style="padding-top: 30px">Authority Signature</p></td>
            <td style="text-align: right;"><p style="padding-top: 30px">Customer Signature</p></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div style="text-align:center;" class="foot">
        <p>All above mentioned Amount once paid are non refundable in any case whatsoever.</p>
    </div>
</div>
</body>
</html>