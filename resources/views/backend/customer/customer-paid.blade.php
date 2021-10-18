@extends('backend.layouts.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Paid Customer</h1>
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
                         Paid Customer List
                        <a class="btn btn-success float-right btn-sm"  href="{{ route('customers.paid.pdf') }}" target="_blank"><i class="fa fa-download"></i>Download PDF</a>
                    </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Customer Name</th>
                        <th>Invoice No</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Action</th>
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
                            <td>
                                <a title="Details" class="btn btn-success btn-sm" href="{{ route('customers.invoice.details.pdf',$payment->invoice_id) }}" target="_blank"><i class="fa fa-eye"></i></a>
                            </td>
                            @php
                              $total_paid +=  $payment->paid_amount;
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
               </table>
               <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: right;"><strong>Grant Total</strong></td>
                        <td><strong>{{ $total_paid }} Tk</strong></td>
                    </tr>
                </tbody>
           </table>


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
@endsection
