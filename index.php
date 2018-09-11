<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>Mailgun Form</title>
</head>
<body>
<form action="/index.php" method="POST">
	<textarea name="message" style="width: 500px; display: block;" rows="10" required></textarea>
	<button style="display: block; margin-top: 15px;" type="submit">Submit</button>
</form>
</body>
</html>

<?php
require 'vendor/autoload.php';
require 'config.php';

use Mailgun\Mailgun;

$mg = Mailgun::create($config['MAILGUN_KEY']);
if (isset($_POST['message']) && !empty($_POST['message'])) {
	foreach ($receivers as $receiver) {
		try {
			$mg->messages()->send($config['MAILGUN_DOMAIN'], [
				'from' => $config['FROM'],
				'to' => $receiver,
				'subject' => 'Mail Subject',
				'text' => $_POST['message']
			]);
		} catch (\Mailgun\Exception\HttpClientException $e) {
			echo $e->getMessage();
		}
	}

	echo '<br/>Mails sent successfully!';
}