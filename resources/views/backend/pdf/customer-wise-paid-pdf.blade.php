<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Wise Paid Report PDF</title>
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
</head>
<body>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <table width="100%">
                   <tbody>
                       <tr>
                           <td width="25%"></td>
                           <td>
                               <span style="font-size: 20px; background: #1781BF; padding: 3px 10px 3px 10px; color: #fff">Shopping Mall</span><br>
                                    Dhaka, Bangladesh
                           </td>
                           <td>
                               <span>
                                showroom No: 01749302454 <br>
                                Owner No: 01749302454
                               </span>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>

       <div class="row">
           <div class="col-md-12">
            <hr style="margin-bottom: 0px;">
               <table>
                   <tbody>
                       <tr>
                           <td width="50%"></td>
                           <td><u><strong><span style="font-size: 15px">Customer Wise Paid Report</span></strong></u></td>
                           <td></td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
            <table border="1" width="100%">
                <thead>
                <tr>
                    <th>SL.</th>
                    <th>Customer Name</th>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $total_paid = '0';
                    @endphp
                    @foreach ($allData as $key => $payment)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            {{ $payment->customer->name }}
                            ({{ $payment->customer->mobile_no }} - {{ $payment->customer->address }})
                        </td>
                        <td>Invoice No #{{ $payment->invoice->invoice_no }}</td>
                        <td>{{ date('d-m-Y',strtotime($payment->invoice->date)) }}</td>
                        <td>{{ $payment->paid_amount }} Tk</td>
                        @php
                            $total_paid +=  $payment->paid_amount;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Grant Total</strong></td>
                        <td><strong>{{ $total_paid }} Tk</strong></td>
                    </tr>
                </tbody>
           </table>
              @php
              $date = new DateTime('now', new DateTimezone('Asia/Dhaka'));
             @endphp
             <i>Printing Time : {{ $date->format('F j, Y, g:i a') }}</i>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
               <table border="0" width="100%">
                   <tbody>
                       <tr>
                           <td width="40%">
                            </td>
                           <td width="20%"></td>
                           <td width="40%" style="text-align: center;">
                                <p style="text-align: center; border-bottom: 1px solid #000">Owner Signature</p>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>
   </div>
</body>
</html>

