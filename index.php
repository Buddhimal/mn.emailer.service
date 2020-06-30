<?php
set_time_limit(0);

$WORKING_DIRECTORY = dirname(__FILE__);

require_once( $WORKING_DIRECTORY . '/config.php' );


EmailqueueService::Process();