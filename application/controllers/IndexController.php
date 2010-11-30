<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	$auth = Zend_Auth::getInstance();
	var_dump($auth->getIdentity());

        // Title
	$this->view->headTitle()->append('Index');

	// action body
	$core = new models_Core();
	$this->view->statistics = $core->getStatistics();
	
	// News
	$news = new models_News();
	$this->view->headlines = $news->getHeadlines();

        $bootstrap = $this->getInvokeArg('bootstrap');
        $this->view->environment = $bootstrap->getEnvironment();
    }

    /** 
     * Renders a sitemap based on Zend_Navigation setup 
     */  
    public function sitemapAction()  
    {  
        echo $this->view->navigation()->sitemap();  
        $this->view->layout()->disableLayout();  
        $this->_helper->viewRenderer->setNoRender(true);  
    }  

	public function robotsAction()
	{	
		// No layout here
		$this->view->layout()->disableLayout();
		/**
		 * @TODO Add a switch based on development version to do no crawling
		 */
		$this->view->robotstext = "User-agent: *\n\rDisallow: /";
	}
}

