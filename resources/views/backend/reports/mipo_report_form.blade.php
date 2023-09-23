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
                                                <h5 class="pt-2">Mipo Data Report</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <hr class="mb-0"> -->
                                    <div class="card-body">
                                        <form id="generateMipoReportForm" method="post" action="generate_mipo_report">
                                            <h4 class="form-section"><i class="ft-info"></i> Filter Parameter</h4>
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Po Date Range<span class="text-danger">*</span></label>
                                                    <input class="form-control required" type="text" id="daterange"
                                                           name="daterange" readonly><br/>
                                                </div>
                                                @if(in_array($roleId,[1,7]))
                                                <div class="col-md-6">
                                                    <label>Region</label>
                                                    <select class="form-control mb-3 select2" id="region_id"
                                                            name="region_id" style="width: 100% !important;">
                                                        <option value="">All</option>
                                                        @foreach($regions as $region)
                                                            <option value="{{$region->id}}">{{$region->region_name}}</option>
                                                        @endforeach
                                                    </select><br/>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Product</label>
                                                    <select class="form-control mb-3 select2" id="product_id"
                                                            name="product_id" style="width: 100% !important;">
                                                        <option value="">All</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                        @endforeach
                                                    </select><br/><br/>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Mipo Status</label>
                                                    <select class="form-control mb-3 select2" id="mipo_status" name="mipo_status[]" multiple style="width: 100% !important;">
                                                        @foreach($mipoStatus as $status)
                                                            <option value="{{$status->id}}">{{ $status->mipo_status_name }}</option>
                                                        @endforeach
                                                    </select><br/>
                                                </div>
                                                @endif
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
        });

        $(document).on('click', '.export', function (event) {
            $('.errors').text('');

        });

    </script>
@endsection

