<?php
namespace Lyssal\CollectionBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Rôle de société.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class SocieteRole implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="societe_role_id", type="smallint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Type
     * 
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="societeRoles")
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
     * @ORM\Column(name="societe_role_nom", type="string", nullable=false, length=32)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @Gedmo\SortablePosition()
     * @ORM\Column(name="societe_role_position", type="smallint", nullable=true)
     */
    protected $position;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementSociete", mappedBy="societeRole")
     */
    protected $elementSocietes;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set type
     *
     * @param \Lyssal\CollectionBundle\Entity\Type $type
     * @return SocieteRole
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
     * @return SocieteRole
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
     * Set position
     *
     * @param integer $position
     * @return SocieteRole
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add elementSocietes
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSociete $elementSocietes
     * @return SocieteRole
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
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
