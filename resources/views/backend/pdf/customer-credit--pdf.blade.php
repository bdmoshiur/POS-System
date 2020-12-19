<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Pdf</title>
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
</head>
<body>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <table width="100%">
                   <tbody>
                       <tr>
                           <td></td>
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
                           <td width="45%"></td>
                           <td><u><strong><span style="font-size: 15px">Credit Customer List</span></strong></u></td>
                           <td width="30%"></td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>

       <div class="row">
           <div class="col-md-12">
            
            @php
             $date = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            @endphp
            <i>Printing Time : {{ $date->format('F j, Y, g:i a') }}</i>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
               <hr style="margin-bottom: 0px;">
               <table border="0" width="100%">
                   <tbody>
                       <tr>
                           <td width="40%">
                               <p style="text-align: center; margin-left: :20px;">Customer Signature</p>
                            </td>
                           <td width="20%"></td>
                           <td width="40%" style="text-align: center;">
                                <p style="text-align: center;">Seller Signature</p>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>
   </div>
</body>
</html>

