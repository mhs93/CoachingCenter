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
            <td  colspan="2"><p class="recipt">Receipt No.#std{{$data->id}}</p></td>
        </tr>
        <tr>
            <td class="dotborder"><span class="dobremove">Name of Student</span> <span>{{$data->student->name}}</span></td>
            <td class="dotborder"><span class="dobremove">Batch</span>  <span>{{$data->student->batch->name}}</span></td>
        </tr>
        <tr>
            <td class="dotborder"><span class="dobremove">Reg. No.</span> <span>{{$data->student->reg_no}}</span></td>
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
            <td>Monthly Fee</td>
            <td class="t-center">{{$data->student->monthly_fee}}</td>
        </tr>
        <tr>
            <td class="t-center">2</td>
            <td>Extra Amount</td>
            <td class="t-center">
                @if($data->additional_amount == NULL)
                    {{"---"}}
                @else
                    {{$data->additional_amount}}
                @endif
            </td>
        </tr>
        <tr>
            <td class="t-center">3</td>
            <td>Discount</td>
            <td class="t-center">
                @if($data->discount_amount == NULL)
                    {{"---"}}
                @else
                    {{$data->discount_amount}}
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right;"><span class="total"><strong>Total</strong></span></td>
            <td class="t-center"><strong>{{$data->total_amount}}/=</strong></td>
        </tr>
    </table>
    <div style="text-align: right">In words:</div>
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
            <td style="text-align: right;"><p style="padding-top: 30px">Student Signature</p></td>
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




{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
    {{--<title>Student Payment</title>--}}
    {{--<meta charset="utf-8">--}}
    {{--<meta http-equiv="x-ua-compatible" content="ie=edge">--}}
    {{--<meta name="description" content="">--}}
    {{--<meta name="keywords" content="">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">--}}
    {{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}


    {{--<style>--}}
        {{--.card {--}}
            {{--margin-bottom: 1.5rem;--}}
        {{--}--}}
        {{--.card {--}}
            {{--position: relative;--}}
            {{--display: -ms-flexbox;--}}
            {{--display: flex;--}}
            {{---ms-flex-direction: column;--}}
            {{--flex-direction: column;--}}
            {{--min-width: 0;--}}
            {{--word-wrap: break-word;--}}
            {{--background-color: #fff;--}}
            {{--background-clip: border-box;--}}
            {{--border: 1px solid #c8ced3;--}}
            {{--border-radius: .25rem;--}}
        {{--}--}}

        {{--.card-header:first-child {--}}
            {{--border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;--}}
        {{--}--}}

        {{--.card-header {--}}
            {{--padding: .75rem 1.25rem;--}}
            {{--margin-bottom: 0;--}}
            {{--background-color: #f0f3f5;--}}
            {{--border-bottom: 1px solid #c8ced3;--}}
        {{--}--}}
        {{--.card-body{--}}
            {{--font-size: 14px;--}}
        {{--}--}}
        {{--.logo{--}}
            {{--height:30px;--}}
            {{--width: 30px;--}}
            {{--border-radius: 50%;--}}
        {{--}--}}
    {{--</style>--}}
{{--</head>--}}
{{--<br>--}}
{{--<body id="app">--}}
{{--<div class="container-fluid">--}}
    {{--<div id="ui-view" data-select2-id="ui-view">--}}
        {{--<div class="card">--}}
            {{--<div class="card-header"><img class="logo" src="{{asset('images/setting/logo/'.setting('logo'))}}">--}}
                {{--Payment slip <strong>#std{{$data->id}}</strong>--}}
                {{--<a title="Save Button" class="btn btn-sm btn-info float-right mr-1 d-print-none" href="#" onclick="javascript:window.print();" data-abc="true">--}}
                    {{--<i class="fa fa-save"></i> Print</a>--}}
            {{--</div>--}}
            {{--<div class="card-body">--}}
                {{--<div class="row mb-4">--}}
                    {{--<div class="col-md-5">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div>--}}
                                    {{--<strong>--}}
                                        {{--<div>Wardan Coaching Center</div>--}}
                                        {{--<div>Phone: </div>--}}
                                        {{--<div>Email:  </div>--}}
                                        {{--<div>Address: </div>--}}
                                    {{--</strong>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6 mt-4">--}}
                                {{--<div>01700000000</div>--}}
                                {{--<div>wardan@coaching.com</div>--}}
                                {{--<div>House# 23/A, Road #3/C, Sector# 9, Uttara-1230</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-sm-3"></div>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<strong>--}}
                                    {{--<div>Student Info</div>--}}
                                    {{--<div>Name: </div>--}}
                                    {{--<div>Reg. No.:  </div>--}}
                                    {{--<div>Phone: </div>--}}
                                {{--</strong>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6 mt-4">--}}
                                {{--<div>{{$data->student->name}}</div>--}}
                                {{--<div>{{$data->student->email}}</div>--}}
                                {{--<div>{{$data->student->contact_number}}</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="row">--}}
                    {{--<div class="col-12 table-responsive" >--}}
                        {{--<table class="table table-striped">--}}
                            {{--<thead style="text-align: center">--}}
                            {{--<tr>--}}
                                {{--<th>Month of Payment</th>--}}
                                {{--<th>Payment Type</th>--}}
                                {{--<th>Monthly Fee</th>--}}
                                {{--<th>Extra Amount</th>--}}
                                {{--<th>Discount Amount</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody style="text-align: center">--}}
                                {{--<tr>--}}
                                    {{--<td>{{$data->month}}</td>--}}
                                    {{--<td>--}}
                                        {{--@if($data->payment_type == 1)--}}
                                            {{--{{"Cheque"}}--}}
                                        {{--@else--}}
                                            {{--{{"Cash"}}--}}
                                            {{--@endif--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--{{$data->student->monthly_fee}}--}}
                                        {{--@if($data->cheque_number == NULL)--}}
                                            {{--{{"--"}}--}}
                                            {{--@else--}}
                                                {{--{{$data->cheque_number}}--}}
                                            {{--@endif--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--@if($data->additional_amount == NULL)--}}
                                            {{--{{"--"}}--}}
                                            {{--@else--}}
                                            {{--{{$data->additional_amount}}--}}
                                            {{--@endif--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--@if($data->discount_amount == NULL)--}}
                                            {{--{{"--"}}--}}
                                            {{--@else--}}
                                            {{--{{$data->discount_amount}}--}}
                                            {{--@endif--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="row">--}}
                    {{--<div class="col-lg-4 col-sm-5">--}}
                        {{--<p> Description : </p>--}}

                        {{--<div class="alert alert-secondary mt-20">--}}
                            {{--<p>{{$data->note}}</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col-lg-4 col-sm-5 ml-auto">--}}
                        {{--<table class="table table-clear">--}}
                            {{--<tbody>--}}
                                {{--<tr>--}}
                                    {{--<td class="left">--}}
                                        {{--<strong>Total</strong>--}}
                                    {{--</td>--}}
                                    {{--<td class="right">--}}
                                        {{--<strong>{{$data->total_amount}}</strong>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}

                {{--</div>--}}
                {{--<div class="row">--}}
                    {{--<div class="col-2">--}}
                        {{--....................................--}}
                        {{--<p> Student Signature </p>--}}
                    {{--</div>--}}
                    {{--<div class="col-2">--}}
                        {{--.......................................--}}
                        {{--<p> Authority Signature </p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}
