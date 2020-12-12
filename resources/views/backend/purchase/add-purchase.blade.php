@extends('backend.layouts.master')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Purchase </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Purchase</li>
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
                        Add Purchase
                        <a class="btn btn-success float-right btn-sm"  href="{{ route('purchase.view') }}"><i class="fa fa-list"></i> Purchase List</a>
                    </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                    <div class="form-row">
                    <div class="form-group col-md-4">
                         <label>Date</label>
                         <input type="text" class="form-control datepicker" name="date" id="date" placeholder="YYYY-MM-DD" readonly>
                    </div>
                    <div class="form-group col-md-4">
                         <label>Purchase No</label>
                         <input type="text" class="form-control" name="purchase_no" id="purchase_no">
                    </div>
                    <div class="form-group col-md-4">
                         <label for="supplier_id">Supplier Name</label>
                         <select name="supplier_id" id="supplier_id" class="form-control">
                            <option value="">---Select Supplier---</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                         </select>
                    </div>
                    <div class="form-group col-md-4">
                         <label for="category_id">Category Name</label>
                         <select name="category_id" id="category_id" class="form-control">
                            <option value="">---Select Category---</option>
                         </select>
                    </div>
                    <div class="form-group col-md-6">
                         <label for="category_id">Product Name</label>
                         <select name="category_id" id="category_id" class="form-control">
                            <option value="">---Select Product---</option>
                         </select>
                    </div>
                    <div class="form-group col-md-2" style="padding-top: 30px">
                      <i class="btn btn-primary addeventmore"> + Add Item</i>
                    </div>
                   </div>
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

<script>
    $(function () {
        $('#myForm').validate({
            rules: {
                name: {
                        required: true,
                    },
                supplier_id: {
                        required: true,
                    },
                category_id: {
                        required: true,
                    },
                unit_id: {
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

<script type="text/javascript">
  $(function(){
    $(document).on('change','supplier_id',function(){
      var supplier_id = $(this).val();
      $.ajax({
        url:"{{ route('get_category')}}",
        type: "GET",
        data:{supplier_id:supplier_id},
        success:function(data){
          var html = '<option value="">Select Category</option>';
          $.each(data,function(key,v){
            html +='<option value="'+v.category_id+'">'+v.category_id+'</option>';
          });
          $('#category_id').html(html);
        }
      });
    });
  });
</script>

<script>
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format : 'yyyy-mm-dd',
        });
    </script>


@endsection
