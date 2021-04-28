@extends('layouts.front_layout.front_layout');
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
            <li>
                <a href="{{url('/'.$productDetails['category']['url'])}}">{{$productDetails['category']['category_name']}}</a>
                <span class="divider">/</span></li>
            <li class="active">{{$productDetails['product_name']}} </li>
        </ul>
        <div class="row">
            <div id="gallery" class="span3">
                <a href="{{asset('images/admin_images/product_images/large/'.$productDetails['main_image'])}}"
                   title="Blue Casual T-Shirt">
                    <img src="{{asset('images/admin_images/product_images/large/'.$productDetails['main_image'])}}"
                         style="width:100%" alt="Blue Casual T-Shirt"/>
                </a>
                <div id="differentview" class="moreOptopm carousel slide">
                    <div class="carousel-inner">
                        <div class="item active">
                            @foreach($productDetails['images'] as $image)
                                <a href="{{asset('images/admin_images/product_images/large/'.$image['image'])}}"><img
                                        style="width:29%"
                                        src="{{asset('images/admin_images/product_images/large/'.$image['image'])}}"
                                        alt=""/></a>
                            @endforeach
                        </div>

                    </div>
                    <!--
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                    -->
                </div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <span class="btn"><i class="icon-envelope"></i></span>
                        <span class="btn"><i class="icon-print"></i></span>
                        <span class="btn"><i class="icon-zoom-in"></i></span>
                        <span class="btn"><i class="icon-star"></i></span>
                        <span class="btn"><i class=" icon-thumbs-up"></i></span>
                        <span class="btn"><i class="icon-thumbs-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="span6">
                <h3>{{$productDetails['product_name']}} </h3>
                <small>{{$productDetails['brand']['name']}}</small>
                <hr class="soft"/>
                <small>{{$total_stock}} items in stock</small>
                <form action="{{url('add-to-cart')}}" method="post" class="form-horizontal qtyFrm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$productDetails['id']}}">
                    <div class="control-group">
                        <h4 class="getAttrPrice">Rs.{{$productDetails['product_price']}} </h4>
                        <select name="size" class="span2 pull-left" v-model="selectSize"
                                @change="sendId('{{$productDetails['id']}}')" required>
                            <option value="">Select Size</option>
                            @foreach($productDetails['attributes'] as $attibute)
                                <option>{{$attibute['size']}}</option>
                            @endforeach

                        </select>
                        <input name="quantity" type="number" class="span1" placeholder="Qty." required/>
                        <button type="submit" class="btn btn-large btn-primary pull-right"> Add to cart <i
                                class=" icon-shopping-cart"></i></button>
                    </div>

                </form>

                <hr class="soft clr"/>
                <p class="span6">
                    {{$productDetails['description']}}
                </p>
                <a class="btn btn-small pull-right" href="#detail">More Details</a>
                <br class="clr"/>
                <a href="#" name="detail"></a>
                <hr class="soft"/>
            </div>

        </div>
        <div>
            <tabs :options="{ useUrlFragment: false }" @clicked="tabClicked" @changed="tabChanged">
                <tab name=" Product Details">
                    <table class="table table-bordered">
                        <tbody>
                        <tr class="techSpecRow">
                            <th colspan="2">Product Details</th>
                        </tr>
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Brand:</td>
                            <td class="techSpecTD2">{{$productDetails['brand']['name']}}</td>
                        </tr>
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Code:</td>
                            <td class="techSpecTD2">{{$productDetails['product_code']}}</td>
                        </tr>
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Color:</td>
                            <td class="techSpecTD2">{{$productDetails['product_color']}}</td>
                        </tr>
                        @if($productDetails['fabric'])
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Fabric:</td>
                                <td class="techSpecTD2">{{$productDetails['fabric']}}</td>
                            </tr>
                        @endif
                        @if($productDetails['pattern'])
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Pattern:</td>
                                <td class="techSpecTD2">{{$productDetails['pattern']}}</td>
                            </tr>
                        @endif
                        @if($productDetails['sleeve'])
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Pattern:</td>
                                <td class="techSpecTD2">{{$productDetails['sleeve']}}</td>
                            </tr>
                        @endif
                        @if($productDetails['fit'])
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Pattern:</td>
                                <td class="techSpecTD2">{{$productDetails['fit']}}</td>
                            </tr>
                        @endif
                        @if($productDetails['occasion'])
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Pattern:</td>
                                <td class="techSpecTD2">{{$productDetails['occasion']}}</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </tab>
                <tab name="Related Products"style="align-content: center" >
                    <div class="tab-pane active" id="blockView" style="margin-left: 5px">
                        <ul class="thumbnails" style="align-content: center" align="center">
                            @foreach($relatedProducts as $product)
                            <li class="span3" style="margin-left: 5px !important;">
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
                                        <hr>
                                        <h5>{{$product['product_code']}}</h5>
                                        <p>
                                            {{$product['description']}}
                                        </p>
                                        <h4 style="text-align:center">
                                            <a class="btn" href="product_details.html">
                                                <i class="icon-zoom-in"></i>
                                            </a>
                                            <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i>
                                            </a>
                                            <a class="btn btn-primary" href="#">Rs.{{$product['product_price']}}</a>
                                        </h4>
                                    </div>
                                </div>
                            </li>
                            @endforeach

                        </ul>

                    </div>
                </tab>
                {{--                <tab name="Disabled tab" :is-disabled="true">
                                    This content will be unavailable while :is-disabled prop set to true
                                </tab>
                                <tab id="oh-hi-mark" name="Custom fragment">
                                    The fragment that is appended to the url can be customized
                                </tab>
                                <tab  prefix="<span class='glyphicon glyphicon-star'></span> "
                                      name="Prefix and suffix"
                                      suffix=" <span class='badge'>4</span>">
                                    A prefix and a suffix can be added
                                </tab>--}}
            </tabs>
        </div>
    </div>

@endsection
