<?php
namespace Lyssal\CollectionBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\CollectionBundle\Entity\Element;

/**
 * Helper de Element.
 * 
 * @author Rémi Leclerc
 */
class ElementDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Element);
    }
    
    
    /**
     * Retourne l'URL de l'image recto.
     * 
     * @throws \Exception Si l'image recto n'existe pas
     * @return string URL
     */
    public function getIllustrationRectoUrl()
    {
        if (null === $this->entity->getIllustrationRecto())
            throw new \Exception('L\'illustration recto n\'existe pas.');
        
        return $this->entity->getIllustrationRecto()->getUrl();
    }
    /**
     * Retourne l'URL de l'image verso.
     * 
     * @throws \Exception Si l'image verso n'existe pas
     * @return string URL
     */
    public function getIllustrationVersoUrl()
    {
        if (null === $this->entity->getIllustrationVerso())
            throw new \Exception('L\'illustration verso n\'existe pas.');

        return $this->entity->getIllustrationVerso()->getUrl();
    }
    
    /**
     * Retourne le HTML de l'image recto.
     * 
     * @throws \Exception Si l'image recto n'existe pas
     * @return string HTML
     */
    public function getIllustrationRectoHtml()
    {
        if (null === $this->entity->getIllustrationRecto())
            throw new \Exception('L\'illustration recto n\'existe pas.');
        
        return $this->entity->getIllustrationVerso()->getHtml();
    }
    /**
     * Retourne le HTML de l'image verso.
     * 
     * @throws \Exception Si l'image verso n'existe pas
     * @return string HTML
     */
    public function getIllustrationVersoHtml()
    {
        if (null === $this->entity->getIllustrationVerso())
            throw new \Exception('L\'illustration verso n\'existe pas.');
        
        return $this->entity->getIllustrationRecto()->getHtml();
    }
}
