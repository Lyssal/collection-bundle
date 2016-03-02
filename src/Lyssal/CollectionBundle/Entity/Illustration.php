<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Lyssal\StructureBundle\Traits\ImageTrait;
use Lyssal\Fichier;
use Lyssal\Image;
use Lyssal\Chaine;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Illustration.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Illustration
{
    use ImageTrait;
    
    
    /**
     * @var integer Largeur maximale de l'image originale (en pixels)
     */
    public static $ORIGINALE_LARGEUR_MAXIMALE = 800;
    
    /**
     * @var integer Hauteur maximale de l'image originale (en pixels)
     */
    public static $ORIGINALE_HAUTEUR_MAXIMALE = 800;
    
    /**
     * @var integer Largeur maximale de l'image miniature (en pixels)
     */
    public static $MINIATURE_LARGEUR_MAXIMALE = 400;
    
    /**
     * @var integer Hauteur maximale de l'image miniature (en pixels)
     */
    public static $MINIATURE_HAUTEUR_MAXIMALE = 400;
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="illustration_id", type="bigint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="illustration_image", type="string", nullable=false, length=128)
     */
    protected $image;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File
     */
    protected $imageFile;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="illustration_dossier", type="string", nullable=false, length=128)
     */
    protected $dossier;
    
    /**
     * @var string
     *
     * @ORM\Column(name="illustration_largeur", type="smallint", nullable=false)
     * @Assert\NotNull()
     */
    protected $largeur;
    
    /**
     * @var string
     *
     * @ORM\Column(name="illustration_hauteur", type="smallint", nullable=false)
     * @Assert\NotNull()
     */
    protected $hauteur;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Illustration
     * 
     * @ORM\OneToOne(targetEntity="Illustration", inversedBy="originale", cascade={"persist"})
     * @ORM\JoinColumn(name="miniature_id", referencedColumnName="illustration_id", nullable=true, onDelete="CASCADE")
     */
    protected $miniature;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Illustration
     * 
     * @ORM\OneToOne(targetEntity="Illustration", mappedBy="miniature")
     */
    protected $originale;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     * 
     * @ORM\OneToOne(targetEntity="Element", mappedBy="illustrationRecto")
     */
    protected $rectoElement;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     * 
     * @ORM\OneToOne(targetEntity="Element", mappedBy="illustrationVerso")
     */
    protected $versoElement;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="illustrations")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=true)
     * @Gedmo\SortableGroup()
     */
    protected $element;
    
    /**
     * @ORM\Column(name="illustration_position", type="integer", nullable=true)
     * @Gedmo\SortablePosition()
     */
    protected $position;
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Illustration
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }
    
    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set dossier
     *
     * @param string $dossier
     * @return Illustration
     */
    public function setDossier($dossier)
    {
        $this->dossier = $dossier;
    
        return $this;
    }
    
    /**
     * Get dossier
     *
     * @return string
     */
    public function getDossier()
    {
        return $this->dossier;
    }
    
    /**
     * Set largeur
     *
     * @param integer $largeur
     * @return Illustration
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;

        return $this;
    }

    /**
     * Get largeur
     *
     * @return integer 
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * Set hauteur
     *
     * @param integer $hauteur
     * @return Illustration
     */
    public function setHauteur($hauteur)
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    /**
     * Get hauteur
     *
     * @return integer 
     */
    public function getHauteur()
    {
        return $this->hauteur;
    }

    /**
     * Set miniature
     *
     * @param \Lyssal\CollectionBundle\Entity\Illustration $miniature
     * @return Illustration
     */
    public function setMiniature(\Lyssal\CollectionBundle\Entity\Illustration $miniature = null)
    {
        $this->miniature = $miniature;

        return $this;
    }

    /**
     * Get miniature
     *
     * @return \Lyssal\CollectionBundle\Entity\Illustration 
     */
    public function getMiniature()
    {
        return $this->miniature;
    }

    /**
     * Set originale
     *
     * @param \Lyssal\CollectionBundle\Entity\Illustration $originale
     * @return Illustration
     */
    public function setOriginale(\Lyssal\CollectionBundle\Entity\Illustration $originale = null)
    {
        $this->originale = $originale;
        
        if (null !== $originale && null === $originale->getMiniature())
            $originale->setMiniature($this);

        return $this;
    }

    /**
     * Get originale
     *
     * @return \Lyssal\CollectionBundle\Entity\Illustration 
     */
    public function getOriginale()
    {
        return $this->originale;
    }

    /**
     * Set rectoElement
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $rectoElement
     * @return Illustration
     */
    public function setRectoElement(\Lyssal\CollectionBundle\Entity\Element $rectoElement = null)
    {
        $this->rectoElement = $rectoElement;

        return $this;
    }

    /**
     * Get rectoElement
     *
     * @return \Lyssal\CollectionBundle\Entity\Element 
     */
    public function getRectoElement()
    {
        return $this->rectoElement;
    }

    /**
     * Set versoElement
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $versoElement
     * @return Illustration
     */
    public function setVersoElement(\Lyssal\CollectionBundle\Entity\Element $versoElement = null)
    {
        $this->versoElement = $versoElement;

        return $this;
    }

    /**
     * Get versoElement
     *
     * @return \Lyssal\CollectionBundle\Entity\Element 
     */
    public function getVersoElement()
    {
        return $this->versoElement;
    }

    /**
     * Set element
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $element
     * @return Illustration
     */
    public function setElement(\Lyssal\CollectionBundle\Entity\Element $element = null)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get element
     *
     * @return \Lyssal\CollectionBundle\Entity\Element 
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Illustration
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    
    /**
     * Retourne le répertoire dans lequel est enregistrée l'image.
     *
     * @return string Chemin de l'image
     */
    public function getImagePath()
    {
        return $this->getImageUploadDir().DIRECTORY_SEPARATOR.$this->image;
    }
    
    /**
     * Retourne le répertoire dans lequel est enregistrée l'image.
     * 
     * @return string Dossier de l'image
     */
    public function getImageUploadDir()
    {
        return 'img'.DIRECTORY_SEPARATOR.'lyssal_collection'.DIRECTORY_SEPARATOR.$this->dossier;
    }
    
    /**
     * Retourne le sous-dossier dans lequel devra être enregistré l'image.
     * 
     * @return string Sous-dossier
     */
    public function guessSousDossier()
    {
        if (null !== $this->rectoElement)
            $sousDossier = 'rectos';
        elseif (null !== $this->versoElement)
            $sousDossier = 'versos';
        else
        {
            $sousDossier = 'illustrations';
        }

        return $sousDossier.'/'.$this->guessSousSousDossier();
    }
    
    /**
     * Retourne le sous-sous-dossier dans lequel devra être enregistré l'image.
     * 
     * @return string Sous-sous-dossier
     */
    public function guessSousSousDossier()
    {
        $titre = new Chaine($this->getTitle());
        $titre->minifie('', true);
        if (strlen($titre->getTexte()) > 0)
        {
            $premiereLettre = substr($titre->getTexte(), 0, 1);
            if (preg_match('/^[a-z]{1}$/', $premiereLettre))
                return $premiereLettre;
        }
        return '_';
    }
    
    /**
     * Enregistre l'icône sur le disque.
     *
     * @return void
     */
    protected function uploadImage()
    {
        $this->deleteImage();
        $this->miniature = null;

        $fichier = new Fichier($this->imageFile->getRealPath());
        $this->image = $this->imageFile->getClientOriginalName();
        $this->dossier = $this->guessSousDossier();
        $fichier->move($this->getImageUploadDir().DIRECTORY_SEPARATOR.$this->image, false);

        $image = new Image($fichier->getChemin());
        $image->setNomMinifie($this->getTitle(), '-', true, 128);

        $this->image = $image->getNom();
        if ($image->getLargeur() >= $image->getHauteur() && $image->getLargeur() > $this->getLargeurMaximale())
            $image->redimensionne($this->getLargeurMaximale(), null, true);
        elseif ($image->getLargeur() < $image->getHauteur() && $image->getHauteur() > $this->getHauteurMaximale())
            $image->redimensionne(null, $this->getHauteurMaximale(), true);
        $this->largeur = $image->getLargeur();
        $this->hauteur = $image->getHauteur();

        $this->setImageFile(null);
    }
    
    /**
     * Retourne la largeur maximale de l'image.
     * 
     * @return integer Largeur maximale
     */
    protected function getLargeurMaximale()
    {
        if (null === $this->originale) {
            return static::$ORIGINALE_LARGEUR_MAXIMALE;
        }

        return static::$MINIATURE_LARGEUR_MAXIMALE;
    }
    
    /**
     * Retourne la hauteur maximale de l'image.
     * 
     * @return integer Hauteur maximale
     */
    protected function getHauteurMaximale()
    {
        if (null === $this->originale) {
            return static::$ORIGINALE_HAUTEUR_MAXIMALE;
        }

        return static::$MINIATURE_HAUTEUR_MAXIMALE;
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemove()
    {
        $this->deleteImage();
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if (null !== $this->imageFile)
            $this->uploadImage();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
    
    /**
     * Retourne le titre de l'image.
     * 
     * @return string Titre
     */
    public function getTitle()
    {
        if (null !== $this->rectoElement)
            return $this->rectoElement->getNom();
        if (null !== $this->versoElement)
            return $this->versoElement->getNom();
        if (null !== $this->element)
            return $this->element->getNom();
        if (null !== $this->originale)
            return $this->originale->getTitle();
        if (null !== $this->image)
            return (false !== strpos($this->image, '.') ? substr($this->image, 0, strrpos($this->image, '.')) : $this->image);
        return '#'.$this->id;
    }
}
