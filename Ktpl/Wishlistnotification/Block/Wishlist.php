<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Wishlistnotification\Block;

use Magento\Framework\View\Element\Template;
use \Magento\Wishlist\Model\ResourceModel\Item\Collection;
use \Magento\Catalog\Model\Product;

/**
 * Main contact form block
 */
class Wishlist extends Template
{
    /**
     * @param Template\Context $context
     * @param array $data
     */
    protected $wishlistItem;
    protected $productCollection;

    public function __construct(Template\Context $context, array $data = [],Collection $items,Product $product)
    {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
        $this->wishlistItem = $items;
        $this->productCollection = $product;
    }

    public function getWishlistItem($wishlist)
    {
    	$product = array();
    	$items = $this->wishlistItem->addFieldToFilter('wishlist_id',$wishlist);
    	$itemsArray = $items->getData();
    	return $itemsArray;
    }

    public function getWishlistProduct($id)
    {
    	return $this->productCollection->load($id);
    }
}
