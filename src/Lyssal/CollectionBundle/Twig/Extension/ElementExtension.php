<?php
namespace Lyssal\CollectionBundle\Twig\Extension;

use Lyssal\StructureBundle\Decorator\DecoratorManager;
use Lyssal\CollectionBundle\Manager\ElementManager;
use Lyssal\CollectionBundle\Entity\ElementGroupe;
use Lyssal\CollectionBundle\Decorator\ElementGroupeDecorator;

/**
 * Extension Twig pour les elements.
 * 
 * @author Rémi Leclerc
 */
class ElementExtension extends \Twig_Extension
{
    /**
     * @var \Lyssal\StructureBundle\Decorator\DecoratorManager DecoratorManager
     */
    protected $decoratorManager;
    
    /**
     * @var \Lyssal\CollectionBundle\Manager\ElementManager ElementManager
     */
    protected $elementManager;
    
    
    /**
     * Constructeur.
     */
    public function __construct(DecoratorManager $decoratorManager, ElementManager $elementManager)
    {
        $this->decoratorManager = $decoratorManager;
        $this->elementManager = $elementManager;
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFilters()
     */
    public function getFilters()
    {
        return array
        (
            'lyssal_collection_elements' => new \Twig_Filter_Method($this, 'getElements')
        );
    }
    
    
    /**
     * Retourne les elements.
     * Le premier paramètre du filtre (optionnel) est le nombre d'éléments à récupérer.
     * 
     * @param $object \Lyssal\CollectionBundle\Entity\ElementGroupe|\Lyssal\CollectionBundle\Decorator\ElementGroupeDecorator Entité
     * @return \Lyssal\CollectionBundle\Decorator\ElementDecorator[] Elements
     */
    public function getElements($object, $nombreElements = null)
    {
        if (!is_object($object))
            throw new \Exception('Le filtre Twig lyssal_collection_elements() attend un objet.');

        if (!is_int($nombreElements))
            throw new \Exception('Le premier paramètre du filtre Twig lyssal_collection_elements() doit être un entier.');

        if ($object instanceof ElementGroupe || $object instanceof ElementGroupeDecorator)
        {
            return $this->decoratorManager->get
            (
                $this->elementManager->findBy
                (
                    array('groupe' => ($object instanceof ElementGroupeDecorator ? $object->getEntity() : $object)),
                    array('slug' => 'ASC'),
                    $nombreElements
                )
            );
        }
        
        throw new \Exception(get_class($object).' n\'est pas compatible avec lyssal_collection_elements().');
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
       return 'lyssal_collection_element_extension';
    }
}
