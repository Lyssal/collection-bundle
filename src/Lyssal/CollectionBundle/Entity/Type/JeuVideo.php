<?php
namespace Lyssal\CollectionBundle\Entity\Type;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Jeu vidéo.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class JeuVideo implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="jeu_video_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\OneToOne(targetEntity="\Lyssal\CollectionBundle\Entity\Element", inversedBy="jeuVideo", cascade={"persist"})
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="jeu_video_triche", type="text", nullable=true)
     * @Gedmo\Translatable()
     */
    protected $triche;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="jeu_video_multijoueur", type="boolean", nullable=true)
     */
    protected $multijoueur;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="jeu_video_nombre_joueur_max", type="smallint", nullable=true, options={"unsigned"=true})
     */
    protected $nombreJoueursMaximum;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\Lyssal\CollectionBundle\Entity\Plateforme", inversedBy="jeuxVideo")
     * @ORM\JoinTable
     * (
     *  name="lyssal_collection_jeu_video_a_plateforme",
     *  joinColumns={@ORM\JoinColumn(name="jeu_video_id", referencedColumnName="jeu_video_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="plateforme_id", referencedColumnName="plateforme_id", onDelete="CASCADE")}
     * )
     */
    protected $plateformes;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->plateformes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set element
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $element
     * @return JeuVideo
     */
    public function setElement(\Lyssal\CollectionBundle\Entity\Element $element)
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
     * Set triche
     *
     * @param string $triche
     * @return JeuVideo
     */
    public function setTriche($triche)
    {
        $this->triche = $triche;
    
        return $this;
    }
    
    /**
     * Get triche
     *
     * @return string
     */
    public function getTriche()
    {
        return $this->triche;
    }
    
    /**
     * Set multijoueur
     *
     * @param boolean $multijoueur
     * @return JeuVideo
     */
    public function setMultijoueur($multijoueur)
    {
        $this->multijoueur = $multijoueur;
    
        return $this;
    }
    
    /**
     * Get multijoueur
     *
     * @return boolean
     */
    public function getMultijoueur()
    {
        return $this->multijoueur;
    }
    
    /**
     * Set nombreJoueursMaximum
     *
     * @param integer $nombreJoueursMaximum
     * @return JeuVideo
     */
    public function setNombreJoueursMaximum($nombreJoueursMaximum)
    {
        $this->nombreJoueursMaximum = $nombreJoueursMaximum;
    
        return $this;
    }
    
    /**
     * Get nombreJoueursMaximum
     *
     * @return integer
     */
    public function getNombreJoueursMaximum()
    {
        return $this->nombreJoueursMaximum;
    }
    
    /**
     * Add plateformes
     *
     * @param \Lyssal\CollectionBundle\Entity\Plateforme $plateformes
     * @return JeuVideo
     */
    public function addPlateforme(\Lyssal\CollectionBundle\Entity\Plateforme $plateformes)
    {
        $this->plateformes[] = $plateformes;
    
        return $this;
    }
    
    /**
     * Remove plateformes
     *
     * @param \Lyssal\CollectionBundle\Entity\Plateforme $plateformes
     */
    public function removePlateforme(\Lyssal\CollectionBundle\Entity\Plateforme $plateformes)
    {
        $this->plateformes->removeElement($plateformes);
    }
    
    /**
     * Get plateformes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlateformes()
    {
        return $this->plateformes;
    }
}
