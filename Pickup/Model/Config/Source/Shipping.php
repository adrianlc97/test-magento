<?php
/**
 * Location
 *
 */

namespace Flat\Pickup\Model\Config\Source;


use Magento\Framework\Data\OptionSourceInterface;

class Shipping implements OptionSourceInterface
{

    protected $scopeConfig; 
    protected $shipconfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\Config $shipconfig
    ){
        $this->shipconfig = $shipconfig;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $shippings = $this->shipconfig->getActiveCarriers();
        $methods = array();
        foreach($shippings as $shippingCode => $shippingModel)
        {
            if($carrierMethods = $shippingModel->getAllowedMethods())
            {
                foreach ($carrierMethods as $methodCode => $method)
                {
                 $code = $shippingCode.'_'.$methodCode;
       	         $carrierTitle = $this->scopeConfig->getValue('carriers/'. $shippingCode.'/title');
                 $methods[] = array('value'=>$code,'label'=>$carrierTitle);
          	    }
            }
        }
        return $methods;

    }
}
