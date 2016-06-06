<?php

namespace MagentoEse\InStorePickupSampleData\Setup;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\State;
use Magento\Catalog\Model\Product\Attribute\Repository;

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
    private $state;
    private $productAttributeRepository;


    public function __construct(ProductFactory $productFactory, State $state, Repository $productAttributeRepository)
    {
        $this->productFactory = $productFactory;
        $state->setAreaCode('adminhtml');
        $this->ispuData = require 'ISPUData.php';
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $_attribcode='in_store_available';

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