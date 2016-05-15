<?php  //oncall.php
//
// NagiosXI On-Call
//

require_once(dirname(__FILE__).'/../../common.inc.php');

// initialization stuff
pre_init();
// start session
init_session();
// grab GET or POST variables
grab_request_vars();
// check prereqs
check_prereqs();
// check authentication
check_authentication(false);
$filename1 = "/tmp/oncalldata-pri.txt";
$filename2 = "/tmp/oncalldata-sec.txt";

$title = "Nagios XI - NagiosXI On-Call";
do_page_start(array("page_title"=>$title),true);

$html = "\n\n<h1>Primary On-Call</h1>";
print $html;

$html = "<table border='1'>\n\n";
$html .= "<tr style=\"font-size:14px; font-weight:bold;\"> <td>Group Description</td><td>Group Alias</td><td>User</td></tr>";
if (file_exists($filename1)) {
$f = fopen($filename1, "r");
while (($line = fgetcsv($f)) !== false) {
        $html .= "<tr>";
        foreach ($line as $cell) {
                $html .= "<td>" . htmlspecialchars($cell) . "</td>";
        }
        $html .= "</tr>\n";
}
fclose($f);
}
$html .= "\n</table>";
print $html;

$html = "\n\n<h1>Secondary On-Call</h1>";
print $html;

$html = "<table border='1'>\n\n";
$html .= "<tr style=\"font-size:14px; font-weight:bold;\"> <td>Group Description</td><td>Group Alias</td><td>User</td></tr>";
if (file_exists($filename2)) {
$f = fopen($filename2, "r");
while (($line = fgetcsv($f)) !== false) {
        $html .= "<tr>";
        foreach ($line as $cell) {
                $html .= "<td>" . htmlspecialchars($cell) . "</td>";
        }
        $html .= "</tr>\n";
}
fclose($f);
}
$html .= "\n</table>";
print $html;

?>
