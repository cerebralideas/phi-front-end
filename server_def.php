<?php

if(defined('SERVER_DEF'))
    return;

define('SERVER_DEF', true);

$environment = "production";

$pathDefinitions = array(
	'production' => array(
		/* point this to the [projectroot]/application/public in your apache config */
		'ZEND_DOMAIN' => 'pas.neehrperfect.com',

		/* on the zend app side of things, do we cache the content layout? */
		'RECACHE_LAYOUT' => true,

		/* use cached users on the ZF side */
		'CACHED_USERS' => true,

		/* do all the switch for the mysql params */
			'MYSQL_SERVER' => 'localhost',
			'MYSQL_USERNAME' => 'neehr',
			'MYSQL_PASSWORD' => 'KE6RjAt9aTZSKVDA',
            'AUTH_MYSQL_SERVER' => 'vista.neehrperfect.com',
			'AUTH_MYSQL_DATABASE' => 'neehr',
			'APP_MYSQL_DATABASE' => 'pas',

		/* setup a cache dir constant */
		'TEMP_DIR' => sys_get_temp_dir()."/pas",

		/* change the upload path per server */
		'UPLOAD_DIR' => '',
	),
	'shad' => array(
		/* point this to the [projectroot]/application/public in your apache config */
		'ZEND_DOMAIN' => 'local.pas.com',
        //'ZEND_DOMAIN' => 'angjs_educationalpas.site/',

		/* on the zend app side of things, do we cache the content layout? */
		'RECACHE_LAYOUT' => true,

		/* use cached users on the ZF side */
		'CACHED_USERS' => true,

		/* do all the switch for the mysql params */
		'MYSQL_SERVER' => 'localhost',
		'MYSQL_USERNAME' => 'neehr',
		'MYSQL_PASSWORD' => 'KE6RjAt9aTZSKVDA',
        'AUTH_MYSQL_SERVER' => 'localhost',
		'AUTH_MYSQL_DATABASE' => 'neehr',
		'APP_MYSQL_DATABASE' => 'pas',

		/* setup a cache dir constant */
		'TEMP_DIR' => sys_get_temp_dir()."/neehr_perfect",

		/* change the upload path per server */
		'UPLOAD_DIR' => sys_get_temp_dir()."/neehr_perfect", /* mirror temp dir */
	),
    'justin' => array(
        /* point this to the [projectroot]/application/public in your apache config */
        'ZEND_DOMAIN' => 'pre-release.educationalpas.site',

        /* on the zend app side of things, do we cache the content layout? */
        'RECACHE_LAYOUT' => true,

        /* use cached users on the ZF side */
        'CACHED_USERS' => true,

        /* do all the switch for the mysql params */
        'MYSQL_SERVER' => 'localhost',
        'MYSQL_USERNAME' => 'neehr',
        'MYSQL_PASSWORD' => 'KE6RjAt9aTZSKVDA',
        'AUTH_MYSQL_SERVER' => 'localhost',
        'AUTH_MYSQL_DATABASE' => 'neehr',
        'APP_MYSQL_DATABASE' => 'pas',

        /* setup a cache dir constant */
        'TEMP_DIR' => sys_get_temp_dir()."/neehr_perfect",

        /* change the upload path per server */
        'UPLOAD_DIR' => sys_get_temp_dir()."/neehr_perfect", /* mirror temp dir */
    ),

);

if (file_exists(dirname(__FILE__)."/environment.php"))
    require dirname(__FILE__)."/environment.php";

if(!isset($pathDefinitions[$environment]))
{
	die('You must set up a pathDefinitions array key in '.__FILE__.' to setup your environment correctly');
}

/* define all the associated vars from the selected environment set */
foreach($pathDefinitions[$environment] as $key => $item)
{
	defined($key)
		or define($key, $item);
}

define('SERVER_DEF_LIBRARY_PATH', dirname(__FILE__));

require SERVER_DEF_LIBRARY_PATH.'/frameworks/Zend/Debug.php';

if(!is_dir(TEMP_DIR))
	mkdir(TEMP_DIR, 0777, true);

//echo '<pre>';
//echo 'TEMP_DIR: ' . TEMP_DIR . PHP_EOL;
//echo 'ZEND_DOMAIN: ' . ZEND_DOMAIN . PHP_EOL;
//echo 'UNKNOWN: ' . substr(ZEND_DOMAIN,strpos(ZEND_DOMAIN,"."),100) . PHP_EOL;
//echo '</pre>';

/* without this temp dir none of the templating or sessions will work.
 * VERY IMPORTANT
 */
if(!is_writable(TEMP_DIR))
	die('Please make sure the temp dir is writeable ['.TEMP_DIR.']');

if(!is_dir(TEMP_DIR."/sessions"))
	mkdir(TEMP_DIR."/sessions", 0777, true);

if(!is_writable(TEMP_DIR."/sessions"))
	die('Please make sure the session dir is writeable ['.TEMP_DIR."/sessions]");

ini_set('session.save_path', TEMP_DIR."/sessions");
