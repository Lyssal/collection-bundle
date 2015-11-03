<?php
namespace Lyssal\CollectionBundle\Admin\Element;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Classe ElementPersonneAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class ElementPersonneAdmin extends Admin
{
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('element')
            ->add('personne')
            ->add('personneRole')
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
            ->add('personne', 'sonata_type_model_autocomplete', array('property' => array('nom', 'prenom'), 'attr' => array('style' => 'width:100%;')), array('btn_add' => true))
            ->add('personneRole')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('element')
            ->add('personne')
            ->add('personneRole')
        ;
    }
}
