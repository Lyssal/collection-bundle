<?php
namespace Lyssal\CollectionBundle\Admin\Element;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Classe ElementSupportAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class ElementSupportAdmin extends Admin
{
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('element')
            ->add('utilisateur')
            ->add('support')
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
            ->add('element')
            ->add('utilisateur')
            ->add('support')
            ->add('utilisateurSupport')
            ->add('version')
            ->add('commentaire')
            ->add('langues')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('element')
            ->add('utilisateur')
            ->add('support')
            ->add('utilisateurSupport')
            ->add('version')
            ->add('commentaire')
            ->add('langues')
        ;
    }
}
