<?php
namespace Lyssal\CollectionBundle\Entity\Type;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livre.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Livre
{
    /**
     * @var integer
     *
     * @ORM\Column(name="livre_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\OneToOne(targetEntity="\Lyssal\CollectionBundle\Entity\Element", inversedBy="livre", cascade={"persist"})
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="livre_nombre_pages", type="smallint", nullable=true, options={"unsigned"=true})
     */
    protected $nombrePages;
    
    
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
     * @return Livre
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
     * Set nombrePages
     *
     * @param integer $nombrePages
     * @return Livre
     */
    public function setNombrePages($nombrePages)
    {
        $this->nombrePages = $nombrePages;
    
        return $this;
    }
    
    /**
     * Get nombrePages
     *
     * @return integer
     */
    public function getNombrePages()
    {
        return $this->nombrePages;
    }
}
