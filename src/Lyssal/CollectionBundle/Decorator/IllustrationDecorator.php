<?php
namespace Lyssal\CollectionBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\CollectionBundle\Entity\Illustration;

/**
 * Helper de Illustration.
 * 
 * @author Rémi Leclerc
 */
class IllustrationDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Illustration);
    }
    
    
    /**
     * Retourne l'URL de l'illustration.
     *
     * @return string URL
     */
    public function getUrl()
    {
        return $this->router->getContext()->getBaseUrl().'/'.$this->entity->getImagePath();
    }
    
    /**
     * Retourne le HTML de l'illustration.
     *
     * @return string HTML
     */
    public function getHtml()
    {
        return '<img src="'.$this->getUrl().'" alt="'.$this->entity->getTitle().'" width="'.$this->entity->getLargeur().'" height="'.$this->entity->getHauteur().'">';
    }
}
