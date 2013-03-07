<?php
error_reporting(E_ALL ^ E_NOTICE);

require dirname(__FILE__)."/../server_def.php";

defined('APPLICATION_PATH')
	or define('APPLICATION_PATH' , realpath(dirname(__FILE__) . '/../application/'));

/* if we ever want to store anything in temp, use this constant */
defined('APPLICATION_TEMP_PATH')
	or define('APPLICATION_TEMP_PATH' , realpath(sys_get_temp_dir())."/neehrperfect/");

if(!is_dir(APPLICATION_TEMP_PATH))
    mkdir(APPLICATION_TEMP_PATH, 0777, true);

/* all uploads that are not attachments get put into this temp file before being put in their final resting place */
defined('APPLICATION_UPLOAD_PATH')
	or define('APPLICATION_UPLOAD_PATH', APPLICATION_TEMP_PATH.'upload/');

defined('APPLICATION_FRAMEWORK_PATH')
    or define('APPLICATION_FRAMEWORK_PATH', realpath(APPLICATION_PATH . '/../frameworks'));

/* this is the current env we are running in
 * development / testing / production */
defined('APPLICATION_ENVIRONMENT')
	or define('APPLICATION_ENVIRONMENT', $environment);

// Include Path
set_include_path(
	APPLICATION_PATH . '/../library'
	. PATH_SEPARATOR . APPLICATION_PATH . '/models'
	. PATH_SEPARATOR . APPLICATION_PATH . '/../frameworks'
    . PATH_SEPARATOR . get_include_path()
);

defined('ROOT_DIR')
	or define('ROOT_DIR', APPLICATION_PATH);