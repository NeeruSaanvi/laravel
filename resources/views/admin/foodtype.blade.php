@extends('layouts/admin_layout')
@section('page_title')
Food Types
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Food Type	</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Food Type	
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 

 		<div class="row">
		 <div class="col-sm-12">
            <div class="portlet-body form">
                @if($action!='edit')
                    <form class="form-material form-horizontal" method="post" action="/admin/foodtype">
                @else
                    <form class="form-material form-horizontal" method="post" action="/admin/foodtype/{{$foodtype->id}}">
                @endif
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                    <div class="form-group">
                        <label class="col-md-12" for="description">Food Type</span></label>
                        <div class="col-md-12">
                            <input name="name" class="form-control validate[required,custom[onlyLetterSp]]" value="{{old('name')?e(old('name')):$foodtype->name}}">
                        </div>
                    </div>
                    <div class="form-actions">
                    <button type="submit" class="btn  blue">Submit</button></div>
                </form>    
            </div>
        </div>
	</div>
      <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-globe"></i>Food Type</div>
            <div class="tools"> </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" width="100%">             <thead>
                  <tr>
                    <th>Food Type</th>
                    <th>Action</th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($foodtype_all as $foodtype)
                   <?php $i=$i+1; ?>
                   <tr>
                    <td>{{ $foodtype->name }}</td>
                    <td>
                        <a href="/admin/foodtype/delete/{{ $foodtype->id }}"> <i class="fa fa-trash"></i></a>
                         &nbsp;&nbsp; |&nbsp;&nbsp;
                        <a href="/admin/foodtype/{{ $foodtype->id }}" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                  </tr>
                    @endforeach
                </tbody>
              </table>
        </div> 
    </div>
@stop