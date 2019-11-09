@extends('layouts/admin_layout')
@section('page_title')
Offers
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Offers</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Offers
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 
 		<div class="row">
		 <div class="col-sm-12">
            <div class="portlet-body form">
                @if($action!='edit')
                    <form class="form-horizontal hide" method="post" action="/admin/offers"  enctype="multipart/form-data">
                @else
                    <form class="form-horizontal" method="post" action="/admin/offers/{{$offerss->id}}"  enctype="multipart/form-data">
                @endif
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                    <input type="hidden" name="price" value="0">     
                   <div class="form-group">
                        <label class="col-md-12" for="description">Offer</span></label>
                        <div class="col-md-12">
                            <input name="name" class="form-control validate[required]" value="{{old('name')?e(old('name')):$offerss->name}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Time Limit(minutes)</span></label>
                        <div class="col-md-12">
                            <input type="number" name="time_limit" class="form-control validate[required,custom[onlyNumberSp]]" value="{{old('time_limit')?e(old('time_limit')):$offerss->time_limit}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Per Day Coupon Purchase Limit for User</span></label>
                        <div class="col-md-12">
                            <input name="perday" type="number" class="form-control validate[required,custom[onlyNumberSp]]" value="{{old('perday')?e(old('perday')):$offerss->perday}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Description</span></label>
                        <div class="col-md-12">
                            <textarea name="description" class="form-control">{{old('description')?e(old('description')):$offerss->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Re-use offer in Given Time Limit</span></label>
                        <div class="col-md-12">
                            <input type="checkbox" name="repurchase" value="1" {{(old('repurchase')?e(old('repurchase')):$offerss->repurchase)!==0?'checked':''}}> 
                           </div>
                    </div>
                   
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
                <i class="fa fa-globe"></i>Offers</div>
            <div class="tools"> </div>
        </div>

        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Time Limit(minutes)</th>
                    <th>Per Day</th>
                    <th>Re-use</th>
                    <th>Description</th>
                    <th></th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($offers_all as $offer)
                   <?php $i=$i+1; ?>
                   <tr>
                    <td>{{ $offer->name }}</td>
                    <td>{{ $offer->time_limit }}</td>
                    <td>{{ $offer->perday }}</td>
                    <td>{{ $offer->repurchase?'Yes':'No' }}</td>
                    <td>{{ $offer->description }}</td>
                    <td>
                       <a href="/admin/offers/{{ $offer->id }}" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                    </tr>
                    @endforeach
                 </tbody>
              </table>
         </div> 
    </div>
@stop