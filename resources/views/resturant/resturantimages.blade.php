@extends('layouts/resturant_layout')
@section('page_title')
Restaurant
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/resturant">Dashboard</a>
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
                    <form class="form-horizontal" method="post" action="/resturant/resturant_images"  enctype="multipart/form-data">
                @else
                    <form class="form-horizontal" method="post" action="/resturant/resturant_images/{{$resturant->id}}"  enctype="multipart/form-data">
                @endif
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                    <div class="form-group">
                        <label class="col-md-12" for="description">Image Location</span></label>
                        <div class="col-md-12">
                            <select name="image_type" class="form-control validate[required]" id="image_type" required>
                                      <option value="menu" {{(old('image_type')?e(old('image_type')):$resturant->image_type)=='menu'?'selected':''}}>Menu</option>
                                 <!--  <option value="slider" {{(old('image_type')?e(old('image_type')):$resturant->image_type)=='slider'?'selected':''}}>Slider</option> -->
                                    <option value="gallery" {{(old('image_type')?e(old('image_type')):$resturant->image_type)=='gallery'?'selected':''}}>Gallery</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="description">Image</span></label>
                        <div class="col-md-12">
                            <input type="file" class="form-control validate[checkFileType[jpg|jpeg|gif|JPG|png|PNG],checkFileSize[1]]" title="Only PNG, JPG, GIF" name="image_path" {{$resturant->image_path==null?'required':''}} />
                            @if($resturant->image_path!=null)
                                <img src="{{ Config::get('images.user_images').$resturant->image_path }}" style="width:100px">

                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Display Order</span></label>
                        <div class="col-md-12">
                            <input type="number" min="0" class="form-control validate[required,custom[onlyNumberSp]]"  name="display_order" value="{{old('display_order')?e(old('display_order')):$resturant->display_order}}" required />
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
                    <th>Location</th>
                    <th>Image</th>
                    <th>Order</th>
                    <th></th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($resturant_all as $rest)
                   <?php $i=$i+1; ?>
                   <tr>
                    <td>{{ $rest->image_type }}</td>
                    <td><img src="{{ Config::get('images.user_images').$rest->image_path }}" style="width:100px"></td>
                    <td>{{ $rest->display_order }}</td>
                    <td>
                        <a href="/resturant/resturant_images/delete/{{ $rest->id }}"> <i class="fa fa-trash"></i></a>
                         &nbsp;&nbsp; |&nbsp;&nbsp;
                        <a href="/resturant/resturant_images/{{ $rest->id }}" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                  </tr>
                    @endforeach
                    @if($i==0)
                   <tr>
                    <td colspan="4" align="center">No Image Found</td>
                    </tr>
                        
                    @endif
                </tbody>
              </table>
         </div> 
    </div>
@stop
