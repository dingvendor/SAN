<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initLogger()
    {
        //$bootstrap = $this->getInvokeArg('bootstrap');
        if (!$this->hasPluginResource('Log')) {
            return false;
        }
        
        Zend_Registry::set('logger',$tis->getResource('Log'));
        //return $log;
    }
        
    /**
    * Initial debug if debug mode is set or we're in development mode
    */
    protected function _initDebug()
    {
        $this->bootstrap('config');

        $config = Zend_Registry::get('config');

        if(APPLICATION_ENV == 'development'||isset($config->debug))
        {
            DEFINE('DEBUG', true);
        }
        else
        {

            DEFINE('DEBUG', false);
        }

        //            $logger = new Zend_Log();
        //		$writer = new Zend_Log_Writer_Firebug();
        //		$logger->addWriter($writer);
        //
        //		Zend_Registry::set('logger', $logger);
    }

        protected function _initViewStuff()
	{
		$this->bootstrap('config');
        	$this->bootstrap('view');
	        /* @var $view Zend_View_Abstract */
        	$view = $this->getResource('view');
	        //$view->headTitle()->setSeparator(' :: ');
		$config = Zend_Registry::get('config');
        	$view->headTitle()->prepend($config->sitename);
		$view->headTitle()->setSeparator($config->titleseparator);

		$view->headLink()->appendAlternate($config->domain.'/news/feed', 'application+xml', 'News Feed');
                //$view->analytics = $config->webmaster->analytics;
		unset($config);
	}

	protected function _initStyleSheets()
	{
		$view = $this->getResource('view');
		$view->headLink()->prependStylesheet('/style/sgms.css');
	}

	protected function _initDatabaseRegistry()
    	{
        	$this->bootstrap("db");
        	$db = $this->getResource("db");
        	Zend_Registry::set('db', $db);
        	return $db;
    	}

        protected function _initSanAutoloader()
	{
		$loader = Zend_Loader_Autoloader::getInstance();

		$loader->setFallbackAutoloader(true);
		$loader->suppressNotFoundWarnings(false);
	}


	protected function _initConfig()
    	{
        	$config = new Zend_Config($this->getOptions());
        	Zend_Registry::set('config', $config);
        	//return $config;
    	}

	protected function _initAutoloader()
	{
		$loader = Zend_Loader_Autoloader::getInstance();
				
		$loader->setFallbackAutoloader(true);
		$loader->suppressNotFoundWarnings(false);
	}
	
	protected function _initNavigation()
        {
                $this->bootstrap('layout');
                $layout = $this->getResource('layout');
                $view = $layout->getView();
                $config = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml','nav');

                $navigation = new Zend_Navigation($config);

		// var_dump($navigation);		
		if(Zend_Auth::getInstance()->hasIdentity())
		{
			$navigation->findBy('label','Login / Register')->setVisible(false);
			$navigation->findBy('label','Logout')->setVisible();
			//var_dump($login);
		}
                $view->navigation($navigation);
        }

	protected function _initSession()
	{	
		$this->bootstrap('config');
		$this->bootstrap('db');	
		$config = array( 
			'name'           => 'sessions',      //table name as per Zend_Db_Table 
			'primary'        => array('id','save_path','name'),   //the sessionID given by php 
			'primaryAssignment' => array(
        //you must tell the save handler which columns you
        //are using as the primary key. ORDER IS IMPORTANT
        'sessionId', //first column of the primary key is of the sessionID
        'sessionSavePath', //second column of the primary key is the save path
        'sessionName', //third column of the primary key is the session name
    			),
			'modifiedColumn' => 'modified',     //time the session should expire 
			'dataColumn'     => 'data', //serialized data 
			'lifetimeColumn' => 'lifetime'      //end of life for a specific record 
		); 
		$db = Zend_Registry::get('db');
		// var_dump($db);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		$saveHandler = new Zend_Session_SaveHandler_DbTable($config); 
		
		$seconds = Zend_Registry::get('config')->remembertime;
	
		//cookie persist for 30 days 
		Zend_Session::rememberMe($seconds); 
 
		//make the session persist for 30 days 
		$saveHandler->setLifetime($seconds) 
			    ->setOverrideLifetime(true); 
		//similarly, 
		//$saveHandler->setLifetime($seconds, true); 
		Zend_Session::setSaveHandler($saveHandler); 
		Zend_Session::start();
	}

	protected function _initAuth()
	{
		$this->bootstrap('session');
		$auth = Zend_Auth::getInstance();
	}	

	protected function _initResources()
	{
		$this->bootstrap('session');
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new plugin_Auth());

		$view = $this->getResource('view');		
		
		// Added jQuery from ZendX - 28/05/2010
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
		Zend_Controller_Action_HelperBroker::addHelper(new ZendX_JQuery_Controller_Action_Helper_AutoComplete());
		$view->jQuery()->enable();
		$view->jQuery()->uiEnable()
			->addJavascriptFile('/js/jgrowl/jquery.jgrowl.js')
			->addStylesheet('/js/jgrowl/jquery.jgrowl.css');
			
	}

	protected function _initAcl()
	{
		$acl = new models_Acl();
		// Finally I store whole ACL definition to registry for use
		// in AuthPlugin plugin.
		$registry = Zend_Registry::getInstance();
		$registry->set('acl', $acl);
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole('guest');
	}	
	
	protected function _initRoutes()
	{
		$this->bootstrap('config');
		$config = Zend_Registry::get('config');
		//$router = new Zend_Controller_Router_Rewrite();
		//$router->addConfig($config, 'routes');

		$front     = Zend_Controller_Front::getInstance();
		$front->getRouter()->addConfig($config, 'routes');
	}

        #initializses the ZFDebug if DEBUG is ON
	protected function _initZFDebug()
	{

            $this->bootstrap('debug');
            $this->bootstrap('databaseregistry');

            if (!DEBUG)
            {
                    return FALSE;
            }

	    $options = array(
	        'plugins' => array('Variables',
	    					   'ZFDebug_Controller_Plugin_Debug_Plugin_Debug' => array('tab'   => 'Debug',
	    					   													       'panel' => ''),
	    					   'ZFDebug_Controller_Plugin_Debug_Plugin_Auth',
							   'Database',
	                           'Registry',
	                           'Exception')
	    );

	    # Setup the cache plugin
	    if (Zend_Registry::isRegistered('cache'))
	    {
	        $cache = Zend_Registry::get('cache');
	        $options['plugins']['Cache']['backend'] = $cache->getBackend();
	    }

	    # Setup the databases
//	    $resource = $this->getPluginResource('multidb');
//	    $databases = Zend_Registry::get('config')->resources->multidb;
            $database = Zend_Registry::get('db');
//	    foreach ($databases as $name => $adapter)
//	    {
//	    	$db_adapter = $resource->getDb($db->name);
	    	$options['plugins']['Database']['adapter']['sgms']= $database;
//	    }


	    # Init the ZF Debug Plugin
	    $debug = new ZFDebug_Controller_Plugin_Debug($options);
	    $this->bootstrap('frontController');
	    $frontController = $this->getResource('frontController');
	    $frontController->registerPlugin($debug);
            //$frontController->registerPlugin(new DV_Controller_Plugin_Debug());
	}

        protected function _initFrontControllerPlugins()
        {
            $this->bootstrap('zfdebug');
            $this->bootstrap('frontController') ;
            $front = $this->getResource('frontController') ;
            $front->registerPlugin(new DV_Controller_Plugin_Redirector());
            $front->registerPlugin(new DV_Controller_Plugin_Debug());
        }

}

