<?php
namespace Lyssal\CollectionBundle\Twig\Extension;

use Lyssal\StructureBundle\Decorator\DecoratorManager;
use Lyssal\CollectionBundle\Manager\PlateformeManager;

/**
 * Extension Twig pour les plateformes.
 * 
 * @author Rémi Leclerc
 */
class PlateformeExtension extends \Twig_Extension
{
    /**
     * @var \Lyssal\StructureBundle\Decorator\DecoratorManager DecoratorManager
     */
    protected $decoratorManager;
    
    /**
     * @var \Lyssal\CollectionBundle\Manager\PlateformeManager PlateformeManager
     */
    protected $plateformeManager;
    
    
    /**
     * Constructeur.
     */
    public function __construct(DecoratorManager $decoratorManager, PlateformeManager $plateformeManager)
    {
        $this->decoratorManager = $decoratorManager;
        $this->plateformeManager = $plateformeManager;
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
       return array
       (
       	   new \Twig_SimpleFunction('lyssal_collection_plateformes', array($this, 'getPlateformes'))
       ); 
    }
    
    
    /**
     * Retourne tous les plateformes.
     * 
     * @return \Lyssal\CollectionBundle\Decorator\PlateformeDecorator[] Plateformes
     */
    public function getPlateformes()
    {
        return $this->decoratorManager->get($this->plateformeManager->findAll());
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
       return 'lyssal_collection_plateforme_extension';
    }
}
