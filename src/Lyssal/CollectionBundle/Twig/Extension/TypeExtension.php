<?php
namespace Lyssal\CollectionBundle\Twig\Extension;

use Lyssal\StructureBundle\Decorator\DecoratorManager;
use Lyssal\CollectionBundle\Manager\TypeManager;

/**
 * Extension Twig pour les types.
 * 
 * @author Rémi Leclerc
 */
class TypeExtension extends \Twig_Extension
{
    /**
     * @var \Lyssal\StructureBundle\Decorator\DecoratorManager DecoratorManager
     */
    private $decoratorManager;
    
    /**
     * @var \Lyssal\CollectionBundle\Manager\TypeManager TypeManager
     */
    private $typeManager;
    
    
    /**
     * Constructeur.
     */
    public function __construct(DecoratorManager $decoratorManager, TypeManager $typeManager)
    {
        $this->decoratorManager = $decoratorManager;
        $this->typeManager = $typeManager;
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
       return array
       (
       	   new \Twig_SimpleFunction('lyssal_collection_types', array($this, 'getTypes'))
       ); 
    }
    
    
    /**
     * Retourne tous les types.
     * 
     * @return \Lyssal\CollectionBundle\Decorator\TypeDecorator[] Types
     */
    public function getTypes()
    {
        return $this->decoratorManager->get($this->typeManager->findAll());
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
       return 'lyssal_collection_type_extension';
    }
}
