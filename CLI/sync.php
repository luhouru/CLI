<?php
//sync log imports
//attempt to parse plaintext logs
//logs delimited as follows:


$directory = '/synclogs/';
$logs = array_diff(scandir($directory, 1), array('..', '.'));

$options = '';

if (isset($_GET["date"])) {
$syncbase = $_GET["date"];
$syncfile = $directory.$_GET["date"];
} else {
$syncbase = $logs[0];
$syncfile = $directory.$logs[0];
}

foreach($logs as $log) {
$basedlog = substr(basename($log, ".php"), 4);
if ($log == $syncbase) {
$options .= "<option selected=true value=\"$log\">$basedlog</option>";
} else {
$options .= "<option value=\"$log\">$basedlog</option>";
}
}




//$syncfile = "/synclogs/log-2014-06-04.php";//select log file
$lines = file($syncfile);//file in to an array, then shift the PHP and newline out of the array
array_shift($lines);
array_shift($lines);

echo "
            <div class=\"row\">
                <div class=\"col-lg-12\">
                    <!-- /.panel -->
                     <div class=\"panel panel-danger\">
                        <div class=\"panel-heading\">
                            <form action=\"index.php?page=sync\" method=\"GET\"><i class=\"fa fa-warning fa-fw\"></i> Sync Logs from 
							<input type=\"hidden\" name=\"page\" value=\"sync\">
							<select name=\"date\" onchange=\"this.form.submit()\" class=\form-control\">$options</select></form>
                        </div>
                        <!-- /.panel-heading -->
                        <div class=\"panel-body\">
<table class=\"table table-hover\" id=\"dataTables-sync\">
											<thead>
                                                <tr>
													<th>ID</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Severity</th>
													<th>Information</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
$first = TRUE;
											
foreach ($lines as $line_num => $line) {
	//temp[0] is type
    $temp  = explode(" - ", $line);
	
	if (isset($temp[1])) {
	
	//temp2[0] is datetime
	@$temp2 = explode(" --> ", $temp[1]);
	
	//temp3[0] is severity if applicable
	//temp3[1] is message code
	if ($temp[0] == "ERROR") {
	@$temp3[0] = $temp2[1];
	@$temp3[1] = $temp2[2];
	} else {
	@$temp3[0] = "Information";
	@$temp3[1] = $temp2[1];
	}
	if (!$first) {
	echo "</td></tr>";
	$first = FALSE;
	}
	
    echo "<tr><td width=75>{$line_num}</td><td width=100>" . $temp[0] . "</td><td width=100>" . $temp2[0] . "</td><td width=75>" . $temp3[0] . "</td><td style=\"max-height:75px;overflow:auto;\">" . wordwrap($temp3[1], 75,"<br>",TRUE);
	
	} else {
	echo $temp;
	}
}
echo "</tbody></table></div>
                                    </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->";
?>