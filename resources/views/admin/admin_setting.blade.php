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
                                <h3 class="card-title">Update Password</h3>
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
                            <!-- form start -->
                            <form role="form" method="post" action="{{url('/admin/update-current-pwd')}}" name="updatePasswordForm" id="updatePasswordForm">@csrf
                                <div class="card-body">
   {{--                                 <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="text" naem="name" id="name" placeholder="Enter Admin/Subdomain Name" class="form-control" value="{{Auth::guard('admin')->user()->name}}" >
                                    </div>--}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" value="{{$adminResult->type}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Type</label>
                                        <input type="email" class="form-control" value="{{Auth::guard('admin')->user()->type}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        @{{ result }}
                                        <label for="exampleInputPassword1">Current Password</label>
                                        <input v-bind:style="{ 'border-color': color }" v-on:keyup="key" v-model="currentpw" type="password" name="current_pwd" class="form-control" id="current_pwd" placeholder="Enter Current Password">
                                        <p v-if="result==''" v-bind:style="{ 'color': color }">Please Enter Password</p>
                                        <p v-if="result==true" v-bind:style="{ 'color': color }">You Enter Currect Password</p>
                                        <p v-else-if="result!=''" v-bind:style="{ 'color': color }">You Enter Wrong  Password</p>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">New Password</label>
                                        <input name="new_pwd" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter New Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Conform Password</label>
                                        <input name="confirm_pdw" type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm New Password">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
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
