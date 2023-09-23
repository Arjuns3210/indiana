<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div>
                    <div class="card-content">
                    	<div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        
                                        <tr>
                                            <td><strong>Engineer Name</strong></td>
                                            <td>{{$data->admin->admin_name}}/{{$data->admin->nick_name}}</td>
                                        </tr>
                                          
                                        <tr>
                                            <td><strong>Remark Activity</strong></td>
                                            <td>{{$data->activity_remarks}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Remark Date</strong></td>
                                            <td>{{$data->remark_date}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date Time</strong></td>
                                            <td>{{date('d-m-Y H:i A', strtotime($data->updated_at)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>