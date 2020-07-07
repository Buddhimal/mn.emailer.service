<?php 
class EmailqueueService {

	function __construct(){}

	function Process(){
		try{

			// while(TRUE) 
			// {
				
				$mail_queue = new  communicator_email_queue();
				$queued_emails = $mail_queue->get_new_items_queued();
				
				$email_sent_ids = array();
				$email_failed_ids = array();

				if(is_array($queued_emails) && count($queued_emails) > 0){

					foreach ($queued_emails as $new_email_item) {
					
						//grab the template here and do replace the vars.
						$template_hanlder = new template($new_email_item['template_id'], $new_email_item['email_type_id']);

						$vars = null;
						if(isset($new_email_item['content']) && !empty($new_email_item['content'])){
							$vars = (array)json_decode($new_email_item['content']);
						}

						$template_content = $template_hanlder->get_content();

						$mail_body = null;

						if(!is_null($vars)){
							$mail_body = str_replace(array_keys($vars), array_values($vars), $template_content);
						}else{
							$mail_body = $template_content;
						}

						

						$emailer = new PHPMailer\PHPMailer\PHPMailer();
						$emailer->isHTML(TRUE);
						$emailer->isSMTP();
						$emailer->addAddress($new_email_item['send_to'], $new_email_item['receiver_name']);
						$emailer->setFrom("noreply@mynumber.lk", "Team MyNumber");
						$emailer->Body = $mail_body;
						$emailer->Subject = $vars['##SUBJECT##'];

						try{
							$send_result = $emailer->send();
							if( !is_null( $send_result) && $send_result !== FALSE ) {
								$email_sent_ids[] = $new_email_item['id'];
							}else{
								$email_failed_ids[] = array( 'id' => $new_email_item['id'], 'error' => $emailer->ErrorInfo);
							}
						}catch(Exception $ex) {
							$email_failed_ids[] = array( 'id' => $new_email_item['id'], 'error' => "exception" . $ex->getMessage() );
						}
					}//foreach();

					if(count($email_sent_ids)>0) {
						$mail_queue->update_items_delivered($email_sent_ids);
					}

					if(count($email_failed_ids)>0) {
						$mail_queue->update_items_failed($email_failed_ids);
					}

				}
				else{
					sleep(SLEEP_TIME); // finally sleep for few seconds and continue.
				}

			// }// never ending while loop
		}catch(Exception $ex){
			//
		}

	}//End: Process

}


//https://alexwebdevelop.com/php-daemons/
//https://stackoverflow.com/questions/2036654/run-php-script-as-daemon-process