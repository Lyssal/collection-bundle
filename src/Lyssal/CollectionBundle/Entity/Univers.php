<?php
namespace Lyssal\CollectionBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Lyssal\StructureBundle\Traits\IconeTrait;
use Lyssal\Image;

/**
 * Genre.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Univers implements Translatable, TranslatableInterface
{
    use IconeTrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="univers_id", type="smallint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="univers_nom", type="string", nullable=false, length=64)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="univers_slug", length=64, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     * @Gedmo\Translatable()
     */
    protected $slug;
    
    /**
     * @var string
     *
     * @ORM\Column(name="univers_icone", type="string", nullable=false, length=32)
     */
    protected $icone;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File
     */
    protected $iconeFile;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Element", mappedBy="univers")
     */
    protected $elements;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set locale
     *
     * @param string $locale
     * @return Element
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    
        return $this;
    }
    
    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Set nom
     *
     * @param string $nom
     * @return Univers
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
     * @return Univers
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
     * Set icone
     *
     * @param string $icone
     * @return Univers
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;
    
        return $this;
    }
    
    /**
     * Get icone
     *
     * @return string
     */
    public function getIcone()
    {
        return $this->icone;
    }
    
    /**
     * Add elements
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $elements
     * @return Univers
     */
    public function addElement(\Lyssal\CollectionBundle\Entity\Element $elements)
    {
        $this->elements[] = $elements;
    
        return $this;
    }
    
    /**
     * Remove elements
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $elements
     */
    public function removeElement(\Lyssal\CollectionBundle\Entity\Element $elements)
    {
        $this->elements->removeElement($elements);
    }
    
    /**
     * Get elements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElements()
    {
        return $this->elements;
    }
    
    
    /**
     * Répertoire dans lequel est enregistré l'icône.
     *
     * @return string Dossier de l'icône
     */
    public function getIconeUploadDir()
    {
        return 'img/lyssal_collection/univers/32';
    }
    /**
     * Retourne l'URL de l'icône 32px.
     *
     * @return string URL de l'icône 32px
     */
    public function getIcone32Url()
    {
        return $this->getIconeChemin();
    }
    /**
     * Enregistre l'icône sur le disque.
     *
     * @return void
     */
    protected function uploadIcone()
    {
        $this->saveIcone(false);
    
        $icone = new Image($this->getIconeChemin());
        $icone->setNomMinifie($this->nom, '-', true, 32);
        $this->icone = $icone->getNom();
    
        $icone->redimensionne(32, 32);
    }
    
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
