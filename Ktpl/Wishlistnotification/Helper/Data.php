<?php
namespace Ktpl\Wishlistnotification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
	const XML_PATH_EMAIL_RECIPIENT = 'wishlistnotification/email/recipient_email';
    const XML_PATH_EMAIL_SENDER = 'wishlistnotification/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE = 'wishlistnotification/email/email_template';

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
    }

	public function sendMail($withlistId,$customerId)
	{
		$templateVars = array(
		                    'store' => $this->storeManager->getStore(),
		                    'customer_name' => 'Vaibhav Ahalpara',
		                    'message'   => 'Hello World!!.',
		                    'withlistId'		=> $withlistId
	                	);
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		try {
		    $transport = $this->_transportBuilder
		        ->setTemplateIdentifier($this->scopeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE, $storeScope))
		        ->setTemplateOptions(
		            [
		                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
		                'store' => $this->storeManager->getStore()->getId(),
		            ]
		        )
		        ->setTemplateVars($templateVars)
		        ->setFrom($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
		        ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
		        ->setReplyTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
		        ->getTransport();
		    $transport->sendMessage();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}