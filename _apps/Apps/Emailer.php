<?php

namespace Apps;

class Emailer
{

	public $toEmail = NULL;
	public $toName = NULL;

	public $fromEmail = "notix@ebsgfinance.net";
	public $fromName = "EBSG.Finance";
	public $replyEmail = "notix@ebsgfinance.net";
	public $replyName = "EBSG.Finance";
	public $subject = "Notification";

	private $variables = array();

	var $recipients = array();
	var $EmailTemplate;
	var $EmailContents;

	public function __construct($to = false)
	{
		if ($to !== false) {
			if (is_array($to)) {
				foreach ($to as $_to) {
					$this->recipients[$_to] = $_to;
				}
			} else {
				$this->recipients[$to] = $to;
			}
		}
	}

	public function __set($key, $val)
	{
		$this->variables[$key] = $val;
	}

	function SetTemplate(EmailTemplate $EmailTemplate)
	{
		$this->EmailTemplate = $EmailTemplate;
	}

	function send()
	{
		$html = $this->EmailTemplate->compile();
		try {
			$PHPmailer = new PHPMailer(true);
			$PHPmailer->AddAddress($this->toEmail, $this->toName);
			$PHPmailer->setFrom($this->fromEmail, $this->fromName);
			$PHPmailer->AddReplyTo($this->replyEmail, $this->replyName);
			$PHPmailer->Subject = $this->subject;

			/*
			$PHPmailer->Sender = "notix@ebsgfinance.net";
			$PHPmailer->DKIM_domain = 'ebsgfinance.net';
			$PHPmailer->DKIM_private = "https://ebsgfinance.net/_dkim/private.key";
			$PHPmailer->DKIM_selector = 'default._domainkey';
			$PHPmailer->DKIM_passphrase = '';
			$PHPmailer->DKIM_identity = $PHPmailer->From;
			$PHPmailer->addCustomHeader("BIMI-Selector:v=BIMI1;s=default;");
			*/

			$PHPmailer->isHTML(true);
			$PHPmailer->MsgHTML($html);
			$PHPmailer->Encoding = "base64";

			$sent = $PHPmailer->Send();
			return $sent;
		} catch (\Exception $e) {
			$PHPmailer->ClearAllRecipients();
			return $sent;
		}
	}
}
