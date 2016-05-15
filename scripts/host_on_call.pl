#!/usr/bin/perl
#
# License to use per the terms of the GNU Public License (GPL)
#
# Description and Instructions:
# Send alert(s) to on-call person
# Please read README-ONCALL.txt
#
# Contact Information:
# banditbbs@gmail.com
#
# Version:
# 1.0
#
# CHANGES:
#
# 1.0 - First public release
#
#########################################################################
# Open file and find on call person username
#########################################################################
my $alertnum = 3; #set this to the alert number that starts alerting entire team


#########################################################################
# No Variables past this point
#########################################################################
@alert = split("-", $ARGV[0]);
if ( $alert[1] eq "primary" ) { $file1 = "/tmp/oncalldata-pri.txt" } else { $file1 = "/tmp/oncalldata-sec.txt" };
open (INFILE, $file1) or die $1;
while (<INFILE>) {
        chomp;
        ($group, $alias, $id) = split(",");
        if (($alias ne '') && ($group ne '') && ($id ne '')) {
        	if ($alias eq $alert[0]) {
			$user = $id;
		}
	}
        }
close (INFILE);
#########################################################################
# Connect to postgres database (Edit as needed)
#########################################################################
use DBI;
my $db_host = 'localhost';
my $db_user = 'nagiosxi';
my $db_pass = 'n@gweb';
my $db_name = 'nagiosxi';
my $db = "dbi:Pg:dbname=${db_name};host=${db_host}";
$dbh = DBI->connect($db, $db_user, $db_pass,{ RaiseError => 1, AutoCommit => 0 }) || die "Error connecting to the database: $DBI::errstr\n";
# Query the database and get user's email address
my $query = "SELECT email FROM xi_users where username=\'$user\'";
$ref = $dbh->selectcol_arrayref($query);
#########################################################################
# Execute notification
#########################################################################
if ($ARGV[21] < $alertnum) {
	system("/usr/bin/php /usr/local/nagiosxi/scripts/handle_nagioscore_notification.php --notification-type=host --contact=\"$user\" --contactemail=\"@$ref\" --type=$ARGV[1] --escalated=\"$ARGV[2]\" --author=\"$ARGV[3]\" --comments=\"$ARGV[4]\" --host=\"$ARGV[5]\" --hostaddress=\"$ARGV[6]\" --hostalias=\"$ARGV[7]\" --hostdisplayname=\"$ARGV[8]\" --hoststate=$ARGV[9] --hoststateid=$ARGV[10] --lasthoststate=$ARGV[11] --lasthoststateid=$ARGV[12] --hoststatetype=$ARGV[13] --currentattempt=$ARGV[14] --maxattempts=$ARGV[15] --hosteventid=$ARGV[16] --hostproblemid=$ARGV[17] --hostoutput=\"$ARGV[18]\" --longhostoutput=\"$ARGV[19]\" --datetime=\"$ARGV[20]\"");
	}
#########################################################################
# exit script
#########################################################################
exit
