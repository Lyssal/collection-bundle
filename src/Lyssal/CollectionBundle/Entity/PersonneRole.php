<?php
namespace Lyssal\CollectionBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Rôle de personne.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class PersonneRole implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="personne_role_id", type="smallint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Type
     * 
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="personneRoles")
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
     * @ORM\Column(name="personne_role_nom", type="string", nullable=false, length=32)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @Gedmo\SortablePosition()
     * @ORM\Column(name="personne_role_position", type="smallint", nullable=true)
     */
    protected $position;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementPersonne", mappedBy="personneRole")
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
     * Set type
     *
     * @param \Lyssal\CollectionBundle\Entity\Type $type
     * @return PersonneRole
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
     * @return PersonneRole
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
     * @return PersonneRole
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
     * Add elementPersonnes
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementPersonne $elementPersonnes
     * @return PersonneRole
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
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
