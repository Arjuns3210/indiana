@extends('backend.layouts.app')
@section('content')
<div class="wrapper">
    <div class="main-panel">
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <section id="minimal-statistics">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="content-header">Welcome to Indiana Panel</h1>
                            <hr style="border: none; border-bottom: 1px solid black;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $total_enquiries }}</h3>
                                                <span>Total Enquiries</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $enquiry_added_today }}</h3>
                                                <span>Enquries Added Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-user-plus success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- Pie Chart starts -->
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Overall Category Status</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="category_status_chart" class="d-flex justify-content-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pie Chart ends -->

                         <!-- Donut Chart starts -->
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Overall Region Status</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="region_chart" class="d-flex justify-content-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Donut Chart ends -->

                        <!-- Donut Chart starts -->
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Overall Engineer Status</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="engineer_status_chart" class="d-flex justify-content-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Donut Chart ends -->

                         <!-- Donut Chart starts -->
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Overall Typist Status</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="typist_status_chart" class="d-flex justify-content-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Donut Chart ends -->
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    categoryStatusForAdmin();
    engineerStatusForAdmin();
    typistStatusForAdmin();
    regionForAdmin();
});
</script>
@endsection
