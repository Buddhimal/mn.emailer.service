<?php 

class communicator_email_queue {

	function get_new_items_queued(){

		try {

			/* Connect to database (with PDO) */
			$db = new PDO('mysql:host=sirikatha.com;dbname=sirikath_mynumber', 'sirikath_mynum', 'S^wxk!l+QZg4');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			/* We suppose the "errors" table contains the errors we look for */
			$sql = sprintf("SELECT id,sender_name,sender_email,email_type_id,receiver_name,send_to,template_id,content,delivery_status,delivered, error,is_deleted,is_active,updated,created,updated_by,created_by FROM communicator_email_queue WHERE delivery_status = %d", EmailStatus::Pending);

			$st = $db->prepare($sql);
			$st->execute();
			$resultset = $st->fetchAll(PDO::FETCH_ASSOC);
			$st->closeCursor();
			$st=null;
			$db=null;

			return $resultset;
	    }
	    catch (PDOException $e)
	    {
			/* Exception (SQL error) */
			echo $e->getMessage();
			die();
	    }
	}

	function update_items_delivered($delivered_emails = array()){
		if(isset($delivered_emails) && count($delivered_emails) > 0){
			/* Connect to database (with PDO) */
			$db = new PDO('mysql:host=sirikatha.com;dbname=sirikath_mynumber', 'sirikath_mynum', 'S^wxk!l+QZg4');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$now = date("y-m-d H:i:s");
			/* We suppose the "errors" table contains the errors we look for */
			$sql = sprintf("UPDATE communicator_email_queue set delivery_status = %d, updated= '%s', delivered='%s'  WHERE id in ('%s')", EmailStatus::Sent, $now, $now, implode("','", $delivered_emails));

			$st = $db->prepare($sql);
			$st->execute();
			$resultset = $st->fetchAll(PDO::FETCH_ASSOC);
			$st=null;
			$db=null;

			return $resultset;

		}else{
			throw new Exception("delivered_emails is empty", 101);
		}
	}

	function update_items_failed($items) {

		if( is_array($items) && count($items) >0 ) {

			$db = new PDO('mysql:host=sirikatha.com;dbname=sirikath_mynumber', 'sirikath_mynum', 'S^wxk!l+QZg4');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$now = date("y-m-d H:i:s");

			foreach($items as $email_result) {

				$sql = sprintf("UPDATE communicator_email_queue set delivery_status = %d, updated= '%s', error = '%d'  WHERE id = '%s'", EmailStatus::Error, $now, $email_result['error'], $email_result['id']);

				$st = $db->prepare($sql)->execute();
				$st = null;
			} // end foreach
		}// end if
		else{
			throw new Exception("items not provided or is empty");
		}

		$db=null;
	}
}

class EmailStatus {
	const Pending =0;
	const Sent = 1;
	const Error = 2;
}