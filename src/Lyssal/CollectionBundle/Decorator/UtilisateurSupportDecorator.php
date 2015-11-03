<?php
namespace Lyssal\CollectionBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\CollectionBundle\Entity\UtilisateurSupport;

/**
 * Helper de UtilisateurSupport.
 * 
 * @author Rémi Leclerc
 */
class UtilisateurSupportDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof UtilisateurSupport);
    }
}
