<?php
namespace Training\Orm\Entity\Attribute\Frontend;

class HtmlList extends \Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend
{
    /**
    * @param \Magento\Framework\Object $object
    * @return string
    */
    public function getValue(\Magento\Framework\Object $object)
    {
        if ($this->getConfigField('input') !== 'multiselect')
        {
            return parent::getValue($object);
        }
        return $this->getValuesAsHtmlList($object);
    }
    
    /**
    * @param \Magento\Framework\Object $object
    * @return string
    */
    private function getValuesAsHtmlList(\Magento\Framework\Object $object)
    {
        $options = $this->getOptions($object);
        $escapedOptions = array_map('htmlspecialchars', $options);
        return sprintf(
            '<ul><li>%s</li></ul>',
            implode('</li><li>', $escapedOptions)
        );
    }
    
    /**
    * @param \Magento\Framework\Object $object
    * @return string[]
    */
    private function getOptions(\Magento\Framework\Object $object)
    {
        $optionId = $object->getData($this->getAttribute()->getAttributeCode());
        $option = $this->getOption($optionId);
        return $this->isSingleValue($option) ? [$option] : $option;
    }
    
    /**
    * @param string[]|string $option
    * @return bool
    */
    private function isSingleValue($option)
    {
        return !is_array($option);
    }
}
