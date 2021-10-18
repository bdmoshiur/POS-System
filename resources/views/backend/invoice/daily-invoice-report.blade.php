@extends('backend.layouts.master')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Invoice Report </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <section class="col-md-12">
            <div class="card">
              <div class="card-header">
                    <h3>
                        Select Criteria
                        {{-- <a class="btn btn-success float-right btn-sm"  href=""><i class="fa fa-list"></i> Invoice List</a> --}}
                    </h3>
              </div>
              <div class="card-body">
                    <form action="{{ route('invoice.daily.report.pdf') }}" method="GET" id="myForm" target="_blank">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Start Date</label>
                                <input type="text" class="form-control form-control-sm datepicker"  name="start_date" id="start_date" placeholder="YYYY-MM-DD" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>End Date</label>
                                <input type="text" class="form-control form-control-sm datepicker1"  name="end_date" id="end_date" placeholder="YYYY-MM-DD" readonly>
                            </div>
                            <div class="form-group col-md-1" style="padding-top: 30px">
                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                            </div>
                       </div>
                    </form>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </div>

  <script>
    $(function () {
        $('#myForm').validate({
            rules: {
                start_date: {
                        required: true,
                    },
                end_date: {
                        required: true,
                    }
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

<script>
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format : 'yyyy-mm-dd',
        });
        $('.datepicker1').datepicker({
            uiLibrary: 'bootstrap4',
            format : 'yyyy-mm-dd',
        });
</script>
@endsection
