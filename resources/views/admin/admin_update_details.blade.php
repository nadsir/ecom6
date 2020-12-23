@extends('layouts.admin_layout.admin_layout')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Setting</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Form</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @{{currentpw}}
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Admin Details</h3>
                            </div>
                            <!-- /.card-header -->
                            @if(Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px">
                                    <strong>your wrong!</strong>
                                    <p>{{Session::get('error_message')}}</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                                    <strong>Congeradulation</strong>
                                    <p>{{Session::get('success_message')}}</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        @endif
                            @if($errors->any())
                                <div class="alert alert-danger" style="margin-top: 10px">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif
                        <!-- form start -->
                            <form role="form" method="post" action="{{url('/admin/update-admin-details')}}" name="updateAdminDetails" id="updatePasswordForm" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    {{--                                 <div class="form-group">
                                                                         <label for="exampleInputEmail1">Email address</label>
                                                                         <input type="text" naem="name" id="name" placeholder="Enter Admin/Subdomain Name" class="form-control" value="{{Auth::guard('admin')->user()->name}}" >
                                                                     </div>--}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" value="{{Auth::guard('admin')->user()->email}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Type</label>
                                        <input type="email" class="form-control" value="{{Auth::guard('admin')->user()->type}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        @{{ result }}
                                        <label for="exampleInputPassword1">Name</label>
                                        <input  type="text" name="admin_name" value="{{Auth::guard('admin')->user()->name}}" class="form-control" id="admin_name" placeholder="Enter Admin name">


                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mobile</label>
                                        <input name="admin_mobile" type="text" value="{{Auth::guard('admin')->user()->mobile}}" class="form-control" id="admin_mobile" placeholder="Enter Admin Mobile">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Image</label>
                                        <input name="admin_image" type="file" class="form-control" id="amdin_image">
                                        @if(!empty(Auth::guard('admin')->user()->image))
                                            <a href="{{url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image)}}">view image</a>
                                            <input type="hidden" name="current_admin_image" value="{{Auth::guard('admin')->user()->image}}">
                                        @endif
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" >Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
