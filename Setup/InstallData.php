<?php

namespace MagentoEse\InStorePickupSampleData\Setup;

use \Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * ispuData
     *
     * @var array
     */
    private $ispuData;

    /**
     * Directory of Zipcodes
     *
     * @var array
     */

    private $productFactory;


    public function __construct(ProductFactory $productFactory)
    {
        $this->productFactory = $productFactory;
        $this->ispuData = require 'ISPUData.php';
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $_attribcode='in_store_pickup';
        $_product = $this->productFactory->create();
        foreach ($this->ispuData as $_pickupData) {
            //get product
            $_product->load($_product->getIdBySku($_pickupData[0]));

            //get attribute based on text value
            $_attr = $_product->getResource()->getAttribute( $_attribcode);
            $_optionId = $_attr->getSource()->getOptionId($_pickupData[1]);
            //Set data and save product
            $_product->setData($_attribcode,$_optionId );
            $_product->getResource()->saveAttribute($_product,$_attribcode);
        }
    }
}
