<?php
define('SLEEP_TIME', 60);
define('CDN_URL', "https://cdn.mynumber.lk");


require_once( WORKING_DIRECTORY . '/classes/emailqueueservice.php' );
require_once( WORKING_DIRECTORY. '/classes/database/communicator_email_queue.php');

require_once( WORKING_DIRECTORY. '/classes/mail/Exception.php');
require_once( WORKING_DIRECTORY. '/classes/mail/OAuth.php');
require_once( WORKING_DIRECTORY. '/classes/mail/PHPMailer.php');
require_once( WORKING_DIRECTORY. '/classes/mail/POP3.php');
require_once( WORKING_DIRECTORY. '/classes/mail/SMTP.php');


require_once( WORKING_DIRECTORY. '/classes/template.php');