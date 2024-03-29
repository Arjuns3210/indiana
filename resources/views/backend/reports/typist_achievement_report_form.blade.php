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
												<h5 class="pt-2">Typist Achievement Report</h5>
											</div>
										
										</div>
									</div>
									<!-- <hr class="mb-0"> -->
									<div class="card-body">
										<form id="generateTypistAchievementReportForm" method="post" action="generateTypistAchievementReport">
											<h4 class="form-section"><i class="ft-info"></i> Filter Parameter</h4>
											@csrf
											<div class="row">
												<div class="col-sm-6">
															
													<label>Enquiry Date Range<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" id="daterange" name="daterange" readonly><br/>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<label>Typist<span class="text-danger">*</span></label>
													<select class="select2" id="typist" name="typist" style="width: 100% !important;">
														<option value="all">All</option>
														@foreach($typist as $typ)
															<option value="{{$typ->id}}">{{$typ->nick_name}}</option>
														@endforeach
													</select><br/>
												</div>
												<div class="col-sm-6">
													<label>Typist Status</label>
													<select class="select2" id="typist_status" name="typist_status[]" style="width: 100% !important;" multiple>
														<option value="all">All</option>
														@foreach($typist_status as $typ_status)
															<option value="{{$typ_status->id}}">{{$typ_status->typist_status_name}}</option>
														@endforeach
													</select><br/>
												</div>
												<div class="col-sm-6 mt-3">
													<label>Category</label>
													<select class="select2" id="categories" name="categories[]" style="width: 100% !important;" multiple>
														<option value="all">All</option>
														@foreach($categories as $category)
															<option value="{{$category->id}}">{{$category->category_name}}</option>
														@endforeach
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


// categories
 $("#categories").change(function () {
    var val = $(this).val();
	if(jQuery.inArray("all", val) !== -1){
	console.log(val);
	
        $('#categories option').attr('disabled', 'disabled');
        $('#categories option[value="all"]').removeAttr('disabled');
    }
});

$("#categories").on("select2:unselect", function (e) { 
  var select_val = $(e.currentTarget).val();

	if(jQuery.inArray("all", select_val) === -1){
        $('#categories option').removeAttr('disabled');
    }
});

//typist_status
 $("#typist_status").change(function () {
    var val = $(this).val();
	if(jQuery.inArray("all", val) !== -1){
	console.log(val);
	
        $('#typist_status option').attr('disabled', 'disabled');
        $('#typist_status option[value="all"]').removeAttr('disabled');
    }
});

$("#typist_status").on("select2:unselect", function (e) { 
  var select_val = $(e.currentTarget).val();

	if(jQuery.inArray("all", select_val) === -1){
        $('#typist_status option').removeAttr('disabled');
    }
});

</script>
@endsection

