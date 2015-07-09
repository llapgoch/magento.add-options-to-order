<?php
class Llapgoch_AdditionalOptions_Model_Observer{
	
	// Magento already automatically outputs additional_options, add our options to it here!
	public function addAdditionalOptionsToProduct($observer){
		$action = Mage::app()->getFrontController()->getAction();
		// TODO: Hook this up with user settable options
		// TODO: Maybe take the options out of the buy request?
		
		$optionsToSave = array('test_option');
		
		if($action->getFullActionName() !== 'checkout_cart_add'){
			return;
		}
		
		$product = $observer->getProduct();
		
	    $additionalOptions = array();
       	if ($additionalOption = $product->getCustomOption('additional_options')){
           $additionalOptions = (array) unserialize($additionalOption->getValue());
        }
		
		foreach($optionsToSave as $key){
			if(!($value = $action->getRequest()->getParam($key))){
				continue;
			}
			
			$additionalOptions[] = array(
				'label' => $key,
				'value' => $value
			);
		}
		// additional_options gets its own row in sales_flat_quote_item_option
		$product->addCustomOption('additional_options', serialize($additionalOptions));
	}
	
	// Copy attributes to the order item
	public function addAdditonalOptionsToOrder($observer){
		$orderItem = $observer->getOrderItem();
		$quoteItem = $observer->getItem();
		
		if(!$additional = $quoteItem->getOptionByCode('additional_options')){
			return;
		}
		
		if($additional){
			$options = $orderItem->getProductOptions();
			$options['additional_options'] = unserialize($additional->getValue());
			$orderItem->setProductOptions($options);
		}
	}
	
}