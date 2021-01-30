@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if($errors->any())
                            <div class="alert alert-danger" style="margin-top: 10px">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(Session::has('flash_message_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                                <strong>Congeradulation</strong>
                                <p>{{Session::get('flash_message_success')}}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Brands</h3>
                                <a href="{{url('admin/add-edit-brand')}}" style="max-width: 150px;float: right" class="btn btn-block btn-success">Add Brand</a>
                            </div>

                        </div>
                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Brandsbrands</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="brands" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($brands as $brand)

                                        <tr>
                                            <td>{{$brand->id}}</td>
                                            <td>{{$brand->name}}</td>
                                            <td>
                                                <a title="Edit Brand" href={{url('admin/add-edit-brand/'.$brand->id)}}><i class="fas fa-edit"></i></a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a title="Delete brand" v-on:click="confirmDelete({{$brand->id}},'brand')" class="confirmDelete"
                                                   name="brand" href="javascript:void (0)" ><i class="fas fa-trash"></i></a>
                                                &nbsp;&nbsp;&nbsp;
                                                @if($brand->status==1)
                                                    <a class="UpdateSectionStatus" section_id="{{$brand->status}}" href="javascript:void(0)" id="brands-{{$brand->id}}" v-on:click="changeBrandsStatus({{$brand->id}})" ><i class="fas fa-toggle-on" status="Active"></i></a>
                                                @else
                                                    <a class="UpdateSectionStatus" section_id="{{$brand->status}}" href="javascript:void(0)" id="brands-{{$brand->id}}" v-on:click="changeBrandsStatus({{$brand->id}})"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                                                @endif</td>
                                        </tr>
                                    @endforeach

                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

    </div>
@endsection

Brandsbrands
