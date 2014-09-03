<?php

function genchecklist() {
// Connecting to database
$tbody = '';
$connect = mysqli_connect("localhost", "logchecks", "logger", "logchecks");
$query = "SELECT * from (SELECT * FROM logchecks) AS T1 ORDER BY uid DESC";
$result = mysqli_query($connect, $query);

if ($result === false) {
	return (false);
}

// Display table
while ($table = mysqli_fetch_row($result)) {
	mysqli_data_seek($result, 0);
	if (mysqli_num_rows($result)) {
		mysqli_data_seek($result, 0);
		while($row = mysqli_fetch_row($result)) {
				$tbody .= "<tr>\n";
				foreach(array_slice($row,1) as $key=>$value) {
					$tbody .= '<td>'.htmlentities(trim(preg_replace("/\s+/", " ", $value)))."</td>\n";
				}
				$tbody .= "</tr>\n";
		}
	}
}


$result = '<div style="padding-bottom:3px;" class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Time & Date</th>
                                                    <th>AWS Describe Images Status</th>
                                                    <th>AWS Describe Images Comment</th>
													<th>AWS Describe Subnets Status</th>
													<th>AWS Describe Subnets Comment</th>
													<th>Get/Save Billings Status</th>
													<th>Get/Save Billings Comment</th>
													<th>Cron Test MSP Status</th>
													<th>Cron Test MSP Comment</th>
													<th>User</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            '.$tbody.'
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-12 (nested) -->
                                <div class="col-lg-12">
                                    <div id="morris-bar-chart"></div>
                                </div>
                                <!-- /.col-lg-12 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
					';

return $result;
}

?>