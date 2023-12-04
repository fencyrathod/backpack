<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        #main {
            width: 400px;
            height: 100px;
            border: 1px solid #c3c3c3;
            display: flex;
            justify-content: center;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>

    <table style=" width:100%">

        <tr>
            <td>
                <img src="{{ public_path('logo/' . $data['detail']['logo']) }}" height="100" width="150">
            </td>
            <td style="padding-left:30%;">
                <div style="line-height: 40%;padding-top:15px;">


                    <h3>{{ $data['detail']['shop_name'] }}</h3>
                    <p>{{ $data['detail']['address'] }},</p>
                    <p>{{ $data['detail']['city'] }},{{ $data['detail']['state'] }},{{ $data['detail']['pincode'] }}</p>
                    <p>Phone:{{ $data['detail']['phone'] }} </p>
                    <p>Email:{{ $data['detail']['email'] }} </p>
                    <p>GST No:{{ $data['detail']['gst_no'] }} </p>
            </td>

            </div>
        </tr>
    </table>

    <hr>
    <div class="row">
        <div class="text-center">
            <h2>Invoice:<?php echo 'AMJ' . rand(100, 1000); ?></h2>
        </div>
    </div>

    <div class="row">
        <div style="background-color: #e2e3e5; padding:1px; padding-left:5px;">
            <h3>Customer Details</h3>
        </div>
    </div>


    <table class="table">
        <tr>
            <td><b>Name:</b>{{ $data['customer']['Name'] }}</td>
            <td><b>Phone:</b>{{ $data['customer']['Phone'] }}</td>
            <td><b>Email:</b>{{ $data['customer']['Email'] }}</td>

        </tr>

        <tr>

            <td><b>Address:</b>{{ $data['customer']['Address'] }}</td>
        </tr>
    </table>

    <div class="row">
        <div style="background-color: #e2e3e5; padding:1px; padding-left:5px;">
            <h3>Job Details</h3>
        </div>
    </div>
    <table class="table">
        <tr>
            <td><b>Device Type:</b>{{ $data['device_type']['name'] }}</td>
            <td><b>Device Brand:</b>{{ $data['device_brand']['name'] }}</td>
            <td><b>Created Date:</b>{{ $data['job']['created_at'] }}</td>
            <td><b>Service Type:</b>{{ $data['service_type']['name'] }}</td>
        </tr>
        <tr>
            <td><b>Service Type:</b>{{ $data['service_type']['name'] }}</td>
            <td><b>Device Color:</b>{{ $data['job']['Device_Color'] }}</td>
            <td><b>Initial Quotation:</b>{{ $data['job']['Initial_Quotation'] }}</td>

        </tr>
    </table>

    
        <table class="table" style="margin-top:-15px;">
            <tr>
                <td><b>Accessories:</b>{{ $data['job']['Accessories'] }}</td>
            </tr>
            @php
                $msg = '';
                $result = [];
            @endphp
            @if ($data['service'] == null)
                @php $msg='-';  @endphp
            @else
                @foreach ($data as $key => $val)
                    @if ($key == 'service')
                        @foreach ($val as $v)
                            @php   $result[]=$v->s_name @endphp
                        @endforeach
                        @php $msg=implode(",",$result)@endphp
                    @endif
                @endforeach


            @endif
            <tr>
                <td><b>Service:</b> <?php echo $msg; ?></td>
            </tr>
        </table>


   
    <div class="row">
        <div style="background-color: #e2e3e5;">
            <h3>Quotation Details</h3>
        </div>
    </div>

    <table class="table" id="customers">

        <tr>
            <th>Service Name</th>
            <th>Price</th>
            <th>Sub Total</th>

            <th>Tax</th>
            <th>Tax Amt</th>
            <th>Total</th>
        </tr>


        @php $tot=0 @endphp
        @if ($data['service'] == null)
        @else
            @foreach ($data as $key => $val)
                @if ($key == 'service')
                    @foreach ($val as $v)
                        <tr>
                            <td>{{ $v->s_name }}</td>
                            <td>{{ $v->price }}</td>
                            <td>{{ $v->price }}</td>
                            <td>{{ $v->tax }}</td>
                            <td>@php  echo (18/100)*$v->price; @endphp</td>
                            <td><?php echo $v->price + (18 / 100) * $v->price; ?> </td>
                            @php $tot+=$v->price +(18/100)*$v->price @endphp

                        </tr>
                    @endforeach
                @endif
            @endforeach
        @endif

    </table>


    <div class="container" style="position: absolute;top:670px">
        <div class="col" style="line-height: 30%;">
            <p>Account Name:{{ $data['detail']['account_name'] }}</p>
            <p>Bank Name:{{ $data['detail']['bank_name'] }}</p>
            <p>Account Number: {{ $data['detail']['account_no'] }}</p>
            <p>IFSC Code: {{ $data['detail']['ifsc_no'] }}</p>
        </div>

        <div class="col" style="position: absolute; top:2px; right:-100px;">
            <table style="border:1px solid black;">
                <tr style="border:1px solid black;">
                    <td style="border:1px solid black;"><b>Total Amount:</b></td>
                    <td><?php echo $tot; ?></td>
                </tr>
                <tr style="border:1px solid black;">
                    <td style="border:1px solid black;"><b>Total Tax Amount:</b></td>
                    <td>0.00</td>
                </tr>

                <tr style="border:1px solid black;">
                    <td style="border:1px solid black;"><b>Grand Total:</b></td>
                    <td><?php echo $tot; ?></td>
                </tr>
            </table>
        </div>
    </div>


</body>

</html>
