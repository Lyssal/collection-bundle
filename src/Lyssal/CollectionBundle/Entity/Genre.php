<?php
namespace Lyssal\CollectionBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Genre.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Genre implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="genre_id", type="smallint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Type
     * 
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="genres")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="type_id", nullable=false, onDelete="CASCADE")
     */
    protected $type;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="genre_nom", type="string", nullable=false, length=64)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="genre_slug", length=64, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     * @Gedmo\Translatable()
     */
    protected $slug;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Genre
     * 
     * @ORM\ManyToOne(targetEntity="Genre", inversedBy="enfants")
     * @ORM\JoinColumn(name="genre_parent_id", referencedColumnName="genre_id", nullable=true, onDelete="SET NULL")
     */
    protected $parent;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Genre", mappedBy="parent")
     */
    protected $enfants;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Element", mappedBy="genres")
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
     * @return Genre
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
     * @return Genre
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
     * Set type
     *
     * @param \Lyssal\CollectionBundle\Entity\Type $type
     * @return Genre
     */
    public function setType(\Lyssal\CollectionBundle\Entity\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Lyssal\CollectionBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set parent
     *
     * @param \Lyssal\CollectionBundle\Entity\Genre $parent
     * @return Genre
     */
    public function setParent(\Lyssal\CollectionBundle\Entity\Genre $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Lyssal\CollectionBundle\Entity\Genre 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add enfants
     *
     * @param \Lyssal\CollectionBundle\Entity\Genre $enfants
     * @return Genre
     */
    public function addEnfant(\Lyssal\CollectionBundle\Entity\Genre $enfants)
    {
        $this->enfants[] = $enfants;

        return $this;
    }

    /**
     * Remove enfants
     *
     * @param \Lyssal\CollectionBundle\Entity\Genre $enfants
     */
    public function removeEnfant(\Lyssal\CollectionBundle\Entity\Genre $enfants)
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
     * Add elements
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $elements
     * @return Genre
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
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
