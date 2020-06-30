<?php
define(SLEEP_TIME, 60);

$CDN_URL = "https://cdn.mynumber.lk";


require_once( $WORKING_DIRECTORY . '/emailqueueservice.php' );
require_once(  $WORKING_DIRECTORY. '/database/communicator_email_queue.php');

require_once(  $WORKING_DIRECTORY. '/mail/Exception.php');
require_once(  $WORKING_DIRECTORY. '/mail/OAuth.php');
require_once(  $WORKING_DIRECTORY. '/mail/PHPMailer.php');
require_once(  $WORKING_DIRECTORY. '/mail/POP3.php');
require_once(  $WORKING_DIRECTORY. '/mail/SMTP.php');


require_once(  $WORKING_DIRECTORY. '/classes/template.php');