<?php
namespace Lyssal\CollectionBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\CollectionBundle\Entity\Support;
use Lyssal\CollectionBundle\Decorator\SupportDecorator;

class SupportAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::supports()
     */
    public function supports($object)
    {
        return ($object instanceof Support || $object instanceof SupportDecorator);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($support)
    {
        return $support->__toString();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($support)
    {
        return $this->appellation($support);
    }
}
