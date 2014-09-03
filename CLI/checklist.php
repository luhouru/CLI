            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-upload fa-fw"></i> Add Daily Check
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form action="index.php?page=cron&action=post" method="POST" role="form">
								<div class="form-group">
                                    <label>AWS Describe Images:</label>
									<select name="aws_describe_images_status" class="form-control">
									<option>Not Checked</option>
									<option>Successful</option>
									<option>Failed</option>
									<option>Other</option>
									</select>
                                    <input class="form-control" name="aws_describe_images_text" placeholder="Optional comment...">
								</div>
								<div class="form-group">
									<label>AWS Describe Subnets:</label>
									<select name="aws_describe_subnets_status" class="form-control">
									<option>Not Checked</option>
									<option>Successful</option>
									<option>Failed</option>
									<option>Other</option>
									</select>
                                    <input class="form-control" name="aws_describe_subnets_text" placeholder="Optional comment...">
								</div>
								<div class="form-group">
									<label>Get/Save Billings:</label>
									<select name="get_save_billings_status" class="form-control">
									<option>Not Checked</option>
									<option>Successful</option>
									<option>Failed</option>
									<option>Other</option>
									</select>  
                                    <input class="form-control" name="get_save_billings_text" placeholder="Optional comment...">
                                </div>
								<div class="form-group">
									<label>Cron Test MSP:</label>
									<select name="cron_test_msp_status" class="form-control">
									<option>Not Checked</option>
									<option>Successful</option>
									<option>Failed</option>
									<option>Other</option>
									</select>
                                    <input class="form-control" name="cron_test_msp_text" placeholder="Optional comment...">
                                </div>
							<button type="submit" class="btn btn-primary btn-lg btn-block">Add Messages</button>
							</form>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
					

                </div>
                <!-- /.col-lg-4 -->
				
				<div class="col-lg-8">
                     <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-warning fa-fw"></i> Cron Logs & Reports
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#report-pills" data-toggle="tab">Recent Reports</a>
                                </li>
                                <li><a href="#data-pills" data-toggle="tab">AWS Describe Images Log</a>
                                </li>
                                <li><a href="#php-pills" data-toggle="tab">AWS Describe Subnets Log</a>
                                </li>
                                <li><a href="#lost-pills" data-toggle="tab">Get/Save Billings Log</a>
                                </li>
                                <li><a href="#lost-pills" data-toggle="tab">Cron Test MSP Log</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
							<div class="tab-content" style="margin-top: 15px">
								<div class="tab-pane fade in active" id="report-pills">
									<?php 
									echo genchecklist(); 
									?>
								</div>
                                <div class="tab-pane fade" id="data-pills">
									<?php //echo recentgen("data");?>
                                </div>
                                <div class="tab-pane fade" id="php-pills">
            						<?php //echo recentgen("php");?>
                                </div>
                                <div class="tab-pane fade" id="lost-pills">
          							<?php //echo recentgen("lost");?>
                                </div>
							</div>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
				
            </div>
            <!-- /.row -->