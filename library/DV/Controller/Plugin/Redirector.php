<?php
/**
 * Description of Redirector
 *
 * @author Dan
 */
class DV_Controller_Plugin_Redirector
    extends Zend_Controller_Plugin_Abstract
{
    /**
	 * Helper method to redirect to a specific action or controller
	 *
	 * @param string $controller
         * @param string $action
         * @param string $module
         * @param array $params
         * @param string $route
         * @param bool $reset
         * @return <type>
         */
        public function redirect($controller = 'index', $action = 'index', $module = 'default', $params = array(), $route = null, $reset = true )
        {
            $this->_redirect = $this->_helper->getHelper('Redirector');

            $current_controller = $this->_getParam('controller');
            $current_action     = $this->_getParam('action');
            $current_module     = $this->_getParam('module');

            if (strstr($controller, 'http'))
            {
                    if (DEBUG && (!$this->_request->isXmlHttpRequest() && !isset($_GET['ajax'])))
                    {
                                    debug_redirect($controller);
                    }
                    else
                    {
                            return $this->_redirect($controller, array('code' => 301));
                    }
            }

            if (DEBUG && (!$this->_request->isXmlHttpRequest() && !isset($_GET['ajax'])))
            {
                    $url = 'http://' . $_SERVER['HTTP_HOST']
                               . $this->view->url(array_merge(array('controller' => $controller, 'action' => $action, 'module' => $module), $params), $route, $reset);
                    debug_redirect($url);
            }
            else
            {
                    if ($route !== null)
                    {
                            $params = array_merge(array('action'     => $action,
                                                                                'controller' => $controller,
                                                            'module'     => null), $params);

                            return $this->_redirect->setCode(301)
                                                   ->gotoRoute($params, $route, $reset);
                    }

                    return $this->_redirect->setCode(301)
                                               ->gotoSimple($action,
                                                    $controller,
                                                    $module,
                                                    $params);
            }
        }
}
?>
