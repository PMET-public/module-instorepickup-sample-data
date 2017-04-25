<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\InStorePickupSampleData\Setup;

use Magento\Framework\Setup;


class Installer implements Setup\SampleData\InstallerInterface
{

   protected $productUpdate;


    public function __construct(
        \MagentoEse\InStorePickupSampleData\Model\ProductUpdate $productUpdate

    ) {
        $this->productUpdate = $productUpdate;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        $this->productUpdate->install(['MagentoEse_InStorePickupSampleData::fixtures/ISPUData.csv']);
    }
}