<?php
/**
 * Mail Transport
 */
namespace Ktpl\Gmailsmtp\Model;
 
class Transport extends \Zend_Mail_Transport_Smtp implements \Magento\Framework\Mail\TransportInterface
{
    /**
     * @var \Magento\Framework\Mail\MessageInterface
     */
    protected $_message;
 
    /**
     * @param MessageInterface $message
     * @param null $parameters
     * @throws \InvalidArgumentException
     */
    public function __construct(\Magento\Framework\Mail\MessageInterface $message,\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        if (!$message instanceof \Zend_Mail) {
            throw new \InvalidArgumentException('The message should be an instance of \Zend_Mail');
        }
        $email = $scopeConfig->getValue('gmailsmtp/smtp/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $password = $scopeConfig->getValue('gmailsmtp/smtp/password', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $smtpHost= 'smtp.gmail.com';//your smtp host  ';
        $smtpConf = [
            'auth' => 'login',//auth type
            'ssl' => 'ssl', 
            'port' => '465',
            'username' => $email, //smtm user name
            'password' => $password //smtppassword 
        ];
 
        parent::__construct($smtpHost, $smtpConf);
        $this->_message = $message;
    }
 
    /**
     * Send a mail using this transport
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendMessage()
    {
        try {
            parent::send($this->_message);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            throw new \Magento\Framework\Exception\MailException(new \Magento\Framework\Phrase($e->getMessage()), $e);
        }
    }
}