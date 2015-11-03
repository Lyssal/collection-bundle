<?php
namespace Lyssal\CollectionBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\CollectionBundle\Entity\Personne;

/**
 * Helper de Personne.
 * 
 * @author Rémi Leclerc
 */
class PersonneDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Personne);
    }
    
    
    /**
     * Retourne l'URL de l'image.
     *
     * @return string URL
     */
    public function getImageUrl()
    {
        return $this->router->getContext()->getBaseUrl().'/'.$this->entity->getImageChemin();
    }
    
    /**
     * Retourne le HTML de l'image.
     *
     * @return string HTML
     */
    public function getImageHtml()
    {
        return '<img src="'.$this->getImageUrl().'" alt="'.$this->entity->__toString().'">';
    }
}
