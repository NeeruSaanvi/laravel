@extends('layouts/admin_layout')
@section('page_title')
Users
@stop 

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Users</span>
        </li>
    </ul>
</div>
 <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h1 class="page-title"> Users
  </h1>
  <!-- END PAGE TITLE-->
     <!-- END PAGE HEADER-->
 
 		<div class="row {{$action=='none'?'hide':''}}">
         <div class="col-sm-12">
            <div class="portlet-body form">
                @if($action!='edit')
                    <form class="form-horizontal" method="post" action="/admin/users"  enctype="multipart/form-data">
                @else
                    <form class="form-horizontal" method="post" action="/admin/users/{{$users->uniqueid}}"  enctype="multipart/form-data">
                @endif
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">     
                   
                    <div class="form-group">
                        <label class="col-md-12" for="description">First Name</label>
                        <div class="col-md-12">
                            <input name="name" class="form-control validate[required,custom[onlyLetterSp]]" value="{{old('name')?e(old('name')):$users->name}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Last Name</label>
                        <div class="col-md-12">
                            <input name="last_name" class="form-control validate[required,custom[onlyLetterSp]]" value="{{old('last_name')?e(old('last_name')):$users->last_name}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Email</label>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control validate[required,custom[email]]" value="{{old('email')?e(old('email')):$users->email}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Phone</label>
                        <div class="col-md-12">
                            <input name="phone" class="form-control validate[required,custom[phone]]" value="{{old('phone')?e(old('phone')):$users->phone}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                            <div class="col-md-12">
                                <p><input type="checkbox" name="newsletter" value="1" @if($users->newsletter == 1) checked @endif>&nbsp;&nbsp;&nbsp;Subscribe to the Club Sip &amp; Savour newsletter here.<span></span></p>
                            </div>
                        </div>  
                         <div class="form-group">
                        <label class="col-md-12" for="description">Indicate Work Status Please</label>
                        <div class="col-md-12">
                            <select class="form-control" name="work_status">
                                <option @if($users->work_status == "") selected @endif value="">Select Work Status</option>
                                <option @if($users->work_status == "Work Full Time") selected @endif value="Work Full Time">Work Full Time</option>
                                <option @if($users->work_status == "Work Part Time") selected @endif value="Work Part Time">Work Part Time</option>
                                <option @if($users->work_status == "Student Work Part Time") selected @endif value="Student Work Part Time">Student / Work Part Time</option>
                                <option @if($users->work_status == "Student Full Time") selected @endif value="Student Full Time">Student Full Time</option>
                                <option @if($users->work_status == "Homemaker") selected @endif value="Homemaker">Homemaker</option>
                            </select>
                        </div>
                    </div>
                       <div class="form-group">
                        <label class="col-md-12" for="description">Type Of Work You Do</label>
                        <div class="col-md-12">
                            <select class="form-control" name="work_type">
                               <option @if($users->work_type == "") selected @endif value="">Select Work Type</option>
                                <option @if($users->work_type == "CEO CFO") selected @endif value="CEO CFO">CEO / CFO</option>
                                <option @if($users->work_type == "Medical") selected @endif value="Medical">Medical</option>
                                <option @if($users->work_type == "Financial") selected @endif value="Financial">Financial</option>
                                <option @if($users->work_type == "Legal") selected @endif value="Legal">Legal</option>
                                <option @if($users->work_type == "Teaching") selected @endif value="Teaching">Teaching</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">How Often Do You Dine Out</label>
                        <div class="col-md-12">
                            <select class="form-control" name="dine_out">
                               <option @if($users->dine_out == "") selected @endif value="">Select Work Type</option>
                                <option @if($users->dine_out == "Once Per Week") selected @endif value="Once Per Week">Once Per Week</option>
                                <option @if($users->dine_out == "Twice Per Week") selected @endif value="Twice Per Week">Twice Per Week</option>
                                <option @if($users->dine_out == "Three Times Per Week") selected @endif value="Three Times Per Week">Three Times Per Week</option>
                                <option @if($users->dine_out == "Four Times Per Week") selected @endif value="Four Times Per Week">Four Times Per Week</option>
                                <option @if($users->dine_out == "Five Times Per Week") selected @endif value="Five Times Per Week">Five Times Per Week</option>
                                <option @if($users->dine_out == "Daily") selected @endif value="Daily">Daily</option>
                                <option @if($users->dine_out == "Multiple Times Per Day") selected @endif value="Multiple Times Per Day">Multiple Times Per Day</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">What Part Of The App Will You Use Most</label>
                        <div class="col-md-12">
                            <select class="form-control" name="offer_like">
                                <option value="" @if($users->offer_like == "") selected @endif>Select Work Type</option>
                                @foreach($allOffer as $offer)
                                <option value="{{$offer->id}}" @if($users->offer_like == $offer->id) selected @endif>{{$offer->name}}</option>
                                @endforeach
                                <option value="0"  @if($users->offer_like == 0) selected @endif>Will Use Both Equally</option>
                             </select>
                        </div>
                    </div>

                   
                    <div class="form-group">
                        <label class="col-md-12" for="description">Address</span></label>
                        <div class="col-md-12">
                            <input name="building" class="form-control validate[required]" value="{{old('building')?e(old('building')):$users->building}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description"></span></label>
                        <div class="col-md-12">
                            <input name="street" class="form-control" value="{{old('street')?e(old('street')):$users->street}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">City</span></label>
                        <div class="col-md-12">
                            <input name="city" class="form-control validate[required,custom[onlyLetterSp]]" value="{{old('city')?e(old('city')):$users->city}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Pin Code</span></label>
                        <div class="col-md-12">
                            <input name="pincode" class="form-control validate[required,custom[zip]]" value="{{old('pincode')?e(old('pincode')):$users->pincode}}"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">Country</span></label>
                        <div class="col-md-12">
                            <select name="country" class="form-control country validate[required]" id="country" required>
                                <option value="">Select</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{(old('country')?e(old('country')):$users->country)==$country->id?'selected':''}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="description">State</span></label>
                        <div class="col-md-12">
                            <select name="state" id="state" class="form-control state validate[required]" required>
                                <option value="">Select</option>
                                @foreach($states as $state)
                                    <option value="{{$state->name}}" {{(old('state')?e(old('state')):$users->state)==$state->name?'selected':''}}>{{$state->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <p><input type="checkbox" name="status" value="1" @if($users->status == 1) checked @endif>&nbsp;&nbsp;&nbsp;Active<span></span></p>
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
                <i class="fa fa-globe"></i>Users</div>
            <div class="tools"> </div>
        </div>

        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>City</th>
                    <th>E-Mail</th>
                    <th>Phone</th>
                    <th></th>
                 </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($users_all as $user)
                   <?php $i=$i+1; ?>
                   <tr>
                    <td>{{ $user->name.' '.$user->last_name }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        <a href="/admin/users/{{ $user->uniqueid }}" class="text-info"> <i class="fa fa-pencil"></i></a></td>
                  </tr>
                    @endforeach
                    
                </tbody>
              </table>
         </div> 
    </div>
@stop
@section('footer')

<script type="text/javascript">
    $('body').on('change', 'select.country', function() {
      var select=$(this).parent().parent().next('div').find('select.state');
      $.get("/admin/ajaxstates?country="+$(this).val(), function(data){
            // Display the returned data in browser
            select.html(data);
      });
    });
 
</script>
@stop