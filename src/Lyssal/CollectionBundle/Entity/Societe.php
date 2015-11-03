<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Lyssal\StructureBundle\Entity\ImageTrait;
use Lyssal\Image;

/**
 * Société.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Societe
{
    use ImageTrait;
    
    /**
     * @var integer Largeur maximale de l'image (en pixels)
     */
    public static $IMAGE_LARGEUR_MAXIMALE = 400;
    
    /**
     * @var integer Hauteur maximale de l'image (en pixels)
     */
    public static $IMAGE_HAUTEUR_MAXIMALE = 400;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="societe_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="societe_nom", type="string", nullable=false, length=32)
     * @Assert\NotBlank()
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="societe_slug", length=32, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     * @Gedmo\Translatable()
     */
    protected $slug;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Pays
     * 
     * @ORM\ManyToOne(targetEntity="\Lyssal\GeographieBundle\Entity\Pays", inversedBy="societes")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=true, onDelete="CASCADE")
     */
    protected $pays;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Societe
     * 
     * @ORM\ManyToOne(targetEntity="Societe", inversedBy="enfants")
     * @ORM\JoinColumn(name="societe_parent_id", referencedColumnName="societe_id", nullable=true, onDelete="SET NULL")
     */
    protected $parent;
    
    /**
     * @var string
     *
     * @ORM\Column(name="societe_image", type="string", nullable=true, length=128)
     */
    protected $image;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Societe", mappedBy="parent")
     */
    protected $enfants;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="\Lyssal\CollectionBundle\Entity\ElementSociete", mappedBy="societe")
     */
    protected $elementSocietes;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementSocietes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

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
     * Set nom
     *
     * @param string $nom
     * @return Societe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Societe
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }
    
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set pays
     *
     * @param \Lyssal\GeographieBundle\Entity\Pays $pays
     * @return Societe
     */
    public function setPays(\Lyssal\GeographieBundle\Entity\Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \Lyssal\GeographieBundle\Entity\Pays 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set parent
     *
     * @param \Lyssal\CollectionBundle\Entity\Societe $parent
     * @return Societe
     */
    public function setParent(\Lyssal\CollectionBundle\Entity\Societe $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Lyssal\CollectionBundle\Entity\Societe 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add enfants
     *
     * @param \Lyssal\CollectionBundle\Entity\Societe $enfants
     * @return Societe
     */
    public function addEnfant(\Lyssal\CollectionBundle\Entity\Societe $enfants)
    {
        $this->enfants[] = $enfants;

        return $this;
    }

    /**
     * Remove enfants
     *
     * @param \Lyssal\CollectionBundle\Entity\Societe $enfants
     */
    public function removeEnfant(\Lyssal\CollectionBundle\Entity\Societe $enfants)
    {
        $this->enfants->removeElement($enfants);
    }

    /**
     * Get enfants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEnfants()
    {
        return $this->enfants;
    }

    /**
     * Add elementSocietes
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSociete $elementSocietes
     * @return Societe
     */
    public function addElementSociete(\Lyssal\CollectionBundle\Entity\ElementSociete $elementSocietes)
    {
        $this->elementSocietes[] = $elementSocietes;

        return $this;
    }

    /**
     * Remove elementSocietes
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSociete $elementSocietes
     */
    public function removeElementSociete(\Lyssal\CollectionBundle\Entity\ElementSociete $elementSocietes)
    {
        $this->elementSocietes->removeElement($elementSocietes);
    }

    /**
     * Get elementSocietes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElementSocietes()
    {
        return $this->elementSocietes;
    }
    
    
    /**
     * Répertoire dans lequel est enregistré l'image.
     *
     * @return string Dossier de l'image
     */
    public function getImageUploadDir()
    {
        return 'img/lyssal_collection/societe';
    }
    /**
     * Enregistre l'icône sur le disque.
     *
     * @return void
     */
    protected function uploadImage()
    {
        $this->saveImage(false);
    
        $image = new Image($this->getImageChemin());
        $image->setNomMinifie($this->nom, '-', true, 128);
        $this->image = $image->getNom();
    
        if ($image->getLargeur() >= $image->getHauteur() && $image->getLargeur() > self::$IMAGE_LARGEUR_MAXIMALE)
            $image->redimensionne(self::$IMAGE_LARGEUR_MAXIMALE, null, true);
        elseif ($image->getLargeur() < $image->getHauteur() && $image->getHauteur() > self::$IMAGE_HAUTEUR_MAXIMALE)
            $image->redimensionne(null, self::$IMAGE_HAUTEUR_MAXIMALE, true);
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
