<?php
namespace Lyssal\CollectionBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\CollectionBundle\Entity\ElementPrix;
use Lyssal\CollectionBundle\Decorator\ElementPrixDecorator;

class ElementPrixAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::supports()
     */
    public function supports($object)
    {
        return ($object instanceof ElementPrix || $object instanceof ElementPrixDecorator);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($elementPrix)
    {
        return $elementPrix->__toString();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($elementPrix)
    {
        return $this->appellation($elementPrix);
    }
}
