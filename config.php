<?php

require_once INCLUDE_DIR . 'class.plugin.php';

class SlackerPluginConfig extends PluginConfig {
	function getOptions() {
		return array(
			'slack' => new SectionBreakField(array(
				'label' => 'Slack notifier',
			)),
			'slack-channel' => new TextboxField(array(
				'label' => 'Slack Channel',
				'configuration' => array('size'=>20, 'length'=>100),
			)),
			'slack-username' => new TextboxField(array(
				'label' => 'Slack Username',
				'default' => 'osTicket',
				'configuration' => array('size'=>20, 'length'=>100),
			),
			'slack-icon-url' => new TextboxField(array(
				'label' => 'Slack icon-URL',
				'configuration' => array('size'=>100, 'length'=>200),
			)),
			'slack-webhook-url' => new TextboxField(array(
				'label' => 'Webhook URL',
				'configuration' => array('size'=>100, 'length'=>200),
			)),
		);
	}
}
