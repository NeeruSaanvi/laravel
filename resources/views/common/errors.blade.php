   <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index:999999">
		<div class="modal-dialog" role="document">
			<div class="modal-body">
				<div id="login-overlay" class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Error</h4>
						</div>
						<div class="modal-body">
							<div class="row">
									<div class="well">
										@if (count($errors) > 0)
															<!-- Form Error List -->
											@foreach ($errors->all() as $error)
												<p>{{ $error }}</p>
											@endforeach
											@else
											@if(Session::has('error_msg') )
											        {{Session::get('error_msg')}}
											 @endif
										@endif
										@if(Session::has('error'))
											{!! Session::get('error') !!}	
										@endif

									</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


