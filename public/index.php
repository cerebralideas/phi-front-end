<?php
/* get all of our define vars */
require_once dirname(__FILE__)."/static.inc.php";

require_once "Zend/Application.php";

$application = new Zend_Application(
	APPLICATION_ENVIRONMENT,
	APPLICATION_PATH . "/configs/application.ini"
);

ini_set('file_uploads', 1);
ini_set('upload_tmp_dir', APPLICATION_UPLOAD_PATH);
ini_set('upload_max_filesize', '512M');

try {
	$application->bootstrap()
				->run();
}
catch (Exception $exception)
{
	if ($exception->getCode() == '401')
	{
		header('Location: /auth/login/');
		exit(1);
	}
	else
	{

		echo '<html><body><center>'
		. 'An exception occured while dispatching the application.';

		if (defined('APPLICATION_ENVIRONMENT') && APPLICATION_ENVIRONMENT != 'production')
		{
			echo '<br /><br />' . $exception->getCode() . ': ' . $exception->getMessage() . '<br />'
			. '<div align="left">Stack Trace:'
			. '<pre>' . $exception->getTraceAsString() . '</pre></div>';
		}
		echo '</center></body></html>';
		exit(1);
	}
}