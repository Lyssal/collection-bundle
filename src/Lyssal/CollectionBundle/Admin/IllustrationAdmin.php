<?php
namespace Lyssal\CollectionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Lyssal\CollectionBundle\Entity\Illustration;

/**
 * Classe IllustrationAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class IllustrationAdmin extends Admin
{
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('image')
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
            ->add('imageFile', 'file', array(
            	'required' => (null === $this->getSubject() || false === $this->getSubject()),
                'sonata_help' => (null !== $this->getSubject() && false !== $this->getSubject() ? '<img src="/'.$this->getSubject()->getImageChemin().'">' : '')
            ))
            ->add('position')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('image')
            ->add('largeur')
            ->add('hauteur')
            ->add('position')
        ;
    }
}
