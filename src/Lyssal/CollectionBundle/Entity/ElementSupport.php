<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Élément a support.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class ElementSupport
{
    /**
     * @var integer
     *
     * @ORM\Column(name="element_a_support_id", type="bigint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="utilisateur_id", type="integer", nullable=false, options={"unsigned":true})
     */
    protected $utilisateur;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementSupports", cascade={"persist"})
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Support
     *
     * @ORM\ManyToOne(targetEntity="Support", inversedBy="elementSupports")
     * @ORM\JoinColumn(name="support_id", referencedColumnName="support_id", nullable=true, onDelete="CASCADE")
     */
    protected $support;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\UtilisateurSupport
     *
     * @ORM\ManyToOne(targetEntity="UtilisateurSupport", inversedBy="elementSupports")
     * @ORM\JoinColumn(name="utilisateur_support_id", referencedColumnName="utilisateur_support_id", nullable=true, onDelete="CASCADE")
     */
    protected $utilisateurSupport;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="element_version", type="text", length=32, nullable=true)
     */
    protected $version;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="element_commentaire", type="text", nullable=true)
     */
    protected $commentaire;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="element_derniere_utilisation", type="date", nullable=true)
     */
    protected $derniereUtilisation;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="ElementSupportLangue", mappedBy="elementSupport", cascade={"persist"})
     */
    protected $langues;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->langues = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set utilisateur
     *
     * @param object $utilisateur
     * @return ElementSupport
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return object
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set element
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $element
     * @return ElementSupport
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
     * Set support
     *
     * @param \Lyssal\CollectionBundle\Entity\Support $support
     * @return ElementSupport
     */
    public function setSupport(\Lyssal\CollectionBundle\Entity\Support $support = null)
    {
        $this->support = $support;

        return $this;
    }

    /**
     * Get support
     *
     * @return \Lyssal\CollectionBundle\Entity\Support 
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Set utilisateurSupport
     *
     * @param \Lyssal\CollectionBundle\Entity\UtilisateurSupport $utilisateurSupport
     * @return ElementSupport
     */
    public function setUtilisateurSupport(\Lyssal\CollectionBundle\Entity\UtilisateurSupport $utilisateurSupport = null)
    {
        $this->utilisateurSupport = $utilisateurSupport;

        return $this;
    }

    /**
     * Get utilisateurSupport
     *
     * @return \Lyssal\CollectionBundle\Entity\UtilisateurSupport 
     */
    public function getUtilisateurSupport()
    {
        return $this->utilisateurSupport;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return ElementSupport
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return ElementSupport
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set derniereUtilisation
     *
     * @param string $derniereUtilisation
     * @return ElementSupport
     */
    public function setDerniereUtilisation($derniereUtilisation)
    {
        $this->derniereUtilisation = $derniereUtilisation;
    
        return $this;
    }
    
    /**
     * Get derniereUtilisation
     *
     * @return string
     */
    public function getDerniereUtilisation()
    {
        return $this->derniereUtilisation;
    }
    
    /**
     * Add langues
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupportLangue $langue
     * @return ElementSupport
     */
    public function addLangue(\Lyssal\CollectionBundle\Entity\ElementSupportLangue $langue)
    {
        if (null === $langue->getElementSupport())
            $langue->setElementSupport($this);
        
        $this->langues[] = $langue;
    
        return $this;
    }
    
    /**
     * Remove langues
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupportLangue $langue
     */
    public function removeLangue(\Lyssal\CollectionBundle\Entity\ElementSupportLangue $langue)
    {
        $this->langues->removeElement($langue);
    }
    
    /**
     * Get langues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLangues()
    {
        return $this->langues;
    }

    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->element->__toString().(null !== $this->support ? ' ('.$this->support->__toString().')' : (null !== $this->utilisateurSupport ? ' ('.$this->utilisateurSupport->__toString().')' : ''));
    }
}
