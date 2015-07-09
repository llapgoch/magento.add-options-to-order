<?php
// So, we extend this helper just to translate the labels of our custom options, which Magento doesn't do
// by default. It gets them from the getCustomOptions()
class Llapgoch_AdditionalOptions_Helper_Product_Configuration extends Mage_Catalog_Helper_Product_Configuration{
	
	// despite the silly interface name, it's actually a Mage_Sales_Quote_Item that's passed in here
	// We do this here because doing any kind of translations on the quote item gets saved back to the
	// database - so we keep this purely presentational.
	public function getCustomOptions(Mage_Catalog_Model_Product_Configuration_Item_Interface $item){
		$options = parent::getCustomOptions($item);
		
		foreach($options as &$option) {
			$option['label'] = $this->__($option['label']);
			$option['value'] = $this->__($option['value']);
		}
		
		return $options;
	}
}