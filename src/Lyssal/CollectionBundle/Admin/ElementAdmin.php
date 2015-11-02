<?php
namespace Lyssal\CollectionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Classe ElementAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class ElementAdmin extends Admin
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
            ->add('type')
            ->add('groupe')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->add('type')
            ->add('groupe')
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
        $this->mkdir();
        
        $formMapper
            ->add('nom')
            ->add('type')
        ;

        if (null !== $this->getSubject() && false !== $this->getSubject() && null !== $this->getSubject()->getId())
        {
            $formMapper
                ->add('groupe')
                ->add('description')
                ->add('contenu')
                ->add('illustrationRecto', 'sonata_type_admin', array('btn_add' => false))
                ->add('illustrationVerso', 'sonata_type_admin', array('btn_add' => false))
                ->add('genres', null, array('choices' => $this->getConfigurationPool()->getContainer()->get('lyssal.collection.manager.genre')->FindBy(array('type' => $this->getSubject()->getType()), array('nom' => 'ASC'))))
                ->add('parents', 'sonata_type_model_autocomplete', array('property' => 'nom', 'attr' => array('style' => 'width:100%;'), 'multiple' => true), array('multiple' => true))
                ->add('univers')
                ->add('origines')
                ->add('elementDates', 'sonata_type_collection')
                ->add('elementPrix', 'sonata_type_collection')
                ->add
                (
                    'elementSocietes',
                    'sonata_type_collection',
                    array(),
                    array
                    (
                        'edit' => 'inline'
                    )
                )
                ->add
                (
                    'elementPersonnes',
                    'sonata_type_collection',
                    array(),
                    array
                    (
                        'edit' => 'inline'
                    )
                )
                ->add
                (
                    'illustrations',
                    'sonata_type_collection',
                    array('by_reference' => false),
                    array
                    (
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position'
                    )
                )
                ->add('elementSupports', 'sonata_type_collection')
            ;
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom')
            ->add('type')
            ->add('groupe')
            ->add('description')
            ->add('contenu')
            ->add('illustrationRecto')
            ->add('illustrationVerso')
            ->add('genres')
            ->add('parents')
            ->add('univers')
            ->add('origines')
            ->add('elementDates')
            ->add('elementPrix')
            ->add('elementSocietes')
            ->add('illustrations')
            ->add('elementSupports')
        ;
    }
    
    /**
     * Crée les dossiers des images.
     */
    public function mkdir()
    {
        $sousSousDossier =array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','_');
    
        $dossier = new Filesystem();
        $illustration = $this->getConfigurationPool()->getContainer()->get('lyssal.collection.manager.illustration')->create();
        $imageUploadDir = 'img'.DIRECTORY_SEPARATOR.'lyssal_collection'.DIRECTORY_SEPARATOR;
        
        foreach ($sousSousDossier as $caractere)
        {
            if (!$dossier->exists($imageUploadDir.'rectos'.DIRECTORY_SEPARATOR.$caractere))
                $dossier->mkdir($imageUploadDir.'rectos'.DIRECTORY_SEPARATOR.$caractere);
            if (!$dossier->exists($imageUploadDir.'versos'.DIRECTORY_SEPARATOR.$caractere))
                $dossier->mkdir($imageUploadDir.'versos'.DIRECTORY_SEPARATOR.$caractere);
            if (!$dossier->exists($imageUploadDir.'illustrations'.DIRECTORY_SEPARATOR.$caractere))
                $dossier->mkdir($imageUploadDir.'illustrations'.DIRECTORY_SEPARATOR.$caractere);
        }
    }
}
