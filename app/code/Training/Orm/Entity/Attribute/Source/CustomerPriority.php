<?php
namespace Training\Orm\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class CustomerPriority extends AbstractSource
{
    public function getAllOptions()
   {
        $options = array_map(function($priority) {
                return [
                    'label' => sprintf('Priority %d', $priority),
                    'value' => $priority
                ];
            }, range(1, 10));
            
        if ($this->getAttribute()->getFrontendInput() === 'select') {
            array_unshift($options, ['label' => '', 'value' => 0]);
        }
        
        return $options;
   }
}
