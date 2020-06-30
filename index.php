<?php
set_time_limit(0);

define('WORKING_DIRECTORY', dirname(__FILE__) );
require_once( WORKING_DIRECTORY . '/config.php' );

$the_processor = new EmailqueueService();
$the_processor->Process();