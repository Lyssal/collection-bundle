<?php
namespace Lyssal\CollectionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Classe SocieteAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class SocieteAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_by' => 'nom'
    );
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom')
            ->add('parent')
            ->add('pays')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->add('parent')
            ->add('pays')
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
        $dossier = new Filesystem();
        if (!$dossier->exists($this->getSubject()->getImageUploadDir()))
            $dossier->mkdir($this->getSubject()->getImageUploadDir());
        
        $formMapper
            ->add('nom')
            ->add('parent')
            ->add('pays')
            ->add
            (
                'imageFile',
                'file',
                array
                (
                	'required' => false
                )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom')
            ->add('parent')
            ->add('pays')
            ->add('image')
        ;
    }
}
