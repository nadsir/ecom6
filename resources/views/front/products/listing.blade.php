
@extends('layouts.front_layout.front_layout');
@section('content')
{{--    <?php dd($_GET['sort']); ?>--}}
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $categoryDetails['breadcrumbs'];?></li>
        </ul>
        <h3> {{$categoryDetails['catDetails']['category_name']}} <small class="pull-right"> {{count($categoryProducts)}} products are available </small></h3>
        <hr class="soft"/>
        <p>
            {{$categoryDetails['catDetails']['description']}}
        </p>
        <hr class="soft"/>
        <form name="sortProducts" id="sortProducts" class="form-horizontal span6">
            <div class="control-group">
                <label class="control-label alignL">Sort By </label>
                <select id="sort" name="sort">
                    <option value="">select</option>
                    <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=="product_latest" ) selected="" @endif>Latest Products</option>
                    <option value="product_name_a_z" @if(isset($_GET['sort']) && $_GET['sort']=="product_name_a_z" ) selected="" @endif>Product name A - Z</option>
                    <option value="product_name_z_a" @if(isset($_GET['sort']) && $_GET['sort']=="product_name_z_a" ) selected="" @endif>Product name Z - A</option>
                    <option value="product_lowest" @if(isset($_GET['sort']) && $_GET['sort']=="product_lowest" ) selected="" @endif>Lowest Price First</option>
                    <option value="product_highest" @if(isset($_GET['sort']) && $_GET['sort']=="product_highest" ) selected="" @endif>Highest Price First</option>
                </select>

            </div>
        </form>
        <div id="myTab" class="pull-right">
            <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
            <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
        </div>
        <br class="clr"/>
        <div class="tab-content">
            <div class="tab-pane" id="listView">
                @foreach($categoryProducts as $product)
                <div class="row">
                    <div class="span2">
                        @if(isset($product['main_image']))
                            <?php $product_image_path = 'images/admin_images/product_images/small/'.$product['main_image']; ?>
                        @else
                            <?php $product_image_path = ''; ?>
                            @endif


                        @if(!empty($product['main_image']) && file_exists($product_image_path))
                            <img src="{{asset($product_image_path)}}" alt="">
                        @else
                            <img src="{{asset('images/admin_images/product_images/medium/no_image.png')}}" alt="">
                        @endif
                    </div>
                    <div class="span4">
                        <h3>{{$product['product_name']}}</h3>
                        <hr class="soft"/>
                        <h5>{{$product['brand']['name']}}</h5>
                        <p>
                            {{$product['description']}}
                        </p>
                        <a class="btn btn-small pull-right" href="product_details.html">View Details</a>
                        <br class="clr"/>
                    </div>
                    <div class="span3 alignR">
                        <form class="form-horizontal qtyFrm">
                            <h3> {{$product['product_price']}}</h3>
                            <label class="checkbox">
                                <input type="checkbox">  Adds product to Compare
                            </label><br/>

                            <a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
                            <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>

                        </form>
                    </div>
                </div>
                <hr class="soft"/>
                @endforeach
            </div>
            <div class="tab-pane  active" id="blockView">
                <ul class="thumbnails">
                    @foreach($categoryProducts as $product)
                    <li class="span3">
                        <div class="thumbnail">
                            <a href="product_details.html">
                                <?php $product_image_path = 'images/admin_images/product_images/small/'.$product['main_image']; ?>
                                @if(!empty($product['main_image']) && file_exists($product_image_path))
                                    <img src="{{asset($product_image_path)}}" alt="">
                                @else
                                    <img src="{{asset('images/admin_images/product_images/medium/no_image.png')}}" alt="">
                                @endif
                            </a>
                            <div class="caption">
                                <h5>{{$product['product_name']}}</h5>
                                <p>
                                    {{$product['brand']['name']}}
                                </p>
                                <h4 style="text-align:center">
                                    <a class="btn" href="product_details.html"><i class="icon-zoom-in"></i></a>
                                    <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a>
                                    <a class="btn btn-primary" href="#">Rs.{{$product['product_price']}}</a></h4>
                            </div>
                        </div>
                    </li>
                    @endforeach

                </ul>
                <hr class="soft"/>
            </div>
        </div>
        <a href="compair.html" class="btn btn-large pull-right">Compare Product</a>
        <div class="pagination">
            @if(isset($_GET['sort']) && !empty($_GET['sort']))

                {{ $categoryProducts->appends(['sort' =>$_GET['sort'] ])->links() }}
            @else
                {{$categoryProducts->links()}}
            @endif
        </div>
        <br class="clr"/>
    </div>
@endsection
