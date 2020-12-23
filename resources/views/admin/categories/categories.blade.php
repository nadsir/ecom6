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
                                <h3 class="card-title">Categories</h3>
                            </div>

                        </div>
                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Categories</h3>
                                <a href="{{url('admin/add-edit-category')}}" style="max-width: 150px;float: right" class="btn btn-block btn-success">Add Category</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="categories" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Patent Category</th>
                                        <th>Section</th>
                                        <th>URL</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $category)
                                        @if(!isset($category->parentcategory->category_name))
                                            <?php $parent_category="ROOT";?>
                                        @else
                                            <?php $parent_category=$category->parentcategory->category_name; ?>
                                        @endif

                                        <tr>
                                            <td>{{$category->id}}</td>
                                            <td>{{$category->category_name}}</td>
                                            <td>{{$parent_category}}</td>
                                            <td>{{$category->section->name}}</td>
                                            <td>{{$category->url}}</td>
                                            <td>
                                                @if($category->status==1)
                                                    <a class="UpdateCategoryStatus" section_id="{{$category->status}}" href="javascript:void(0)" id="category-{{$category->id}}" v-on:click="changeCategoryStatus({{$category->id}})" >Active</a>
                                                @else
                                                    <a class="UpdateCategoryStatus" section_id="{{$category->status}}" href="javascript:void(0)" id="category-{{$category->id}}" v-on:click="changeCategoryStatus({{$category->id}})">Inactive</a>
                                                @endif</td>
                                            <td>
                                                <a href={{url('admin/add-edit-category/'.$category->id)}}"">Edit</a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a  v-on:click="confirmDelete({{$category->id}},'category')" class="confirmDelete"
                                                    name="category" href="javascript:void (0)" {{--href="{{url('admin/delete-category/'.$category->id)}}"--}}>Delete</a>
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
