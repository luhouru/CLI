            <div class="row">
				<div class="col-lg-6">
                    <!-- /.panel -->
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Top Errors Barchart
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <div style="height:650px;" id="morris-file-bar">
							
						   </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-6">
                    <!-- /.panel -->
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-edit fa-fw"></i> Latest Logs (24H)
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <?php echo gen_latest_logs(); ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
				<div class="col-lg-6">
                    <!-- /.panel -->
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-sort-amount-desc fa-fw"></i> Last 10 Messages Added
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <?php echo gen_latest_msg(); ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <!-- /.row -->