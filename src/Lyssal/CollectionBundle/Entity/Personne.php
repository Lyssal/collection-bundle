<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Lyssal\StructureBundle\Entity\ImageTrait;
use Lyssal\Image;

/**
 * Personne.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Personne
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
     * @ORM\Column(name="personne_id", type="bigint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="personne_nom", type="string", nullable=true, length=32)
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="personne_prenom", type="string", nullable=false, length=32)
     * @Assert\NotBlank()
     */
    protected $prenom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="personne_slug", length=64, unique=true)
     * @Gedmo\Slug(fields={"prenom", "nom"}, style="camel", separator="_", updatable=true)
     * @Gedmo\Translatable()
     */
    protected $slug;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Pays
     * 
     * @ORM\ManyToOne(targetEntity="\Lyssal\GeographieBundle\Entity\Pays", inversedBy="personnes")
     * @ORM\JoinColumn(name="nationalite_id", referencedColumnName="pays_id", nullable=true, onDelete="SET NULL")
     */
    protected $nationalite;
    
    /**
     * @var string
     *
     * @ORM\Column(name="personne_image", type="string", nullable=true, length=128)
     */
    protected $image;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementPersonne", mappedBy="personne")
     */
    protected $elementPersonnes;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elementPersonnes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Personne
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
     * Set prenom
     *
     * @param string $prenom
     * @return Personne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Personne
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
     * Set nationalite
     *
     * @param \Lyssal\GeographieBundle\Entity\Pays $nationalite
     * @return Personne
     */
    public function setNationalite(\Lyssal\GeographieBundle\Entity\Pays $nationalite = null)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return \Lyssal\GeographieBundle\Entity\Pays 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Add elementPersonnes
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementPersonne $elementPersonnes
     * @return Personne
     */
    public function addElementPersonne(\Lyssal\CollectionBundle\Entity\ElementPersonne $elementPersonnes)
    {
        $this->elementPersonnes[] = $elementPersonnes;

        return $this;
    }

    /**
     * Remove elementPersonnes
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementPersonne $elementPersonnes
     */
    public function removeElementPersonne(\Lyssal\CollectionBundle\Entity\ElementPersonne $elementPersonnes)
    {
        $this->elementPersonnes->removeElement($elementPersonnes);
    }

    /**
     * Get elementPersonnes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElementPersonnes()
    {
        return $this->elementPersonnes;
    }
    
    
    /**
     * Répertoire dans lequel est enregistré l'image.
     *
     * @return string Dossier de l'image
     */
    public function getImageUploadDir()
    {
        return 'img/lyssal_collection/personne';
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
        $image->setNomMinifie($this->__toString(), '-', true, 128);
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
        return $this->prenom.(null !== $this->nom ? ' '.$this->nom : '');
    }
}
