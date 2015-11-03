<?php
namespace Lyssal\CollectionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Classe SupportAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class SupportAdmin extends Admin
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
            ->add('types')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->add('types')
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
        
        $formMapper
            ->add('nom')
            ->add('types')
            ->add
            (
                'iconeFile',
                'file',
                array
                (
                	'required' => (null === $this->getSubject()->getId())
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
            ->add('types')
            ->add('icone')
        ;
    }
}
