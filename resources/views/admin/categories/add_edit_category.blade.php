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
                            <li class="breadcrumb-item active">Categories</li>
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
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                                <strong>Congeradulation</strong>
                                <p>{{Session::get('flash_message_success')}}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    <form name="categoryForm" id="categoryForm"
                          @if(empty($categorydata['id']))
                          action="{{url('admin/add-edit-category')}}"
                          @else
                          action="{{url('admin/add-edit-category/'.$categorydata['id'])}}"
                          @endif
                          method="post" enctype="multipart/form-data">@csrf
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
                                        <label for="category_name">Category Name</label>
                                        <input type="text" class="form-control" name="category_name" id="category_name"
                                               placeholder="Enter Category Name"
                                               @if(!empty($categorydata['category_name']))
                                               value="{{$categorydata['category_name']}}"
                                               @else
                                               value="{{old('category_name')}}"
                                            @endif

                                        >
                                    </div>
                                    <div id="appendCategoriesLevel">
                                        @include('admin.categories.append_categories_level')
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Section</label>
                                        <select name="section_id" id="section_id" class="form-control select2"
                                                style="width: 100%;" v-on:change="onChangeSection">
                                            <option selected="selected">Select</option>
                                            @foreach ($getSections as $getSection )
                                                <option value="{{$getSection->id}}"
                                                        @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$getSection->id)
                                                        selected
                                                    @endif
                                                >{{$getSection->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Category Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="category_image"
                                                       name="category_image">
                                                <label class="custom-file-label" for="category_image">Choose
                                                    file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        @if(!empty($categorydata['category_image']))
                                            <div>
                                                <img style="width:80px;margin-top: 5px" src="{{asset('images/admin_images/category_images/'.$categorydata['category_image'])}}" alt="">
                                                &nbsp;
                                                <a href="javascript:void (0)" v-on:click="confirmDelete({{$categorydata['id']}},'category-image')" class="confirmDelete" {{--href="{{url('admin/delete-category-image/'.$categorydata['id'])}}"--}}>Delete Image</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="Category_name">Category Discount</label>
                                        <input type="text" class="form-control" id="category_discount"
                                               name="category_discount" placeholder="Enter Category Name"
                                               @if(!empty($categorydata['category_discount']))
                                               value="{{$categorydata['category_discount']}}"
                                               @else
                                               value="{{old('category_discount')}}"
                                            @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="Category_name">Category Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"
                                        placeholder="Enter ...">@if(!empty($categorydata['description'])){{
                                        $categorydata['description']}}@else {{old('description')}}@endif
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="Category_name">Category URL</label>
                                        <input type="text" name="url" class="form-control" id="url"
                                               placeholder="Enter Category Name"
                                               @if(!empty($categorydata['url']))
                                               value="{{$categorydata['url']}}"
                                               @else
                                               value="{{old('url')}}"
                                            @endif
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="Category_name">Meta Title</label>
                                        <textarea id="meta_title" name="meta_title" class="form-control" rows="3"
                                                  placeholder="Enter ...">@if(!empty($categorydata['meta_title'])){{
                                        $categorydata['meta_title']}}@else {{old('meta_title')}}@endif
                                        </textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="Category_name">Meta Description</label>
                                        <textarea id="meta_desctiption" name="meta_description" class="form-control"
                                                  rows="3"
                                                  placeholder="Enter ...">@if(!empty($categorydata['meta_description'])){{
                                        $categorydata['meta_description']}}@else {{old('meta_description')}}@endif
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="Category_name">Meta Keywords</label>
                                        <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="3"
                                                  placeholder="Enter ...">@if(!empty($categorydata['meta_keywords'])){{
                                        $categorydata['meta_keywords']}}@else {{old('meta_keywords')}}@endif
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>


@endsection
