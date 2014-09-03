            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <?php 
					echo tablegen(0,0); 
					?>
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-upload fa-fw"></i> Add New Message
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form action="index.php?page=tools&action=addmessage" method="POST" role="form">
								<div class="form-group">
                                    <label>Major Text:</label>
                                    <input class="form-control" name="major" placeholder="Major Text">
								</div>
								<div class="form-group">
									<label>Minor Text:</label>
                                    <input class="form-control" name="minor" placeholder="Minor Text">
								</div>
								<div class="form-group">
									<label>Message Text:</label>
                                    <input class="form-control" name="message" placeholder="Message Text">
                                </div>
							<button type="submit" class="btn btn-primary btn-lg btn-block">Add Messages</button>
							</form>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

					
					<div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-envelope fa-fw"></i> Email Code Calculator
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form action="index.php?page=tools&action=calculate" method="POST" role="form">
							<div style="float:left;">
                                <div class="form-group">
                                    <label>Send to User Groups:</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="list[]" <?php if ($usr){ echo "checked=TRUE";} ?> value="A">User
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="list[]" <?php if ($ndp){ echo "checked=TRUE";} ?> value="B">NDP
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="list[]" <?php if ($ops){ echo "checked=TRUE";} ?> value="C">Operations
                                        </label>
                                    </div>
									<div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="list[]" <?php if ($fnc){ echo "checked=TRUE";} ?> value="D">Finance
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="list[]" <?php if ($spt){ echo "checked=TRUE";} ?> value="E">Support
                                        </label>
                                    </div>
								</div>
							</div>
							<div style="float:right;">
								<img style="vertical-align:middle;float:right;margin-top:18px;margin-right:75px;" src="http://i.imgur.com/FzfhlHc.png" />
							</div>


							<button type="submit" class="btn btn-primary btn-lg btn-block">Evaluate Message Code</button>
							</form>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
					

                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->