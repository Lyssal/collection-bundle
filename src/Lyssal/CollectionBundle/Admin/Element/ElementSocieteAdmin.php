<?php
namespace Lyssal\CollectionBundle\Admin\Element;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Classe ElementSocieteAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class ElementSocieteAdmin extends Admin
{
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('element')
            ->add('societe')
            ->add('societeRole')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('societe', 'sonata_type_model_autocomplete', array('property' => 'nom', 'attr' => array('style' => 'width:100%;')), array('btn_add' => true))
            ->add('societeRole')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('element')
            ->add('societe')
            ->add('societeRole')
        ;
    }
}
