<?php
namespace Lyssal\CollectionBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Élément.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Element implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="element_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Type
     * 
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="elements")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="type_id", nullable=false, onDelete="CASCADE")
     */
    protected $type;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\ElementGroupe
     * 
     * @ORM\ManyToOne(targetEntity="ElementGroupe", inversedBy="elements")
     * @ORM\JoinColumn(name="element_groupe_id", referencedColumnName="element_groupe_id", nullable=true, onDelete="SET NULL")
     */
    protected $groupe;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;
    
    /**
     * @var string
     *
     * @ORM\Column(name="element_nom", type="string", nullable=false, length=128)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="element_slug", length=128, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     * @Gedmo\Translatable()
     */
    protected $slug;
    
    /**
     * @var string
     *
     * @ORM\Column(name="element_description", type="string", nullable=true, length=255)
     * @Gedmo\Translatable()
     */
    protected $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="element_contenu", type="text", nullable=true)
     * @Gedmo\Translatable()
     */
    protected $contenu;

    /**
     * @var \Lyssal\CollectionBundle\Entity\Illustration
     *
     * @ORM\OneToOne(targetEntity="Illustration", inversedBy="rectoElement", cascade={"persist"})
     * @ORM\JoinColumn(name="illustration_recto_id", referencedColumnName="illustration_id", nullable=true, onDelete="SET NULL")
     */
    protected $illustrationRecto;

    /**
     * @var \Lyssal\CollectionBundle\Entity\Illustration
     *
     * @ORM\OneToOne(targetEntity="Illustration", inversedBy="versoElement", cascade={"persist"})
     * @ORM\JoinColumn(name="illustration_verso_id", referencedColumnName="illustration_id", nullable=true, onDelete="SET NULL")
     */
    protected $illustrationVerso;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\OneToOne(targetEntity="Element", inversedBy="elementSuivant", cascade={"persist"})
     * @ORM\JoinColumn(name="element_precedent_id", referencedColumnName="element_id", nullable=true, onDelete="SET NULL")
     */
    protected $elementPrecedent;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\OneToOne(targetEntity="Element", mappedBy="elementPrecedent")
     */
    protected $elementSuivant;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="elements")
     * @ORM\JoinTable
     * (
     *  name="lyssal_collection_element_a_genre",
     *  joinColumns={@ORM\JoinColumn(name="element_id", referencedColumnName="element_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="genre_id", onDelete="CASCADE")}
     * )
     */
    protected $genres;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Element", inversedBy="enfants")
     * @ORM\JoinTable
     * (
     *  name="lyssal_collection_element_a_element_parent",
     *  joinColumns={@ORM\JoinColumn(name="element_parent_id", referencedColumnName="element_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="element_id", referencedColumnName="element_id", onDelete="CASCADE")}
     * )
     */
    protected $parents;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Element", mappedBy="parents")
     */
    protected $enfants;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Univers", inversedBy="elements")
     * @ORM\JoinTable
     * (
     *  name="lyssal_collection_element_a_univers",
     *  joinColumns={@ORM\JoinColumn(name="element_id", referencedColumnName="element_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="univers_id", referencedColumnName="univers_id", onDelete="CASCADE")}
     * )
     */
    protected $univers;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="\Lyssal\GeographieBundle\Entity\Pays")
     * @ORM\JoinTable
     * (
     *  name="lyssal_collection_element_a_origine",
     *  joinColumns={@ORM\JoinColumn(name="element_id", referencedColumnName="element_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", onDelete="CASCADE")}
     * )
     */
    protected $origines;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementDate", mappedBy="element", cascade={"persist"})
     */
    protected $elementDates;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementPrix", mappedBy="element", cascade={"persist"})
     */
    protected $elementPrix;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementSociete", mappedBy="element", cascade={"persist"})
     */
    protected $elementSocietes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementPersonne", mappedBy="element", cascade={"persist"})
     */
    protected $elementPersonnes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Illustration", mappedBy="element", cascade={"persist"}, orphanRemoval=true)
     */
    protected $illustrations;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementSupport", mappedBy="element", cascade={"persist"})
     */
    protected $elementSupports;
    
    
    /**
     * Constructeur.
     */
    public function __construct()
    {
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->univers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->origines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementDates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementPrix = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementSocietes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementPersonnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->illustrations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementSupports = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type
     *
     * @param \Lyssal\CollectionBundle\Entity\Type $type
     * @return Element
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
     * Set groupe
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementGroupe $groupe
     * @return Element
     */
    public function setGroupe(\Lyssal\CollectionBundle\Entity\ElementGroupe $groupe = null)
    {
        $this->groupe = $groupe;
    
        return $this;
    }
    
    /**
     * Get groupe
     *
     * @return \Lyssal\CollectionBundle\Entity\ElementGroupe
     */
    public function getGroupe()
    {
        return $this->groupe;
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
     * @return Element
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
     * @return Element
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
     * Set description
     *
     * @param string $description
     * @return Element
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Element
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set illustrationRecto
     *
     * @param \Lyssal\CollectionBundle\Entity\Illustration $illustrationRecto
     * @return Element
     */
    public function setIllustrationRecto(\Lyssal\CollectionBundle\Entity\Illustration $illustrationRecto = null)
    {
        $this->illustrationRecto = $illustrationRecto;
        
        if (null !== $this->illustrationRecto && null === $this->illustrationRecto->getRectoElement())
            $this->illustrationRecto->setRectoElement($this);

        return $this;
    }

    /**
     * Get illustrationRecto
     *
     * @return \Lyssal\CollectionBundle\Entity\Illustration 
     */
    public function getIllustrationRecto()
    {
        return $this->illustrationRecto;
    }

    /**
     * Set illustrationVerso
     *
     * @param \Lyssal\CollectionBundle\Entity\Illustration $illustrationVerso
     * @return Element
     */
    public function setIllustrationVerso(\Lyssal\CollectionBundle\Entity\Illustration $illustrationVerso = null)
    {
        $this->illustrationVerso = $illustrationVerso;
        
        if (null !== $this->illustrationVerso && null === $this->illustrationVerso->getVersoElement())
            $this->illustrationVerso->setVersoElement($this);

        return $this;
    }

    /**
     * Get illustrationVerso
     *
     * @return \Lyssal\CollectionBundle\Entity\Illustration 
     */
    public function getIllustrationVerso()
    {
        return $this->illustrationVerso;
    }

    /**
     * Set elementPrecedent
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $elementPrecedent
     * @return Element
     */
    public function setElementPrecedent(\Lyssal\CollectionBundle\Entity\Element $elementPrecedent = null)
    {
        $this->elementPrecedent = $elementPrecedent;
    
        return $this;
    }
    
    /**
     * Get elementPrecedent
     *
     * @return \Lyssal\CollectionBundle\Entity\Element
     */
    public function getElementPrecedent()
    {
        return $this->elementPrecedent;
    }
    
    /**
     * Set elementSuivant
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $elementSuivant
     * @return Element
     */
    public function setElementSuivant(\Lyssal\CollectionBundle\Entity\Element $elementSuivant = null)
    {
        $this->elementSuivant = $elementSuivant;
        $this->elementSuivant->setElementPrecedent($this);
    
        return $this;
    }
    
    /**
     * Get elementSuivant
     *
     * @return \Lyssal\CollectionBundle\Entity\Element
     */
    public function getElementSuivant()
    {
        return $this->elementSuivant;
    }

    /**
     * Add genres
     *
     * @param \Lyssal\CollectionBundle\Entity\Genre $genres
     * @return Element
     */
    public function addGenre(\Lyssal\CollectionBundle\Entity\Genre $genres)
    {
        $this->genres[] = $genres;

        return $this;
    }

    /**
     * Remove genres
     *
     * @param \Lyssal\CollectionBundle\Entity\Genre $genres
     */
    public function removeGenre(\Lyssal\CollectionBundle\Entity\Genre $genres)
    {
        $this->genres->removeElement($genres);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Add parents
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $parents
     * @return Element
     */
    public function addParent(\Lyssal\CollectionBundle\Entity\Element $parents)
    {
        $this->parents[] = $parents;

        return $this;
    }

    /**
     * Remove parents
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $parents
     */
    public function removeParent(\Lyssal\CollectionBundle\Entity\Element $parents)
    {
        $this->parents->removeElement($parents);
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * Add enfants
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $enfants
     * @return Element
     */
    public function addEnfant(\Lyssal\CollectionBundle\Entity\Element $enfants)
    {
        $this->enfants[] = $enfants;

        return $this;
    }

    /**
     * Remove enfants
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $enfants
     */
    public function removeEnfant(\Lyssal\CollectionBundle\Entity\Element $enfants)
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
     * Add univers
     *
     * @param \Lyssal\CollectionBundle\Entity\Univers $univers
     * @return Element
     */
    public function addUnivers(\Lyssal\CollectionBundle\Entity\Univers $univers)
    {
        $this->univers[] = $univers;

        return $this;
    }

    /**
     * Remove univers
     *
     * @param \Lyssal\CollectionBundle\Entity\Univers $univers
     */
    public function removeUnivers(\Lyssal\CollectionBundle\Entity\Univers $univers)
    {
        $this->univers->removeElement($univers);
    }

    /**
     * Get univers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnivers()
    {
        return $this->univers;
    }

    /**
     * Add origines
     *
     * @param \Lyssal\GeographieBundle\Entity\Pays $origines
     * @return Element
     */
    public function addOrigine(\Lyssal\GeographieBundle\Entity\Pays $origines)
    {
        $this->origines[] = $origines;

        return $this;
    }

    /**
     * Remove origines
     *
     * @param \Lyssal\GeographieBundle\Entity\Pays $origines
     */
    public function removeOrigine(\Lyssal\GeographieBundle\Entity\Pays $origines)
    {
        $this->origines->removeElement($origines);
    }

    /**
     * Get origines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrigines()
    {
        return $this->origines;
    }

    /**
     * Add elementDate
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementDate $elementDate
     * @return Element
     */
    public function addElementDate(\Lyssal\CollectionBundle\Entity\ElementDate $elementDate)
    {
        if (null === $elementDate->getElement())
            $elementDate->setElement($this);

        $this->elementDates[] = $elementDate;

        return $this;
    }

    /**
     * Remove elementDates
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementDate $elementDates
     */
    public function removeElementDate(\Lyssal\CollectionBundle\Entity\ElementDate $elementDates)
    {
        $this->elementDates->removeElement($elementDates);
    }

    /**
     * Get elementDates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElementDates()
    {
        return $this->elementDates;
    }

    /**
     * Add elementPrix
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementPrix $elementPrix
     * @return Element
     */
    public function addElementPrix(\Lyssal\CollectionBundle\Entity\ElementPrix $elementPrix)
    {
        if (null === $elementPrix->getElement())
            $elementPrix->setElement($this);
        
        $this->elementPrix[] = $elementPrix;

        return $this;
    }

    /**
     * Remove elementPrix
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementPrix $elementPrix
     */
    public function removeElementPrix(\Lyssal\CollectionBundle\Entity\ElementPrix $elementPrix)
    {
        $this->elementPrix->removeElement($elementPrix);
    }

    /**
     * Get elementPrix
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElementPrix()
    {
        return $this->elementPrix;
    }

    /**
     * Add elementSociete
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSociete $elementSociete
     * @return Element
     */
    public function addElementSociete(\Lyssal\CollectionBundle\Entity\ElementSociete $elementSociete)
    {
        if (null === $elementSociete->getElement())
            $elementSociete->setElement($this);
        
        $this->elementSocietes[] = $elementSociete;

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
     * Add elementPersonne
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementPersonne $elementPersonne
     * @return Element
     */
    public function addElementPersonne(\Lyssal\CollectionBundle\Entity\ElementPersonne $elementPersonne)
    {
        if (null === $elementPersonne->getElement())
            $elementPersonne->setElement($this);
        
        $this->elementPersonnes[] = $elementPersonne;

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
     * Add illustrations
     *
     * @param \Lyssal\CollectionBundle\Entity\Illustration $illustrations
     * @return Element
     */
    public function addIllustration(\Lyssal\CollectionBundle\Entity\Illustration $illustration)
    {
        if (null === $illustration->getElement())
            $illustration->setElement($this);
        
        $this->illustrations[] = $illustration;

        return $this;
    }

    /**
     * Remove illustrations
     *
     * @param \Lyssal\CollectionBundle\Entity\Illustration $illustrations
     */
    public function removeIllustration(\Lyssal\CollectionBundle\Entity\Illustration $illustrations)
    {
        $this->illustrations->removeElement($illustrations);
    }

    /**
     * Get illustrations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIllustrations()
    {
        return $this->illustrations;
    }

    /**
     * Add elementSupports
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports
     * @return Element
     */
    public function addElementSupport(\Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports)
    {
        $this->elementSupports[] = $elementSupports;
        $elementSupports->setElement($this);

        return $this;
    }

    /**
     * Remove elementSupports
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports
     */
    public function removeElementSupport(\Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports)
    {
        $this->elementSupports->removeElement($elementSupports);
    }

    /**
     * Get elementSupports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElementSupports()
    {
        return $this->elementSupports;
    }
    
    
    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->nom);
    }
}
