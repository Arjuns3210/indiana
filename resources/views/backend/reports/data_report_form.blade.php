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
												<h5 class="pt-2">Enquiry Data Report</h5>
											</div>
										</div>
									</div>
									<!-- <hr class="mb-0"> -->
									<div class="card-body">
										<form id="generateDataReportForm" method="post" action="generateDataReport">
											<h4 class="form-section"><i class="ft-info"></i> Filter Parameter</h4>
											@csrf
											@php
												$extra_fields = in_array($role_id, array(1, 7)) ? true : false;
											@endphp

											@if(!$extra_fields)
												<input type="hidden" name="user_specific" value="true">
											@endif

											<div class="row">
												<div class="col-sm-6">
													<label>Enquiry Date Range<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" id="daterange" name="daterange" readonly><br/>
												</div>
												@if($extra_fields)
												<div class="col-md-6">
													<label>Region</label>
													<select class="form-control mb-3 select2" id="search_region" name="search_region" style="width: 100% !important;">
														<option value="">All</option>
																	@foreach($regions as $region)
																		<option value="{{$region->id}}">{{$region->region_name}}</option>
																	@endforeach
													</select><br/>
											</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<label>Typist Date</label>
													<input class="form-control" type="text" id="typist_date" name="typist_date" readonly><br/>
												</div>
												<div class="col-sm-6">
													<label>Min Amount</label>
													<input class="form-control" type="text" id="amount" name="amount" step=".001" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46"><br/>
												</div>
												<div class="col-sm-6">
													<label>Typist Status</label>
													<select class="select2" id="typist_status" name="typist_status[]" style="width: 100% !important;" multiple>
														<option value="">Select</option>
														@foreach($typist_status as $typ_status)
															<option value="{{$typ_status->id}}">{{$typ_status->typist_status_name}}</option>
														@endforeach
														<option value="blank">Blank</option>
													</select><br/>
												</div>
												<div class="col-sm-6">
													<label>Engineer Status</label>
													<select class="select2" id="engineer_status" name="engineer_status[]" style="width: 100% !important;" multiple>
														<option value="">Select</option>
														@foreach($engineer_status as $eng_stat)
															<option value="{{$eng_stat->id}}">{{$eng_stat->engineer_status_name}}</option>
														@endforeach
														<option value="blank">Blank</option>
													</select><br/>
												</div>
												
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
											@endif
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
  $('#daterange').daterangepicker({
    startDate: 	moment(),
    endDate: 	moment(),
	// minDate:	moment(),
	// maxDate:	moment().add(365, 'days'),
    locale: {
      format: 'DD/MM/YYYY'
    }
  });

  $('#typist_date').daterangepicker({
    singleDatePicker: true,
	autoUpdateInput: false,
    showDropdowns: false,
    minYear: 2000,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });

  $('#typist_date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });

  $('#typist_date').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });


});

$(document).on('click', '.export', function (event) {
	$('.errors').text('');
    
});

</script>
@endsection

