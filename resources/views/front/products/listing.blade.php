
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
            <input type="hidden"  name="url" id="url"  value="{{$url}}" >
            <div class="control-group">
                <label class="control-label alignL">Sort By </label>
                <select {{--id="sort" name="sort"--}} v-on:change="pickSortValue" v-model="sort">
                    <option value="">select</option>
                    <option v-for="option in options" v-bind:value="option.value">
                        @{{option.text}}
                    </option>
                </select>

            </div>
        </form>

        <br class="clr"/>
        <div class="tab-content filter_products">

            @include('front.products.ajax_products_listing')
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
