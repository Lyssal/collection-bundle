<?php
namespace Lyssal\CollectionBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\CollectionBundle\Entity\Support;

/**
 * Helper de Support.
 * 
 * @author Rémi Leclerc
 */
class SupportDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * Retourne l'URL de l'icône 32px.
     *
     * @return string URL
     */
    public function getIcone32Url()
    {
        return $this->router->getContext()->getBaseUrl().'/'.$this->entity->getIcone32Url();
    }
    
    /**
     * Retourne l'icône 32px en HTML.
     *
     * @return string HTML de l'icône
     */
    public function getIcone32Html()
    {
        return '<img src="'.$this->getIcone32Url().'" alt="'.$this->entity->getNom().'" width="32" height="32">';
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Support);
    }
}
