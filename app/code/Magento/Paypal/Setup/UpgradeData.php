<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Paypal\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Paypal\Model\Config;
use Magento\Vault\Api\Data\PaymentTokenInterface;
use Magento\Vault\Model\CreditCardTokenFactory;
use Magento\Vault\Setup\InstallSchema as VaultInstallSchema;

/**
 * Class UpgradeData
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @inheritdoc
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.1', '<')) {
            $connection = $setup->getConnection();
            $connection->update($setup->getTable(VaultInstallSchema::PAYMENT_TOKEN_TABLE), [
                PaymentTokenInterface::TYPE => CreditCardTokenFactory::TOKEN_TYPE_CREDIT_CARD
            ], ['payment_method_code = ?' => Config::METHOD_PAYFLOWPRO]);
        }
        $setup->endSetup();
    }
}
