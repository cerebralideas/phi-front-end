<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap  
{ 
	protected function _initAutoload()
	{
        $options = array(
            'ZendX_Loader_StandardAutoloader' => array(
                'prefixes' => array(
                    'Model' => realpath(APPLICATION_PATH.'/models'),
                    'Service' => realpath(APPLICATION_PATH.'/services'),
                    'Zend' => realpath(APPLICATION_FRAMEWORK_PATH.'/Zend'),
                    'ZendX' => realpath(APPLICATION_FRAMEWORK_PATH.'/ZendX'),
                	'NeehrPerfect' => realpath(dirname(__FILE__).'/../library/NeehrPerfect'),
                	'Othernet' => realpath(dirname(__FILE__).'/../library/Othernet'),
                ),
                'fallback_autoloader' => false,
            )
        );

        ZendX_Loader_AutoloaderFactory::factory($options);
        //print '<XMP>';print_r(ZendX_Loader_AutoloaderFactory::getRegisteredAutoloaders());exit;
        /* caches all of the plugin loads to a file so to speed things up in execution
            the first run is slow, all other subsequent runs are fast */
        /*
        $classFileIncCache = APPLICATION_TEMP_PATH.'/pluginLoaderCache.php';
        if (file_exists($classFileIncCache))
            include_once $classFileIncCache;

        Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);
        */
	}
	
	protected function _initGeneralSetup()
	{
		// FRONT CONTROLLER
		$frontController = Zend_Controller_Front::getInstance();
		
		// CONTROLLER DIRECTORY SETUP
		$frontController->setControllerDirectory(APPLICATION_PATH . '/controllers');

		// APPLICATION ENVIRONMENT
		$frontController->setParam('env', APPLICATION_ENVIRONMENT);
		$frontController->registerPlugin(new NeehrPerfect_Controller_Plugin_Acl());
		//$frontController->registerPlugin(new NeehrPerfect_Controller_Plugin_ViewSetup());
		
		// LAYOUT SETUP
		Zend_Layout::startMvc(APPLICATION_PATH . '/layouts/scripts');
		
		// VIEW SETUP
		$view = Zend_Layout::getMvcInstance()->getView();
		
		// Add Global View Helpers
		$view->addHelperPath(APPLICATION_PATH . '/views/helpers');
		
		
		// CONFIGURATION
		$configuration = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENVIRONMENT);

        // TIMEZONE SETUP
        ini_set('date.timezone', $configuration->get('date_default_timezone'));

		/* configure this here because we do switching in a unified server_def.php file, not the app.ini file */
		$database = new Zend_Config(
			array(
				'adapter' => 'MYSQLI',
				'params' => array(
					'host' => MYSQL_SERVER,
					'username' => MYSQL_USERNAME,
					'password' => MYSQL_PASSWORD,
					'dbname' => APP_MYSQL_DATABASE,
					'adapterNamespace' => 'Othernet_Model_System',
				)
			)
		);

        $authDatabase = new Zend_Config(
            array(
                'adapter' => 'MYSQLI',
                'params' => array(
                    'host' => AUTH_MYSQL_SERVER,
                    'username' => MYSQL_USERNAME,
                    'password' => MYSQL_PASSWORD,
                    'dbname' => AUTH_MYSQL_DATABASE,
                    'adapterNamespace' => 'Othernet_Model_System',
                )
            )
        );

		// DATABASE ADAPTER
		$dbAdapter = Zend_Db::factory($database);
		//$dbAdapter->getConnection()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		// DATABASE TABLE SETUP
		Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);

        $authdbAdapter = Zend_Db::factory($authDatabase);
		
		// REGISTRY
		$registry = Zend_Registry::getInstance();
		$registry->configuration = $configuration;
		$registry->dbAdapter     = $dbAdapter;
        $registry->authdbAdapter   = $authdbAdapter;


		
		// ROUTE SETUP
		//$router = $frontController->getRouter();
		
		//$frontController->setRouter($router);
		
		//print "<XMP>";print_r($router);exit;
		
		// CLEANUP
		unset($frontController, $view, $configuration, $dbAdapter, $registry);
	}
}