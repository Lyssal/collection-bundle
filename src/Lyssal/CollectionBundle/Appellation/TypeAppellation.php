<?php
namespace Lyssal\CollectionBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\CollectionBundle\Entity\Type;
use Lyssal\CollectionBundle\Decorator\TypeDecorator;

class TypeAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::supports()
     */
    public function supports($object)
    {
        return ($object instanceof Type || $object instanceof TypeDecorator);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($type)
    {
        return $type->__toString();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($type)
    {
        return $this->appellation($type);
    }
}
