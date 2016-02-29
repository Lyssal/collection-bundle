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
 * Plateforme.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Plateforme implements Translatable, TranslatableInterface
{
    use IconeTrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="plateforme_id", type="smallint", nullable=false, options={"unsigned":true})
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
     * @ORM\Column(name="plateforme_nom", type="string", nullable=false, length=64)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="plateforme_slug", length=64, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     * @Gedmo\Translatable()
     */
    protected $slug;
    
    /**
     * @var string
     *
     * @ORM\Column(name="plateforme_icone", type="string", nullable=false, length=64)
     */
    protected $icone;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File
     */
    protected $iconeFile;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\Lyssal\CollectionBundle\Entity\Type\Logiciel", mappedBy="plateformes")
     */
    protected $logiciels;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\Lyssal\CollectionBundle\Entity\Type\JeuVideo", mappedBy="plateformes")
     */
    protected $jeuxVideo;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->logiciels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jeuxVideo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Plateforme
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
     * @return Plateforme
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
     * Add logiciels
     *
     * @param \Lyssal\CollectionBundle\Entity\Type\Logiciel $logiciels
     * @return Plateforme
     */
    public function addLogiciel(\Lyssal\CollectionBundle\Entity\Type\Logiciel $logiciels)
    {
        $this->logiciels[] = $logiciels;
    
        return $this;
    }
    
    /**
     * Remove logiciels
     *
     * @param \Lyssal\CollectionBundle\Entity\Type\Logiciel $logiciels
     */
    public function removeLogiciel(\Lyssal\CollectionBundle\Entity\Type\Logiciel $logiciels)
    {
        $this->logiciels->removeElement($logiciels);
    }
    
    /**
     * Get logiciels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogiciels()
    {
        return $this->logiciels;
    }
    
    /**
     * Add jeuVideo
     *
     * @param \Lyssal\CollectionBundle\Entity\Type\JeuVideo $jeuVideo
     * @return Plateforme
     */
    public function addJeuxVideo(\Lyssal\CollectionBundle\Entity\Type\JeuVideo $jeuVideo)
    {
        $this->jeuxVideo[] = $jeuVideo;
    
        return $this;
    }
    
    /**
     * Remove jeuVideo
     *
     * @param \Lyssal\CollectionBundle\Entity\Type\JeuVideo $jeuVideo
     */
    public function removeJeuxVideo(\Lyssal\CollectionBundle\Entity\Type\JeuVideo $jeuVideo)
    {
        $this->jeuxVideo->removeElement($jeuVideo);
    }
    
    /**
     * Get jeuxVideo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJeuxVideo()
    {
        return $this->jeuxVideo;
    }
    

    /**
     * Répertoire dans lequel est enregistré l'icône.
     *
     * @return string Dossier de l'icône
     */
    public function getIconeUploadDir()
    {
        return 'img/lyssal_collection/plateforme/32';
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
