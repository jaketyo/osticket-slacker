<?php

require_once(INCLUDE_DIR . 'class.plugin.php');
require_once(INCLUDE_DIR . 'class.signal.php');
require_once(INCLUDE_DIR . 'class.app.php');
require_once('config.php');

class SlackerPlugin extends Plugin {
	var $config_class = "SlackerPluginConfig";

	function bootstrap() {
		Signal::connect('model.created', array($this, 'onTicketCreated'), 'Ticket');
	}

	function onTicketCreated($ticket) {
		global $ost;

		// Get config data
		$slack_url  = $this->getConfig()->get('slack-webhook-url');
		$channel    = $this->getConfig()->get('slack-channel');
		$icon_url   = $this->getConfig()->get('slack-icon-url');
		$username   = $this->getConfig()->get('slack-username');

		// Get new ticket data
		$ticket_id = $ticket->getId();
		$ticket_url = $ost->getConfig()->getUrl() . 'scp/tickets.php?id=' . $ticket_id;
		$ticket_number = $ticket->getNumber();
//		$ticket_subject = $ticket->getSubject();
		$ticket_name = $ticket->getName();
		$ticket_email = $ticket->getEmail();
//		$ticket_topic = $ticket->getTopic()->getName();
//		$ticket_lastMessage = $ticket->getLastMessage();

		// Slack-formatted json payload
		$data = "payload=" . json_encode(array(
			"username"      =>  "{$username}",
			"icon_url"      =>  "{$icon_url}",
			"channel"       =>  "#{$channel}",
			"attachments"   => array(array(
				"fallback"       => "osTicket Message",
				"mrkdwn_in"      => array("fields"),
				"color"          => "danger",
				"fields"         => array(
					array(
						"title" => "#{$ticket_number}",
//						"value" => "_Topic_: *{$ticket_topic}*\n_Subject_: *{$ticket_subject}*",
						"short" => "true"
					),
					array(
						"title" => "Contact Information",
//						"value" => "_name_: `{$ticket_name}`\n_email:_ `{$ticket_email}`\n_ticket_url_: {$ticket_url}",
						"value" => "_ticket_url_: `{$ticket_url}",
						"short" => "true"
					)
				)
			))
		));

		// Prepare and Curl the data
		$ch = curl_init($slack_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT,10);
		$result = curl_exec($ch);
		$curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		curl_close($ch);

		// Catch Curl errors and post them in the log file
		if ($curl_errno > 0) {
			error_log('Slack Curl Error ' . $curl_error);
		}
		else if($result != 'ok') {
			error_log('Curl Error (Check your URL): ' . $result);
		}
	}
}