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
 * Type de collection.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Type implements Translatable, TranslatableInterface
{
    use IconeTrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="type_id", type="smallint", nullable=false, options={"unsigned":true})
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
     * @ORM\Column(name="type_nom", type="string", nullable=false, length=32)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type_slug", length=32, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     * @Gedmo\Translatable()
     */
    protected $slug;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type_couleur", type="string", nullable=false, length=6)
     */
    protected $couleur;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type_icone", type="string", nullable=false, length=32)
     */
    protected $icone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type_element_nom", type="string", nullable=false, length=32)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $elementNom;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Genre", mappedBy="type")
     * @ORM\OrderBy({ "nom":"ASC" })
     */
    protected $genres;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="SocieteRole", mappedBy="type")
     */
    protected $societeRoles;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="PersonneRole", mappedBy="type")
     */
    protected $personneRoles;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Element", mappedBy="type")
     */
    protected $elements;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Support", mappedBy="types")
     */
    protected $supports;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\SupportLangageType
     * 
     * @ORM\ManyToOne(targetEntity="SupportLangageType", inversedBy="defautTypes")
     * @ORM\JoinColumn(name="support_langage_type_defaut_id", referencedColumnName="support_langage_type_id", nullable=true, onDelete="SET NULL")
     */
    protected $supportLangageTypeDefaut;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->societeRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->personneRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supports = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Type
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
     * @return Type
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
     * Set couleur
     *
     * @param string $couleur
     * @return Type
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string 
     */
    public function getCouleur()
    {
        return $this->couleur;
    }
    
    /**
     * Set icone
     *
     * @param string $icone
     * @return Type
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
     * Set elementNom
     *
     * @param string $elementNom
     * @return Type
     */
    public function setElementNom($elementNom)
    {
        $this->elementNom = $elementNom;
    
        return $this;
    }
    
    /**
     * Get elementNom
     *
     * @return string
     */
    public function getElementNom()
    {
        return $this->elementNom;
    }
    
    /**
     * Add genres
     *
     * @param \Lyssal\CollectionBundle\Entity\Genre $genres
     * @return Type
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
     * Add societeRoles
     *
     * @param \Lyssal\CollectionBundle\Entity\SocieteRole $societeRoles
     * @return Type
     */
    public function addSocieteRole(\Lyssal\CollectionBundle\Entity\SocieteRole $societeRoles)
    {
        $this->societeRoles[] = $societeRoles;
    
        return $this;
    }
    
    /**
     * Remove societeRoles
     *
     * @param \Lyssal\CollectionBundle\Entity\SocieteRole $societeRoles
     */
    public function removeSocieteRole(\Lyssal\CollectionBundle\Entity\SocieteRole $societeRoles)
    {
        $this->societeRoles->removeElement($societeRoles);
    }
    
    /**
     * Get societeRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSocieteRoles()
    {
        return $this->societeRoles;
    }

    /**
     * Add personneRoles
     *
     * @param \Lyssal\CollectionBundle\Entity\PersonneRole $personneRoles
     * @return Type
     */
    public function addPersonneRole(\Lyssal\CollectionBundle\Entity\PersonneRole $personneRoles)
    {
        $this->personneRoles[] = $personneRoles;
    
        return $this;
    }
    
    /**
     * Remove personneRoles
     *
     * @param \Lyssal\CollectionBundle\Entity\PersonneRole $personneRoles
     */
    public function removePersonneRole(\Lyssal\CollectionBundle\Entity\PersonneRole $personneRoles)
    {
        $this->personneRoles->removeElement($personneRoles);
    }
    
    /**
     * Get personneRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonneRoles()
    {
        return $this->personneRoles;
    }
    
    /**
     * Add elements
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $elements
     * @return Type
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
     * Add supports
     *
     * @param \Lyssal\CollectionBundle\Entity\Support $supports
     * @return Type
     */
    public function addSupport(\Lyssal\CollectionBundle\Entity\Support $supports)
    {
        $this->supports[] = $supports;

        return $this;
    }

    /**
     * Remove supports
     *
     * @param \Lyssal\CollectionBundle\Entity\Support $supports
     */
    public function removeSupport(\Lyssal\CollectionBundle\Entity\Support $supports)
    {
        $this->supports->removeElement($supports);
    }

    /**
     * Get supports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupports()
    {
        return $this->supports;
    }

    /**
     * Set supportLangageTypeDefaut
     *
     * @param \Lyssal\CollectionBundle\Entity\SupportLangageType $supportLangageTypeDefaut
     * @return Type
     */
    public function setSupportLangageTypeDefaut(\Lyssal\CollectionBundle\Entity\SupportLangageType $supportLangageTypeDefaut = null)
    {
        $this->supportLangageTypeDefaut = $supportLangageTypeDefaut;

        return $this;
    }

    /**
     * Get supportLangageTypeDefaut
     *
     * @return \Lyssal\CollectionBundle\Entity\SupportLangageType 
     */
    public function getSupportLangageTypeDefaut()
    {
        return $this->supportLangageTypeDefaut;
    }
    
    
    /**
     * Répertoire dans lequel est enregistré l'icône.
     * 
     * @return string Dossier de l'icône
     */
    public function getIconeUploadDir()
    {
        return 'img/lyssal_collection/type/128';
    }
    /**
     * Répertoire dans lequel est enregistré l'icône 32px.
     * 
     * @return string Dossier de l'icône
     */
    public function getIcone32UploadDir()
    {
        return 'img/lyssal_collection/type/32';
    }
    /**
     * Répertoire dans lequel est enregistré l'icône 32px.
     * 
     * @return string Dossier de l'icône
     */
    public function getIcone16UploadDir()
    {
        return 'img/lyssal_collection/type/16';
    }
    /**
     * Retourne l'URL de l'icône 128px.
     * 
     * @return string URL de l'icône 128px
     */
    public function getIcone128Url()
    {
        return $this->getIconeChemin();
    }
    /**
     * Retourne l'URL de l'icône 32px.
     * 
     * @return string URL de l'icône 32px
     */
    public function getIcone32Url()
    {
        return $this->getIcone32UploadDir().'/'.$this->icone;
    }
    /**
     * Retourne l'URL de l'icône 16px.
     * 
     * @return string URL de l'icône 16px
     */
    public function getIcone16Url()
    {
        return $this->getIcone16UploadDir().'/'.$this->icone;
    }
    /**
     * Enregistre l'icône sur le disque.
     *
     * @return void
     */
    protected function uploadIcone()
    {
        if ('' != $this->icone && file_exists($this->getIcone32Url()))
            unlink($this->getIcone32Url());
        if ('' != $this->icone && file_exists($this->getIcone16Url()))
            unlink($this->getIcone16Url());
            
        $this->saveIcone(false);
        
        // On minifie le nom du fichier avec le nom de l'entité
        $icone = new Image($this->getIconeChemin());
        $icone->setNomMinifie($this->nom, '-', true, 32);
        $this->icone = $icone->getNom();
        
        $icone32 = $icone->copy($this->getIcone32Url(), false);
        $icone16 = $icone->copy($this->getIcone16Url(), false);

        $icone->redimensionne(128, 128);
        $icone32->redimensionne(32, 32);
        $icone16->redimensionne(16, 16);
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
