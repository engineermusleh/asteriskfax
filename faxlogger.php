#!/usr/bin/php -f
<?php
// faxlogger will write argv[1] to the fax logfile
// $Id$
if($argc > 1) {
        $dt = date('c');
        error_log ($dt . " " . $argv[1] . "\n" , 3, "/var/www/html/Musleh.WebFax-qaq3ZMvoQR/logs");
        //error_log ($dt . " " . $argv[1] . "\n" ); //write to /var/log/apache2/error.log
}

?>
