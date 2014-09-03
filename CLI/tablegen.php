<?php

function tablegen($type, $pagenum) {
// Connecting to database

//styling stuff
$and = "&type=".$type;
$prev = $pagenum - 1;
if ($prev < 0) {
$prev = 0;
}
$next = $pagenum + 1;

if ($pagenum == 0) {
$backstyle = "btn-default";
} else {
$backstyle = "btn-primary";
}

$tbody = '';
$connection = mysql_connect("localhost", "chrisluk", "continuum");
$db_name = 'reporting';
mysql_select_db($db_name, $connection);
if ($type == 0) {
	$query = "SELECT * FROM messages ORDER BY type, code asc;";
	$result = mysql_query($query);
} else {
	$query = "SELECT * FROM messages where type=".$type." ORDER BY type, code asc;";
	$result = mysql_query($query);
}
$count = 0;
$startpt = $pagenum * 15;
$endpt = $startpt + 14;

if ($result === false) {
	return (false);
}

// Display table
while ($table = mysql_fetch_row($result)) {
	mysql_data_seek($result, 0);
	if (mysql_num_rows($result)) {
		$inc = 0;
		mysql_data_seek($result, 0);
		while($row = mysql_fetch_row($result)) {
			//if ($inc >= $startpt && $inc <= $endpt) {
				$tbody .= "<tr>\n";
				foreach(array_slice($row,1) as $key=>$value) {
					$tbody .= '<td>'.htmlentities(trim(preg_replace("/\s+/", " ", $value)))."</td>\n";
				}
				$tbody .= "</tr>\n";
			//}
			$inc += 1;
			$count++;
		}
	}
}

$totalpages = ceil($count/15)-1;

if ($pagenum == $totalpages) {
$forstyle = "btn-default";
$next--;
} else {
$forstyle = "btn-primary";
}

$result = '<div style="padding-bottom:3px;" class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> Message Code Table
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th style="width: 75px;">Type</th>
                                                    <th style="width: 75px;">Code</th>
                                                    <th>Text</th>
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