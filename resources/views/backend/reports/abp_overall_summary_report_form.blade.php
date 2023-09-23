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
												<h5 class="pt-2">Overall Summary Review Report</h5>
											</div>
										</div>
									</div>
									<!-- <hr class="mb-0"> -->
									<div class="card-body">
										<form id="generateAbpOverallSummaryReportForm" method="post" action="generateAbpOverallSummaryReport">
											<h4 class="form-section"><i class="ft-info"></i>Filter Parameter</h4>
											@csrf
											<div class="row">
												<div class="col-sm-6">
													<label>ABP Date<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="date_range" name="date_range" readonly><br/>
												</div>
												{{-- <div class="col-sm-6">
													<label>Case Incharge</label>
													<select class="select2" id="ci_id" name="ci_id" style="width: 100% !important;">
														<option value="">All</option>
														@foreach($ci as $ci)
															<option value="{{$ci->id}}">{{$ci->nick_name}}</option>
														@endforeach
													</select><br/>
												</div>
												<div class="col-md-6">
                                                    <label>Product</label>
                                                    <select class="form-control mb-3 select2" id="product_id" name="product_id" style="width: 100% !important;">
                                                        <option value="">All</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                        @endforeach
                                                    </select><br/><br/>
                                                </div>--}}
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
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-12">
													<div class="pull-right">
														<button type="submit" class="btn btn-success export">Export</button>
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
		$(function() {
			$('#date_range').daterangepicker({
				startDate: 	moment(),
				endDate: 	moment(),
				locale: {
					format: 'DD/MM/YYYY'
				}
			});

			$('#date_range').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
			});
		});

		$(document).on('click', '.export', function (event) {
			$('.errors').text('');
		});
	</script>
@endsection
