<?php

class ErrorController extends Zend_Controller_Action
{

    private $_notifier;
    private $_error;
    private $_environment;

    public function init()
    {
        parent::init();

        $bootstrap = $this->getInvokeArg('bootstrap');

        $environment = $bootstrap->getEnvironment();
        $error = $this->_getParam('error_handler');
        $mailer = new Zend_Mail();
        $session = new Zend_Session_Namespace();
        $cookies = $_COOKIE;

        $this->_notifier = new DV_Service_Notifier_Error(
            $environment,
            $error,
            $mailer,
            $session,
            $cookies,
            $_SERVER
        );

        $this->_error = $error;
        $this->_environment = $environment;
   }

    public function errorAction()
    {
        switch ($this->_error->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->code = "404";
                $this->view->message = 'Uh oh, we can\'t seem to find that page you wanted!';
                $this->_applicationError();
                break;

            default:
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->code = "500";
                $this->view->message = 'Looks like something\'s gone wrong! Please refresh the page - if the problem persists please report the error';
                $this->_applicationError();
                break;
        }

        $this->view->headTitle()->prepend(  $this->view->code . ' Error' );
    }

    private function _applicationError()
    {
        $fullMessage = $this->_notifier->getFullErrorMessage();
		$this->view->stack = nl2br($fullMessage);
        $this->_notifier->notify();
    }


    /*
     *

    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }
     *
     * 
     */

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

