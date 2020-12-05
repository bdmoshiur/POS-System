


@extends('backend.layouts.master')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
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
                        Edit Profile
                        <a class="btn btn-success float-right btn-sm"  href="{{ route('profiles.view') }}"><i class="fa fa-list"></i>Your Profile</a>
                    </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('profiles.update') }}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">

                    <div class="form-group col-md-4">
                      <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{isset($editData)? $editData->name : '' }}">
                        <font style="color:red">{{ ($errors->has('name')) ? ($errors->first('name')):'' }}</font>
                    </div>
                      <div class="form-group col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="{{isset($editData)? $editData->email : '' }}">
                         <font style="color:red">{{ ($errors->has('email')) ? ($errors->first('email')):'' }}</font>
                       </div>
                      <div class="form-group col-md-4">
                      <label for="mobile">Mobile No</label>
                        <input type="text" class="form-control" name="mobile" value="{{isset($editData)? $editData->mobile : '' }}">
                        <font style="color:red">{{ ($errors->has('mobile')) ? ($errors->first('mobile')):'' }}</font>
                    </div>
                     <div class="form-group col-md-4">
                      <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" value="{{isset($editData)? $editData->address : '' }}">
                        <font style="color:red">{{ ($errors->has('address')) ? ($errors->first('address')):'' }}</font>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Male"{{($editData->gender =='Male') ? 'selected' : '' }}>Male</option>
                            <option value="Female"{{($editData->gender =='Female') ? 'selected' : '' }} >Female</option>
                         </select>
                          <font style="color:red">{{ ($errors->has('gender')) ? ($errors->first('gender')):'' }}</font>
                    </div>

                     <div class="form-group col-md-4">
                      <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image" value="{{isset($editData)? $editData->image : '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <img id="showImage" src="{{ (!empty($editData->image)) ? url('upload/user_images/'.$editData->image):url('upload/no_image.png')}}" style="width: 150px;height: 160px;border: 1px solid #000">
                    </div>
                    <div class="form-group col-md-6" style="padding-top: 30px">
                        <input type="submit" class="btn btn-primary" value="Update" >
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





  <script>
$(function () {
  $('#myForm').validate({
    rules: {
      name: {
        required: true,
      },
      gender: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 6
      },
       password2: {
        required: true,
        equalTo: '#password'
      },

    },
    messages: {
      name: {
        required: "Please enter the User Name",
      },
      gender: {
        required: "Please select a  Gender",
      },
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
       password2: {
        required: "Please enter confirm password",
        equalTo: "Confirm password dose not match"
      },

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
