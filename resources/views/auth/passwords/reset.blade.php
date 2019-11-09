@extends('layouts.restaurant')
@section('page_title')
Reset Password
@stop
@section('content')
<div class="clearfix"></div>
<section class="banner">
  <div class="container login-slider-container">
    
  </div>
</section>
<center><img src="{{url('img/shadow.png')}}" class="img-responsive"></center>
<div class="clearfix"></div>
<section class="account log_in">
  <div class="container">
    <div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1>Reset Password</h1>
        <center><img src="{{url('img/b_line.png')}}" alt="line" class="img-responsive"></center>
        <div class="row">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="/password/reset/{{ $token }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} hide">
                            <div class="col-md-12">
                                <input id="email" type="hidden" class="form-control" name="email" value="{{ $email or old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p>Password<span>*</span></p>
                            <input id="password" type="password" class="validate[required,custom[password]]" placeholder="New Password"  name="password"
                                title="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" minlength="6" pattern="((?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,20})"
                                 required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <p>Password<span>*</span></p>
                           <input id="password-confirm" type="password" class=" validate[required,equals[password]]" placeholder="Confirm New Password" name="password_confirmation"
                                 title="At least 6 characters which inclueds 1 uppercase letter, 1 Lower case Letter, 1 digit, 1 symbol" minlength="6" pattern="((?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,20})"
                                required>
                            @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>
                       <div class="col-md-12">
                        <center><input type="submit" value="Reset Password"><br>
                        </center>
                      </div>
                       
                   </form>
</div>
      </div>
    </div>
  </div>
</section>

<div class="clearfix"></div>
@endsection
@section('footer')
<script type="text/javascript">
   $('html,body').animate({
        scrollTop: $(".account").offset().top},
        'slow');
</script>
@stop
