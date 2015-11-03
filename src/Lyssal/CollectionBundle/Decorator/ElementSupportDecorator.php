<?php
namespace Lyssal\CollectionBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\CollectionBundle\Entity\ElementSupport;

/**
 * Helper de ElementSupport.
 * 
 * @author Rémi Leclerc
 */
class ElementSupportDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof ElementSupport);
    }
}
