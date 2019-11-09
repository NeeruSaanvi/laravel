   <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index:999999">
		<div class="modal-dialog" role="document">
			<div class="modal-body">
				<div id="login-overlay" class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Message</h4>
						</div>
						<div class="modal-body">
							<div class="row">
									<div class="well">
										@if(Session::has('message'))
											{!! Session::get('message') !!}	
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






<!-- http://www.queness.com/resources/html/project/index.html -->