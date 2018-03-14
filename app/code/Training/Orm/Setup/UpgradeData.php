<?php

namespace Training\Orm\Setup;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as CatalogAttribute;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $catalogSetupFactory;
    private $customerSetupFactory;
    
    public function __construct(
                CategorySetupFactory $categorySetupFactory,
                CustomerSetupFactory $customerSetupFactory
            )
    {
        $this->catalogSetupFactory = $categorySetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
    }
    
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $catalogSetup = $this->catalogSetupFactory->create(['setup' => $setup]);
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        
        if (version_compare($context->getVersion(), '0.0.2', '<'))
        {
            $catalogSetup->addAttribute(Product::ENTITY, 'flavor_multiselect2', [
                'label'             => 'Flavor Multiselect 2',
                'type'              => 'varchar',
                'input'             => 'multiselect',
                'visible_on_front'  => 1,
                'required'          => 0,
                'frontend_input' => 'multiselect',
                'backend'           => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'option' => [
                    'values' => [
                        100 => 'Creme',
                        200 => 'Milk',
                        300 => 'Onions',
                        400 => 'Mustard',
                        500 => 'Ketchup',
                        600 => 'Sweet Chutney',
                        700 => 'Sugar',
                        800 => 'Honey',
                        900 => 'Chilly',
                    ]
                ],
                'global' => CatalogAttribute::SCOPE_STORE
            ]);
        }
        
        if (version_compare($context->getVersion(), '0.0.3', '<'))
        {            
        }
        
        if (version_compare($context->getVersion(), '0.0.4', '<')) 
        {
            $catalogSetup->updateAttribute(Product::ENTITY, 'flavor_multiselect2', [
                'frontend_model' => \Training\Orm\Entity\Attribute\Frontend\HtmlList::class,
                'is_html_allowed_on_front' => 1,
                'label'     => 'Flavor Multiselect 2',
                'option' => [
                    'values' => [
                        'Creme',
                        'Milk',
                        'Onions',
                        'Mustard',
                        'Ketchup',
                        'Sweet Chutney',
                        'Sugar',
                        'Honey',
                        'Chilly',
                    ]
                ],
            ]);
        }
        
        if (version_compare($context->getVersion(), '0.0.5', '<'))
        {
            $customerSetup->addAttribute(Customer::ENTITY, 'priority', [
                    'frontend_input' => 'select',
                    'backend_type' => 'int',
                    'is_system' => 0,                
                    'label' => 'Priority',
                    'type' => 'int',
                    'input' => 'select',
                    'source' => \Training\Orm\Entity\Attribute\Source\CustomerPriority::class,
                    'required' => 0,
                    'system' => 0,
                    'position' => 100
                ]);
            $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'priority')
                ->setData('used_in_forms', ['adminhtml_customer'])
                ->save();
        }
    }
}