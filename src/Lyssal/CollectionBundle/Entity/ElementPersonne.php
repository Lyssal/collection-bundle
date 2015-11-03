<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Élément a personne.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class ElementPersonne
{
    /**
     * @var integer
     *
     * @ORM\Column(name="element_a_personne_id", type="bigint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     * 
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementPersonnes")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=true, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Personne
     * 
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="elementPersonnes", cascade={"persist"})
     * @ORM\JoinColumn(name="personne_id", referencedColumnName="personne_id", nullable=false, onDelete="CASCADE")
     */
    protected $personne;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\PersonneRole
     * 
     * @ORM\ManyToOne(targetEntity="PersonneRole", inversedBy="elementPersonnes")
     * @ORM\JoinColumn(name="personne_role_id", referencedColumnName="personne_role_id", nullable=false, onDelete="CASCADE")
     */
    protected $personneRole;
    
    /**
     * @var string
     *
     * @ORM\Column(name="personne_details", type="string", length=128, nullable=true)
     */
    protected $details;
    
    /**
     * @ORM\Column(name="personne_position", type="integer", nullable=true)
     * @Gedmo\SortablePosition()
     */
    private $position;

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
     * @return ElementPersonne
     */
    public function setElement(\Lyssal\CollectionBundle\Entity\Element $element = null)
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
     * Set personne
     *
     * @param \Lyssal\CollectionBundle\Entity\Personne $personne
     * @return ElementPersonne
     */
    public function setPersonne(\Lyssal\CollectionBundle\Entity\Personne $personne = null)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \Lyssal\CollectionBundle\Entity\Personne 
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set personneRole
     *
     * @param \Lyssal\CollectionBundle\Entity\PersonneRole $personneRole
     * @return ElementPersonne
     */
    public function setPersonneRole(\Lyssal\CollectionBundle\Entity\PersonneRole $personneRole = null)
    {
        $this->personneRole = $personneRole;

        return $this;
    }

    /**
     * Get personneRole
     *
     * @return \Lyssal\CollectionBundle\Entity\PersonneRole 
     */
    public function getPersonneRole()
    {
        return $this->personneRole;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return ElementPersonne
     */
    public function setDetails($details)
    {
        $this->details = $details;
    
        return $this;
    }
    
    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return ElementPersonne
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
}
