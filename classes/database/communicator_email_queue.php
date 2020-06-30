<?php 

class communicator_email_queue {

	function get_new_items_queued(){

		try {

			/* Connect to database (with PDO) */
			$db = new PDO('mysql:host=sirikatha.com;dbname=sirikath_mynumber', 'sirikath_mynum', 'S^wxk!l+QZg4');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			/* We suppose the "errors" table contains the errors we look for */
			$sql = sprint_f("SELECT id,sender_name,sender_email,email_type_id,send_to,template_id,content,delivery_status,delivered, error,is_deleted,is_active,updated,created,updated_by,created_by FROM communicator_email_queue WHERE delivery_status = %d", EmailStatus::Pending);

			$st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$st->execute();
			return $st->fetch(PDO::FETCH_ASSOC);
	    }
	    catch (PDOException $e)
	    {
			/* Exception (SQL error) */
			echo $e->getMessage();
			die();
	    }
	}

}

class EmailStatus {
	const Pending =0;
	const Sent = 1;
	const Error = 2;
}