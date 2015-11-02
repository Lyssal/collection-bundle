<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Élément a société.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class ElementSociete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="element_a_societe_id", type="bigint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     * 
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementSocietes")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=true, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Societe
     * 
     * @ORM\ManyToOne(targetEntity="Societe", inversedBy="elementSocietes")
     * @ORM\JoinColumn(name="societe_id", referencedColumnName="societe_id", nullable=false, onDelete="CASCADE")
     */
    protected $societe;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\SocieteRole
     * 
     * @ORM\ManyToOne(targetEntity="SocieteRole", inversedBy="elementSocietes")
     * @ORM\JoinColumn(name="societe_role_id", referencedColumnName="societe_role_id", nullable=false, onDelete="CASCADE")
     */
    protected $societeRole;

    
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
     * @return ElementSociete
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
     * Set societe
     *
     * @param \Lyssal\CollectionBundle\Entity\Societe $societe
     * @return ElementSociete
     */
    public function setSociete(\Lyssal\CollectionBundle\Entity\Societe $societe = null)
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * Get societe
     *
     * @return \Lyssal\CollectionBundle\Entity\Societe 
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * Set societeRole
     *
     * @param \Lyssal\CollectionBundle\Entity\SocieteRole $societeRole
     * @return ElementSociete
     */
    public function setSocieteRole(\Lyssal\CollectionBundle\Entity\SocieteRole $societeRole = null)
    {
        $this->societeRole = $societeRole;

        return $this;
    }

    /**
     * Get societeRole
     *
     * @return \Lyssal\CollectionBundle\Entity\SocieteRole 
     */
    public function getSocieteRole()
    {
        return $this->societeRole;
    }
}
