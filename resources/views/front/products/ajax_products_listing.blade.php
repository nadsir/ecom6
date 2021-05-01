<?php
use App\product;
?>
<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach($categoryProducts as $product)
            <li class="span3">
                <div class="thumbnail">
                    <a href="{{url('/product/'.$product['id'])}}">
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
                        <?php
                          $discounted_price=Product::getDiscounterPrice($product['id']);
                        ?>
                        <h4 style="text-align:center">
                            <a class="btn" href="product_details.html">
                                <i class="icon-zoom-in"></i>
                            </a>
                            <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a>
                            <a class="btn btn-primary" href="#">
                                @if($discounted_price>0)
                                <del>Rs.{{$product['product_price']}}</del>
                                @else
                                    Rs.{{$product['product_price']}}
                                @endif
                            </a>
                        </h4>
                        @if($discounted_price>0)
                            <h4>Discounted Price:{{$discounted_price}}</h4>
                        @endif
                        <p>{{$product['fabric']}}</p>
                        <p>{{$product['sleeve']}}</p>
                        <p>{{$product['pattern']}}</p>
                        <p>{{$product['fit']}}</p>
                        <p>{{$product['occasion']}}</p>

                    </div>
                </div>
            </li>
        @endforeach

    </ul>
    <hr class="soft"/>
</div>
