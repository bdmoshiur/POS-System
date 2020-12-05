@extends('backend.layouts.master')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage News & Event </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">News & Event</li>
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
                        Edit News & Event
                        <a class="btn btn-success float-right btn-sm"  href="{{ route('news_events.view') }}"><i class="fa fa-list"></i>News & Event List</a>
                    </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('news_events.update', $editData->id) }}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                      <label for="date">Date</label>
                        <input type="text" class="form-control" name="date" id="datepicker" placeholder="YYYY-MM-DD" value="{{ $editData->date }}" readonly>
                    </div>

                    <div class="form-group col-md-8">
                         <label for="short_title">Short Title</label>
                        <input type="text" class="form-control" name="short_title" value="{{ $editData->short_title }}" >
                    </div>
                    <div class="form-group col-md-12">
                         <label for="long_title">Long Title</label>
                         <textarea class="form-control" name="long_title" rows="5">{{ $editData->long_title }}</textarea>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image" >
                    </div>

                    <div class="form-group col-md-2">
                        <img id="showImage" src="{{(!empty($editData->image))? url('upload/news_images/'.$editData->image) : url('upload/no_image.png') }}" style="width: 150px;height: 160px;border: 1px solid #000">
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
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format : 'yyyy-mm-dd',
        });
    </script>





@endsection
