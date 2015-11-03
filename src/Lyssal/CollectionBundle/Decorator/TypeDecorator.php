<?php
namespace Lyssal\CollectionBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\CollectionBundle\Entity\Type;
use Lyssal\Couleur;

/**
 * Helper de Type.
 * 
 * @author Rémi Leclerc
 */
class TypeDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Type);
    }

    /**
     * Retourne l'URL de l'icône 16px.
     * 
     * @return string URL
     */
    public function getIcone16Url()
    {
        return $this->router->getContext()->getBaseUrl().'/'.$this->entity->getIcone16Url();
    }
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
     * Retourne l'URL de l'icône 128px.
     * 
     * @return string URL
     */
    public function getIcone128Url()
    {
        return $this->router->getContext()->getBaseUrl().'/'.$this->entity->getIcone128Url();
    }

    /**
     * Retourne l'icône 16px en HTML.
     *
     * @return string HTML de l'icône
     */
    public function getIcone16Html()
    {
        return '<img src="'.$this->getIcone16Url().'" alt="'.$this->entity->getNom().'" width="16" height="16">';
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
     * Retourne l'icône 128px en HTML.
     * 
     * @return string HTML de l'icône
     */
    public function getIcone128Html()
    {
        return '<img src="'.$this->getIcone128Url().'" alt="'.$this->entity->getNom().'" width="128" height="128">';
    }


    /**
     * Retourne la couleur du type plus claire en hexadécimal.
     * 
     * @return string Couleur
     */
    public function getLightenCouleur($pourcentageEclaircissement)
    {
        $typeCouleur = new Couleur($this->entity->getCouleur());
        return $typeCouleur->lighten($pourcentageEclaircissement)->getCouleurHexadecimal();
    }
    /**
     * Retourne la couleur du type plus foncée en hexadécimal.
     * 
     * @return string Couleur
     */
    public function getDarkenCouleur($pourcentageObscurcissement)
    {
        $typeCouleur = new Couleur($this->entity->getCouleur());
        return $typeCouleur->darken($pourcentageObscurcissement)->getCouleurHexadecimal();
    }

    /**
     * Retourne un panel de couleur pour le type.
     * 
     * @return string[] Couleurs
     */
    public function getPanelCouleurs()
    {
        $couleurs = array();
        
        $couleur = new Couleur($this->getCouleur());
        for ($i = 1; $i < 6; $i++)
        {
            $couleur->lighten(15);
            $couleurs[] = $couleur->getCouleurHexadecimal();
        }
        $couleurs = array_reverse($couleurs, false);
        
        $couleurs[] = '#'.$this->getCouleur();
        
        $couleur = new Couleur($this->getCouleur());
        for ($i = 1; $i < 6; $i++)
        {
            $couleur->darken(15);
            $couleurs[] = $couleur->getCouleurHexadecimal();
        }
        
        return $couleurs;
    }
}
