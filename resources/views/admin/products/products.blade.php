@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                                <strong>Congeradulation</strong>
                                <p>{{Session::get('success_message')}}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
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
                                <h3 class="card-title">Products</h3>
                            </div>

                        </div>
                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Categories</h3>
                                <a href="{{url('admin/add-edit-product')}}" style="max-width: 150px;float: right" class="btn btn-block btn-success">Add Product</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="products" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Products name</th>
                                        <th>Products Code</th>
                                        <th>Products Color</th>
                                        <th>Products Image</th>
                                        <th>Products Category</th>
                                        <th>Products Section</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
product

                                        <tr>
                                            <td>{{$product->id}}</td>
                                            <td>{{$product->product_name}}</td>
                                            <td>{{$product->product_code}}</td>
                                            <td>{{$product->product_color}}</td>
                                            <td>
                                                <?php $product_image_path='images/admin_images/product_images/small/'.$product->main_image;?>
                                                @if(!empty($product->main_image) && file_exists($product_image_path))
                                                <img style="width: 100px" src="{{asset('images/admin_images/product_images/small/'.$product->main_image)}}" alt="">
                                                @else
                                                    <img style="width: 100px" src="{{asset('images/admin_images/product_images/small/no_image.png')}}" alt="">
                                                @endif
                                            </td>
                                            <td>{{$product->category->category_name}}</td>
                                            <td>{{$product->section->name}}</td>
                                            <td>
                                                @if($product->status==1)
                                                    <a class="UpdateProductStatus" section_id="{{$product->status}}" href="javascript:void(0)" id="product-{{$product->id}}" v-on:click="changeProductStatus({{$product->id}})" >Active</a>
                                                @else
                                                    <a class="UpdateProductStatus" section_id="{{$product->status}}" href="javascript:void(0)" id="product-{{$product->id}}" v-on:click="changeProductStatus({{$product->id}})">Inactive</a>
                                                @endif</td>
                                            <td>
                                                <a title="Add Attributes" href={{url('admin/add-attributes/'.$product->id)}}><i class="fas fa-plus"></i></a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a title="Edit Products" href={{url('admin/add-edit-product/'.$product->id)}}><i class="fas fa-edit"></i></a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a title="Delete Products" v-on:click="confirmDelete({{$product->id}},'product')" class="confirmDelete"
                                                    name="product" href="javascript:void (0)" {{--href="{{url('admin/delete-product/'.$product->id)}}"--}}><i class="fas fa-trash"></i></a>
                                            </td>

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
