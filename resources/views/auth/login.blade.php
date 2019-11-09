@extends('layouts.restaurant')
@section('page_title')
Log In
@stop
@section('content')
<div class="clearfix"></div>
<section class="banner hidden-xs">
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
				<h1>Log In</h1>
				<center><img src="{{url('img/b_line.png')}}" alt="line" class="img-responsive"></center>
				<h5>New here? <a href="/user-register-step-1" class="sign-up">Sign Up</a></h5>
				<div class="row">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
					<span class="alert-danger" id="form-errors"></span>
            		{{ csrf_field() }}
						<div class="col-md-12 email">
							<p>Email<span>*</span></p>
							<input type="email" name="email" value="{{ old('email') }}"  class="validate[required,custom[email]]">
							@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
						</div>
						<div class="col-md-12 password">
							<p>Password<span>*</span></p>
							<input type="password" name="password" class="validate[required]" required>
							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-md-12">
							<center><input type="submit" value="SIGN IN"><br>
							<a class="forgot" href="/password/email">Forgot Password</a></center>
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
<script type="text/javascript">
  
    $('input[type=submit]').click(function(e){


    var $btn = $(this).button('loading');

    e.preventDefault();
   
    var form = jQuery(this).parents("form:first");
    var dataString = form.serialize();
    var formAction = form.attr('action');

    $.ajax({
        type: "POST",
        url : formAction,
        data : dataString,
        success : function(data){
            console.log(data);

            setTimeout(
                function()
                {
                   setTimeout(
                        function()
                        {
                            window.location.href = data.link;

                        }, 2000);

                }, 2000);

        },
        error : function(data){
            var errors = $.parseJSON(data.responseText);
            console.log(errors);

            setTimeout(
                function()
                {
                   errorsHtml = '<ul>';
                    $.each( errors , function( key, value ) {
                        errorsHtml += '<li style="color:#35393b;">' + value + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></di>';

                    $( '#form-errors' ).html( errorsHtml ); //appending to a <div id="form-errors"></div> inside form

                    $btn.button('SIGN IN');

                }, 1500);

        }

    },"json");
});
</script>
@stop
