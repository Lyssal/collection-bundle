<?php
namespace Lyssal\CollectionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Classe TypeAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class TypeAdmin extends Admin
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
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->add('elementNom')
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
        if (!$dossier->exists($this->getSubject()->getIconeUploadDir()))
            $dossier->mkdir($this->getSubject()->getIconeUploadDir());
        if (!$dossier->exists($this->getSubject()->getIcone32UploadDir()))
            $dossier->mkdir($this->getSubject()->getIcone32UploadDir());
        if (!$dossier->exists($this->getSubject()->getIcone16UploadDir()))
            $dossier->mkdir($this->getSubject()->getIcone16UploadDir());
        
        $formMapper
            ->add('nom')
            ->add('couleur')
            ->add('description')
            ->add
            (
                'iconeFile',
                'file',
                array
                (
                	'required' => (null === $this->getSubject()->getId())
                )
            )
            ->add('elementNom')
            ->add('supportLangageTypeDefaut', null, array('required' => false))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom')
            ->add('couleur')
            ->add('description')
            ->add('icone')
            ->add('elementNom')
        ;
    }
}
