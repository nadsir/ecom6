@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products attributes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
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
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                             style="margin-top: 10px">
                            <strong>Congeradulation</strong>
                            <p>{{Session::get('flash_message_success')}}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(Session::has('error-message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                             style="margin-top: 10px">
                            <strong>Sorry</strong>
                            <p>{{Session::get('error-message')}}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form name="attributeForm" id="attributeForm" method="post"
                          action="{{ url('/admin/add-attributes/'.$productdata->id)}}">@csrf
                        <div class="card-header">
                            <h3 class="card-title">{{$title}}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">product Name : {{$productdata->product_name}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code">product Code : {{$productdata->product_code}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_color">product
                                            color: {{$productdata->product_color}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_color">product
                                            price: {{$productdata->product_price}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="input-group">
                                            <img style="width:120px;"
                                                 src="{{asset('images/admin_images/product_images/small/'.$productdata->main_image)}}"
                                                 alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="field_wrapper">
                                            <div>
                                                <input type="text" name="size[]" id="size" placeholder="Size" value=""
                                                       style="width: 120px " required=""/>
                                                <input type="text" name="sku[]" id="sku" placeholder="Sku" value=""
                                                       style="width: 120px" required=""/>
                                                <input type="number" name="price[]" id="price" placeholder="Price"
                                                       value="" style="width: 120px" required=""/>
                                                <input type="number" name="stock[]" id="stock" placeholder="Stock"
                                                       value="" style="width: 120px" required=""/>
                                                <a href="javascript:void(0);" class="add_button"
                                                   title="Add field">Add</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Attributes</button>
                        </div>
                    </form>
                    <form  name="editAttributeForm" id="editAttributeForm" method="post"
                          action="{{url('/admin/edit-attributes/'.$productdata->id)}}">
                        @csrf

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Added Product Attributes</h3>
                            </div>
                            <div class="card-body">
                                <table id="productsAttr" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Size</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($productdata->attributes as $attribute)

                                        <tr>
                                            <td>{{$attribute->id}}</td>
                                            <td>{{$attribute->size}}</td>
                                            <td>{{$attribute->sku}}</td>
                                            <td>
                                                <input type="number" name="price[]" value="{{$attribute->price}}"
                                                       required="">
                                            </td>
                                            <td>
                                                <input type="number" name="stock[]" value="{{$attribute->stock}}"
                                                       required="">
                                            </td>
                                            <td><input type="hidden" name="attrId[]" value="{{$attribute->id}}"></td>
                                            <td>
                                                @if($attribute->status==1)
                                                    <a class="UpdateAttributeStatus" section_id="{{$attribute->status}}" href="javascript:void(0)" id="attribute-{{$attribute->id}}" v-on:click="changeAttributeStatus({{$attribute->id}})" >Active</a>
                                                @else
                                                    <a class="UpdateAttributeStatus" section_id="{{$attribute->status}}" href="javascript:void(0)" id="attribute-{{$attribute->id}}" v-on:click="changeAttributeStatus({{$attribute->id}})">Inactive</a>
                                                @endif
                                                    <a title="Delete Attribute" v-on:click="confirmDeleteProductStatus({{$attribute->id}},'attribute')" class="confirmDelete"
                                                       name="attribute" href="javascript:void (0)" ><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Attributes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>


@endsection
