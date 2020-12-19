@extends('backend.layouts.master')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Credit Customer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-md-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                    <h3>
                        Edit Invoice (Invoice No #{{ $payment->invoice->invoice_no }})
                        <a class="btn btn-success float-right btn-sm"  href="{{ route('customers.credit') }}"><i class="fa fa-list"></i> Cretid Customer List</a>
                    </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td colspan="3"><strong>Customer Info</strong></td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>Name : </strong>{{$payment->customer->name}}</td>
                            <td width="30%"><strong>Mobile : </strong>{{$payment->customer->mobile_no}}</td>
                            <td width="40%"><strong>Address : </strong>{{$payment->customer->address}}</td>
                        </tr>
                    </tbody>
                </table>
                <form action="{{ route('customers.update.invoice',$payment->invoice_id) }}" method="POST" id="myForm">
                @csrf
                    <table width="100%" border="1" style="margin-bottom: 10px">
                        <thead>
                            <tr class="text-center">
                                <th>Sl.</th>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php
                                $sub_total = 0;
                                $invoice_details = App\Model\InvoiceDetail::where('invoice_id',$payment->invoice_id)->get();
                                @endphp
                            @foreach ($invoice_details  as $key => $details)
                            <tr class="text-center">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $details->category->name }}</td>
                                <td>{{ $details->product->name }}</td>
                                <td>{{ $details->selling_qty }}</td>
                                <td>{{ $details->unit_price }}</td>
                                <td>{{ $details->selling_price }}</td>
                                @php
                                    $sub_total += $details->selling_price;
                                @endphp
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" class="text-right"><strong>Sub Total </strong></td>
                                <td class="text-center"><strong>{{ $sub_total }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">Discount</td>
                                <td class="text-center"><strong>{{ $payment->discount_amount }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">Paid Amount </td>
                                <td class="text-center"><strong>{{ $payment->paid_amount }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">Due Amount </td>
                                <input type="hidden" name="new_paid_amount" value="{{ $payment->due_amount }}">
                                <td class="text-center"><strong>{{ $payment->due_amount }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Grand Total </strong></td>
                                <td class="text-center"><strong>{{ $payment->total_amount }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="">Paid Status</label>
                            <select name="paid_status" id="paid_status" class="form-control form-control-sm">
                                <option value="">Select Status</option>
                                <option value="full_paid">Full Paid</option>
                                <option value="partial_paid">Partial Paid</option>
                            </select>
                            <input type="text" name="paid_amount" class="form-control form-control-sm paid_amount" placeholder="Enter Paid Amount" style="display: none">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Date</label>
                            <input type="text" class="form-control form-control-sm datepicker" name="date" id="date" placeholder="YYYY-MM-DD" readonly>
                       </div>
                       <div class="form-group col-md-3" style="padding-top: 30px">
                        <button type="submit" class="btn btn-primary btn-sm">Invoice Update</button>
                       </div>
                    </div>
                </form>
              </div><!-- /.card-body -->
            </div>

          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
         $(document).on('change','#paid_status',function(){
                var paid_status = $(this).val();
                if(paid_status == "partial_paid"){
                    $('.paid_amount').show();
                }else{
                    $('.paid_amount').hide();
                }
            });
  </script>

<script>
    $('.datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format : 'yyyy-mm-dd',
    });
</script>

<script>
    $(function () {
        $('#myForm').validate({
            rules: {
                paid_status: {
                        required: true,
                    },
                date: {
                        required: true,
                    },
            },
            messages: {

            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>


@endsection
