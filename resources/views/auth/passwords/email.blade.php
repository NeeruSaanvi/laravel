@extends('layouts.restaurant')
@section('page_title')
Reset Password
@stop
@section('content')
<div class="clearfix"></div>
<section class="banner">
  <div class="container login-slider-container">
    
      <div class="col-sm-12 one-time">
        <div>
          
          <div class="col-md-offset-1 col-md-10 col-xs-offset-1 col-xs-10">
          <p class="login-slider-text">“To Everyone @ Crofton Motors, Thank You so much for fixing up my car for me, it looks great!! You did a great job and I just hope that I don't ruin all of your hard work by giving it a good auld bump off a wall or something!! You know what my driving's like!! Thanks again, Sinéad. ”</p>
          
          </div>
        </div>
        <div>
          
          <div class="col-md-offset-1 col-md-10 col-xs-offset-1 col-xs-10">
          <p class="login-slider-text">“To Everyone @ Crofton Motors, Thank You so much for fixing up my car for me, it looks great!! You did a great job and I just hope that I don't ruin all of your hard work by giving it a good auld bump off a wall or something!! You know what my driving's like!! Thanks again, Sinéad. ”</p>
        
          </div>
        </div>
      
    </div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}
                       <div class="col-md-12">
                          <input type="email" name="email" class=" validate[required,custom[email]]" value="{{ old('email') }}" placeholder="E-Mail">
                          @if ($errors->has('email'))
                          <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                        </div>
                        <div class="col-md-12">
                        <center><input type="submit" value="Reset Link"><br>
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