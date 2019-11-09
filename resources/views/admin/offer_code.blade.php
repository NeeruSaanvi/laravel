@extends('layouts/admin_layout')
@section('page_title')
Offer Codes
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Offer Codes</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Offer Codes
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 
 		<div class="row">
		 <div class="col-sm-12">
            <div class="portlet-body form">
                @if($action!='edit')
                    <form class="form-horizontal" method="post" action="/admin/offercode"  enctype="multipart/form-data">
                @else
                    <form class="form-horizontal" method="post" action="/admin/offercode/{{$offercode->id}}"  enctype="multipart/form-data">
                @endif
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                    <input type="hidden" name="price" value="0">     
                   <div class="form-group">
                        <label class="col-md-12" for="description">Name</span></label>
                        <div class="col-md-12">
                            <input name="name" class="form-control validate[required,custom[onlyLetterSp]]" value="{{old('name')?e(old('name')):$offercode->name}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Offer Code</span></label>
                        <div class="col-md-12">
                            <input name="offer_code" class="form-control validate[required]" value="{{old('offer_code')?e(old('offer_code')):$offercode->offer_code}}"  required>
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
                    <th>Offer Code</th>
                    <th></th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($offercode_all as $offer)
                   <?php $i=$i+1; ?>
                   <tr>
                    <td>{{ $offer->name }}</td>
                    <td>{{ $offer->offer_code }}</td>
                    <td>
                        <a href="/admin/offercode/delete/{{ $offer->id }}"> <i class="fa fa-trash"></i></a>
                         &nbsp;&nbsp; |&nbsp;&nbsp;
                       <a href="/admin/offercode/{{ $offer->id }}" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
         </div> 
    </div>
@stop