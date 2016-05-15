**Description and Instructions:**
Send alert(s) to on-call person.
For use with NagiosXI and NagiosXI users ONLY!  Will not work with contacts.

**Contact Information:** banditbbs@gmail.com

**Version:** 1.2

**CHANGES:**

 1.2 - 02/06/2014 - BUG FIX if following my setup so on-call people don't get double notifications once escalated to entire group
 
 1.1 - 12/20/2013 - ADDED check in the component if the files exist.  This stops apache from generating tons of logs.

 1.0 - 12/17/2013 - First public release`

**Pre-reqs:**
 yum install perl-DBD-Pg

**Todo:**
 1. Add setup page to component to allow setting file name and location
 2. Add calendar to component to allow creation of the files(including daily auto exports)
