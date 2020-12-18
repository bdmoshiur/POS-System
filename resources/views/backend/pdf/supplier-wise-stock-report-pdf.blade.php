<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Supplier wise Stock Report PDF</title>
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
                           <td><u><strong><span style="font-size: 15px">Supplier Wise Stock Report</span></strong></u></td>
                           <td></td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
               <strong>Supplier Name :</strong> {{ $allData['0']->supplier->name }}
            <table border="1" width="100%">
                <thead>
                <tr>
                  <th>SL.</th>
                  <th>Category</th>
                  <th>Product Name</th>
                  <th>Stock</th>
                  <th>Unit</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($allData as $key => $product)
                  <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $product->category->name }}</td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->quantity }}</td>
                      <td>{{ $product->unit->name }}</td>
                  </tr>
                  @endforeach
                 </tbody>
              </table>
           </div>
       </div>
       <br>
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

