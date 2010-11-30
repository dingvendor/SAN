<?php

/**
 * A mailer class that uses Zend_View to render the HTML portion of the message.
 *
 * @author Dan
 */
class DV_HtmlMailer
    extends Zend_Mail
{
    /**
     * Static variable - from name;
     * @var string
     */
    static $fromName;

    /**
     * Static variable - from email;
     * @var string
     */
    static $fromEmail;

    /**
     *
     * @var Zend_View
     */
    static $_defaultView;

    /**
     * current instance of our Zend_View
     * @var Zend_View
     */
    protected $_view;

    protected static function getDefaultView()
    {
        if(self::$_defaultView === null)
        {
            self::$_defaultView = new Zend_View();
            self::$_defaultView->setScriptPath(APPLICATION_PATH .
                    '/views/scripts/templates/email');
        }
        return self::$_defaultView;
    }

    public function sendHtmlTemplate($template, $encoding = Zend_Mime::ENCODING_QUOTEDPRINTABLE)
    {
        $html = $this->_view->render($template);
        $this->setBodyHtml($html,$this->getCharset(), $encoding);
        $this->send();
    }

    public function setViewParam($property, $value)
    {
        $this->_view->__set($property, $value);
        return $this;
    }

    public function __construct($charset = 'iso-8859-1')
    {
        parent::__construct($charset);
        $config = Zend_Registry::get('config');
        self::$fromEmail = $config->mailfrom;
        self::$fromName = $config->mailfromwho;
        $this->setFrom(self::$fromEmail, self::$fromName);
        $this->_view = self::getDefaultView();
    }
}
?>
