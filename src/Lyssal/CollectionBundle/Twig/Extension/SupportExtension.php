<?php
namespace Lyssal\CollectionBundle\Twig\Extension;

use Lyssal\StructureBundle\Decorator\DecoratorManager;
use Lyssal\CollectionBundle\Manager\SupportManager;
use Lyssal\CollectionBundle\Entity\Type;
use Lyssal\CollectionBundle\Decorator\TypeDecorator;

/**
 * Extension Twig pour les supports.
 * 
 * @author Rémi Leclerc
 */
class SupportExtension extends \Twig_Extension
{
    /**
     * @var \Lyssal\StructureBundle\Decorator\DecoratorManager DecoratorManager
     */
    protected $decoratorManager;
    
    /**
     * @var \Lyssal\CollectionBundle\Manager\SupportManager SupportManager
     */
    protected $supportManager;
    
    
    /**
     * Constructeur.
     */
    public function __construct(DecoratorManager $decoratorManager, SupportManager $supportManager)
    {
        $this->decoratorManager = $decoratorManager;
        $this->supportManager = $supportManager;
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
       return array
       (
       	   new \Twig_SimpleFunction('lyssal_collection_supports_by_type_and_utilisateur', array($this, 'getSupportsByTypeAndUser'))
       ); 
    }
    
    
    /**
     * Retourne tous les supports de l'utilisateur connecté pour un type donnée.
     * 
     * @param \Lyssal\CollectionBundle\Entity\Type|\Lyssal\CollectionBundle\Decorator\TypeDecorator Type
     * @return \Lyssal\CollectionBundle\Decorator\SupportDecorator[] Supports
     */
    public function getSupportsByTypeAndUser($type)
    {
        if (!($type instanceof Type) && !($type instanceof TypeDecorator))
            throw new \Exception('Le type passé en paramètre à lyssal_collection_supports_by_type_and_utilisateur doit être de type \Lyssal\CollectionBundle\Entity\Type ou \Lyssal\CollectionBundle\Decorator\TypeDecorator.');
        
        return $this->decoratorManager->get($this->supportManager->findByTypeAndUser($type instanceof Type ? $type : $type->getEntity()));
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
       return 'lyssal_collection_support_extension';
    }
}
