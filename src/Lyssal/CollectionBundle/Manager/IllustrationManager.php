<?php
namespace Lyssal\CollectionBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;
use Lyssal\CollectionBundle\Entity\Illustration;
use Lyssal\Image;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Manager de l'entité Illustration.
 * 
 * @author Rémi Leclerc
 */
class IllustrationManager extends Manager
{
    /**
     * @var string Root directory
     */
    private $kernelRootDir;
    
    /**
     * Constructeur du manager de base.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager EntityManager
     * @param string                               $class         Classe de l'entité
     * @param string                               $kernelRootDir Root directory
     */
    public function __construct(EntityManagerInterface $entityManager, $class, $kernelRootDir)
    {
        parent::__construct($entityManager, $class);
        
        $this->kernelRootDir = $kernelRootDir;
    }
    
    
    /**
     * Crée une miniature de l'illustration.
     * 
     * @param \Lyssal\CollectionBundle\Entity\Illustration $illustration Illustration originale
     */
    public function createAndSaveMiniature(Illustration $illustration)
    {
        $imageMiniature = $this->createImageMiniature($illustration);

        $illustrationMiniature = $this->create();
        $illustrationMiniature->setDossier($illustration->getDossier());
        $illustrationMiniature->setImage($imageMiniature->getNom());
        $illustrationMiniature->setLargeur($imageMiniature->getLargeur());
        $illustrationMiniature->setHauteur($imageMiniature->getHauteur());
        $illustrationMiniature->setOriginale($illustration);

        $this->save($illustrationMiniature);
    }
    
    /**
     * Enregistre la miniature de l'illustration sur le serveur.
     * 
     * @param \Lyssal\CollectionBundle\Entity\Illustration $illustration Illustration originale
     * @return \Lyssal\Image L'image miniature créée
     */
    protected function createImageMiniature(Illustration $illustration)
    {
        $imageOriginale = new Image($this->kernelRootDir.'/../web/'.$illustration->getImageChemin());

        $imageMiniature = $imageOriginale->copy($this->kernelRootDir.'/../web/'.$illustration->getImageChemin(), false);
        if (null === $imageMiniature)
            throw new \Exception('Impossible d\'enregistrer la miniature.');

        if ($imageMiniature->getLargeur() > $imageMiniature->getHauteur())
            $imageMiniature->redimensionne(Illustration::$MINIATURE_LARGEUR_MAXIMALE, null);
        else $imageMiniature->redimensionne(null, Illustration::$MINIATURE_HAUTEUR_MAXIMALE);

        return $imageMiniature;
    }
}
