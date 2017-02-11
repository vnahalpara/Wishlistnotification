<?php
namespace Ktpl\Wishlistnotification\Cron;

class Run extends \Magento\Framework\App\Http implements \Magento\Framework\AppInterface 
{
    public function launch()
    {
        $ob = $this->_objectManager->create('\Ktpl\Wishlistnotification\Cron\Wishlist');
        die;
        return $ob->execute();
    }

    public function catchException(\Magento\Framework\App\Bootstrap $bootstrap, \Exception $exception)
    {
        return false;
    }
}