@extends('backend.layouts.app')
@section('content')
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
<section class="users-list-wrapper">
               <div class="users-list-table">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-content">
									<div class="card-header">
										<div class="row">
											<div class="col-12 col-sm-7">
												<h5 class="pt-2">Enquiry Data Import</h5>
											</div>
										
										</div>
									</div>
									<!-- <hr class="mb-0"> -->
									<div class="card-body">
										<form id="importExcelFile" method="post" action="importExcelFile" enctype="multipart/form-data">
											{{-- <h4 class="form-section"><i class="ft-info"></i> Filter Parameter</h4> --}}
											@csrf
											<div class="row">
												<div class="col-sm-12">
													<br/>
													@php
                                                            $success = session('success');
                                                            @endphp
                                                            @if($success)
															<div class="alert bg-light-success alert-dismissible mb-2" role="alert">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
																</button>
																<span><strong>SUCCESS : </strong>{{ $success }}</span>
                                            				</div>
                                                            @endif
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
												  	<label>IMPORT XLS FILE <span style="color:#ff0000">*</span></label>
													<input type="file" id="importexcel" name="importexcel" class="form-control required"><br/>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
													<br/>
													@php
                                                            $status = session('status');
                                                            @endphp
                                                            @if($status)
                                                                <div class='badge bg-light-danger mb-1 mr-2 errors'>
                                                                    <strong>ERROR : </strong>{{ $status }}
                                                                </div>
                                                            @endif
												</div>
												@if (count($errors) > 0)
												<div class="col-sm-12">
													<div class="alert alert-danger alert-dismissible">
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
														<h4><i class="icon fa fa-ban"></i> Error!</h4>
														@foreach($errors->all() as $error)
														{{ $error }} <br>
														@endforeach      
													</div>
												</div>
												@endif
											</div>
											
											<hr>
											<div class="row">
												<div class="col-sm-12">
													<div class="pull-right">
														<button type="submit" class="btn btn-success import">Import</button>
                                                 		<a href="{{URL::previous()}}" class="btn btn-warning px-3 py-1">Cancel</a>
                                                 		<a target="_blank" href="{{URL::to('storage/app/public/uploads/sample/enquiryImportSample.xlsx')}}" class="btn btn-primary px-3 py-1">Download Sample File</a>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
    			</div>
            </section>
		</div>
	</div>
<script>


$(document).on('click', '.import', function (event) {
	$('.errors').text('');
    
});

</script>
@endsection


