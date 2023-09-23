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
                            <h1 class="content-header">Welcome to Indiana Admin Panel</h1>
                            <hr style="border: none; border-bottom: 1px solid black;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-12">
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
                        <div class="col-xl-3 col-lg-3 col-12">
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
                        <div class="col-xl-3 col-lg-3 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $total_staff }}</h3>
                                                <span>Total Staff</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-briefcase success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{ $total_active_staff }}</h3>
                                                <span>Active Staff</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-shopping-bag success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{ $overallMipoCount }}</h3>
                                                <span>Overall MIPO</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{ $addedTodayMipo }}</h3>
                                                <span>MIPO Added Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-user-plus warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{ $totalMipoRejection }}</h3>
                                                <span>MIPO In Rejection</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-briefcase warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{ $totalMipoComplete }}</h3>
                                                <span>MIPO Completed</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-shopping-bag warning font-large-2 float-right"></i>
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
