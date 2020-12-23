@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sections</h3>
                        </div>

                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sections</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="sections" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sections as $section)

                                <tr>
                                    <td>{{$section->id}}</td>
                                    <td>{{$section->name}}</td>
                                    <td>
                                        @if($section->status==1)
                                            <a class="UpdateSectionStatus" section_id="{{$section->status}}" href="javascript:void(0)" id="section-{{$section->id}}" v-on:click="changeStatus({{$section->id}})" >Active</a>
                                        @else
                                            <a class="UpdateSectionStatus" section_id="{{$section->status}}" href="javascript:void(0)" id="section-{{$section->id}}" v-on:click="changeStatus({{$section->id}})">Inactive</a>
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

