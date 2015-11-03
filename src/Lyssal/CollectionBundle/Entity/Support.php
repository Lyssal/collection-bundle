<?php
namespace Lyssal\CollectionBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Lyssal\StructureBundle\Entity\IconeTrait;
use Lyssal\Image;

/**
 * Support.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Support implements Translatable, TranslatableInterface
{
    use IconeTrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="support_id", type="smallint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="support_nom", type="string", nullable=false, length=64)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="support_slug", length=64, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     * @Gedmo\Translatable()
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="support_icone", type="string", nullable=false, length=32)
     */
    protected $icone;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Type", inversedBy="supports")
     * @ORM\JoinTable
     * (
     *  name="lyssal_collection_support_a_type",
     *  joinColumns={@ORM\JoinColumn(name="support_id", referencedColumnName="support_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="type_id", referencedColumnName="type_id", onDelete="CASCADE")}
     * )
     */
    protected $types;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="ElementSupport", mappedBy="support")
     */
    protected $elementSupports;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="UtilisateurSupport", mappedBy="support")
     */
    protected $utilisateurSupports;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementSupports = new \Doctrine\Common\Collections\ArrayCollection();
        $this->utilisateurSupports = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Support
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
     * @return Support
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
     * @return Support
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
     * Add types
     *
     * @param \Lyssal\CollectionBundle\Entity\Type $types
     * @return Support
     */
    public function addType(\Lyssal\CollectionBundle\Entity\Type $types)
    {
        $this->types[] = $types;

        return $this;
    }

    /**
     * Remove types
     *
     * @param \Lyssal\CollectionBundle\Entity\Type $types
     */
    public function removeType(\Lyssal\CollectionBundle\Entity\Type $types)
    {
        $this->types->removeElement($types);
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Add elementSupports
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports
     * @return Support
     */
    public function addElementSupport(\Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports)
    {
        $this->elementSupports[] = $elementSupports;

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
     * Add utilisateurSupports
     *
     * @param \Lyssal\CollectionBundle\Entity\UtilisateurSupport $utilisateurSupports
     * @return Support
     */
    public function addUtilisateurSupport(\Lyssal\CollectionBundle\Entity\UtilisateurSupport $utilisateurSupports)
    {
        $this->utilisateurSupports[] = $utilisateurSupports;

        return $this;
    }

    /**
     * Remove utilisateurSupports
     *
     * @param \Lyssal\CollectionBundle\Entity\UtilisateurSupport $utilisateurSupports
     */
    public function removeUtilisateurSupport(\Lyssal\CollectionBundle\Entity\UtilisateurSupport $utilisateurSupports)
    {
        $this->utilisateurSupports->removeElement($utilisateurSupports);
    }

    /**
     * Get utilisateurSupports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUtilisateurSupports()
    {
        return $this->utilisateurSupports;
    }


    /**
     * Répertoire dans lequel est enregistré l'icône.
     *
     * @return string Dossier de l'icône
     */
    public function getIconeUploadDir()
    {
        return 'img/lyssal_collection/support/32';
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
