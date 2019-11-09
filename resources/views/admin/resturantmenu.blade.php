@extends('layouts/admin_layout')
@section('page_title')
Restaurant
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Restaurant</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Restaurant
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 
 		<div class="row">
		 <div class="col-sm-12">
            <div class="portlet-body form">
                @if($action!='edit')
                    <form class="form-horizontal" method="post" action="/admin/resturant_menu"  enctype="multipart/form-data">
                @else
                    <form class="form-horizontal" method="post" action="/admin/resturant_menu/{{$resturant->id}}"  enctype="multipart/form-data">
                @endif
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                   <div class="form-group">

                        <label class="col-md-12" for="description">Restaurant Name</span></label>
                        <div class="col-md-12">
                            <select name="username" class="form-control validate[required]" id="username" required>
                                <option value="">Select</option>
                                @foreach($users_all as $user)
                                    <option value="{{$user->username}}" {{(old('username')?e(old('username')):$resturant->username)==$user->username?'selected':''}}>{{$user->rest_name}}</option>
                                @endforeach
                            </select>
                        
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-md-12" for="description">Item Name</span></label>
                        <div class="col-md-12">
                            <input name="item_name" class="form-control validate[required]" value="{{old('item_name')?e(old('item_name')):$resturant->item_name}}"  required>
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-md-12" for="description">Price</span></label>
                        <div class="col-md-12">
                            <input name="price" class="form-control" value="{{old('price')?e(old('price')):$resturant->price}}"  required>
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-md-12" for="description">Description</span></label>
                        <div class="col-md-12">
                            <input name="description" class="form-control" value="{{old('description')?e(old('description')):$resturant->description}}">
                        </div>
                    </div>
                        

                    <div class="form-group">
                        <label class="col-md-12" for="description">Offer Valid</span></label>
                        <div class="col-md-12">
                            <select name="offer_id" class="form-control validate[required]" id="offer_id" required>
                                    <option value="-1" {{(old('offer_id')?e(old('offer_id')):$resturant->offer_id)==-1?'selected':''}}>None</option>
                                    @foreach($offers_all as $offer)
                                    <option value="{{$offer->id}}" {{(old('offer_id')?e(old('offer_id')):$resturant->offer_id)==$offer->id?'selected':''}}>{{$offer->name}}</option>
                                   @endforeach
                                    <option value="0" {{(old('offer_id')?e(old('offer_id')):$resturant->offer_id)==0?'selected':''}}>Both</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="description">Image</span></label>
                        <div class="col-md-12">
                            <input type="file" class="form-control validate[checkFileType[jpg|jpeg|gif|JPG|png|PNG],checkFileSize[1]]"  title="Only PNG, JPG, GIF" name="image" {{$resturant->image==null?'required':''}} />
                            @if($resturant->image!=null)
                                <img src="{{ Config::get('images.user_images').$resturant->image }}" style="width:100px">

                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Display Order</span></label>
                        <div class="col-md-12">
                            <input type="number" min="0" class="form-control validate[required,custom[onlyNumberSp]]" name="display_order" value="{{old('display_order')?e(old('display_order')):$resturant->display_order}}" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Popular Item</span></label>
                        <div class="col-md-12">
                            <input type="checkbox"  name="popular_item" value="1" {{old('popular_item')?e(old('popular_item')):$resturant->popular_item?'checked':''}} />
                        </div>
                    </div>
                   

                    <hr>
                  
                    
                    <div class="col-sm-12 row">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>    
            </div>
        </div>
	</div>
    <br>
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-globe"></i>Restaurant</div>
            <div class="tools"> </div>
        </div>

        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Order</th>
                    <th></th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($resturant_all as $rest)
                   <?php $i=$i+1; ?>
                   <tr>
                    <td>{{ $rest->rest_name }}</td>
                    <td>{{ $rest->item_name }}</td>
                    <td>{{ $rest->price }}</td>
                    <td>{{ $rest->display_order }}</td>
                    <td>
                        <a href="/admin/resturant_menu/delete/{{ $rest->id }}"> <i class="fa fa-trash"></i></a>
                         &nbsp;&nbsp; |&nbsp;&nbsp;
                        <a href="/admin/resturant_menu/{{ $rest->id }}" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                  </tr>
                    @endforeach
                </tbody>
              </table>
         </div> 
    </div>
@stop
