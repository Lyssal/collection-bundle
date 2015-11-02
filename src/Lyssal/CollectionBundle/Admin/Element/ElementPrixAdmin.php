<?php
namespace Lyssal\CollectionBundle\Admin\Element;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Classe ElementPrixAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class ElementPrixAdmin extends Admin
{
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('element')
            ->add('pays')
            ->add('monnaie')
            ->add('prix')
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
            ->add('pays')
            ->add('monnaie')
            ->add('prix')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('element')
            ->add('pays')
            ->add('monnaie')
            ->add('prix')
        ;
    }
}
