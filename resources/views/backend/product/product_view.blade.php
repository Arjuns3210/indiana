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
                                            <td><strong>Product Name</strong></td>
                                            <td>{{$data->product_name}}</td>
                                        </tr>
                                       
                                        <tr>
                                            <td><strong>Product Code</strong></td>
                                            <td>{{$data->product_code}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email Id</strong></td>
                                            <td>{{$data->email_id}}</td>
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