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
												<h5 class="pt-2">Enquiry MIS Report</h5>
											</div>
										
										</div>
									</div>
									<!-- <hr class="mb-0"> -->
									<div class="card-body">
										<form id="generateMISReportForm" method="post" action="generateMISReport">
											<h4 class="form-section"><i class="ft-info"></i> Filter Parameter</h4>
											@csrf
											<div class="row">
												<div class="col-sm-6">
													<label>Enquiry Date</label>
													<input class="form-control" type="text" id="mis_date" name="mis_date" readonly><br/>
												</div>
												
												<div class="col-sm-12">
                                                                <div class='badge bg-light-warning mb-1 mr-2 d-none' id='report_messge'>
                                                                    <strong>NOTE : </strong> For enquiries older than 2 days, the report data might be incorrect.
                                                                </div>
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
  $('#mis_date').daterangepicker({
    singleDatePicker: true,
	autoUpdateInput: false,
    showDropdowns: false,
	maxDate: new Date(),
    minYear: 2000,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });

  $('#mis_date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));

	  misDateVal = new Date(picker.startDate);
	  todaysDate = new Date();
	  var diffDays = parseInt((todaysDate - misDateVal) / (1000 * 60 * 60 * 24), 10); 
	  if(diffDays >= 2){
		$('#report_messge').removeClass('d-none');
	  }else{
		$('#report_messge').addClass('d-none');
	  }
	  console.log(diffDays)
  });

  $('#mis_date').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });


});

$(document).on('click', '.export', function (event) {
	$('.errors').text('');
    
});

</script>
@endsection

