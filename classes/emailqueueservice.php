<?php 
class EmailqueueService {

	function __construct(){}

	function Process(){
		try{

			// while(TRUE) 
			// {
				$queued_emails = communicator_email_queue::get_new_items_queued();
				
				if(is_array($queued_emails) && count($queued_emails) > 0){

					foreach ($queued_emails as $new_email_item) {
					
						//grab the template here and do replace the vars.
						$template_hanlder = new template($new_email_item['template_id'], $new_email_item['email_type_id']);
						$vars = json_decode($new_email_item['content']);

						$template_content = $template_hanlder->get_content();
						$mail_body = str_replace(array_keys($vars), array_values($vars), $template_content);

						$emailer = new PHPMailer();
                        $emailer->isHTML(TRUE);
                        $emailer->isSMTP();
						$emailer->addAddress($new_email_item['send_to'], $new_email_item['receiver_name']);
						$emailer->setFrom("noreply@mynumber.lk", "Team MyNumber");
						$emailer->Body = $mail_body;
						$emailer->Subject = $vars['#subject#'];

						try{
							$emailer->send();
						}catch(Exception $ex){
							// log an error
						}

					}//foreach();

				}
				// else{
				// 	sleep(SLEEP_TIME); // finally sleep for few seconds and continue.
				// }
			// }// never ending while loop
		}catch(Exception $ex){
			//
		}

	}//End: Process

}


//https://alexwebdevelop.com/php-daemons/
//https://stackoverflow.com/questions/2036654/run-php-script-as-daemon-process