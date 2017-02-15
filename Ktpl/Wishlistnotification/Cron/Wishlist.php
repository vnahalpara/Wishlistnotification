<?php
namespace Ktpl\Wishlistnotification\Cron;
 
use \Magento\Wishlist\Model\ResourceModel\Wishlist\Collection;

class Wishlist
{
	protected $wishlistProvider;
	protected $logger;
	protected $_helper;
	public function __construct(\Psr\Log\LoggerInterface $logger,Collection $wishlistProvider,\Ktpl\Wishlistnotification\Helper\Data $helper,\Magento\Framework\App\State $appState)
	{
	    $this->logger = $logger;
	    $this->wishlistProvider = $wishlistProvider;
	    $this->_helper = $helper;
	}

    public function execute()
    {
    	$wishlists = $this->wishlistProvider->getData();
    	for ($i=0; $i < count($wishlists); $i++) {
    		$this->_helper->sendMail($wishlists[$i]['wishlist_id'],$wishlists[$i]['customer_id']);
    	}
        return $this;
    }
}