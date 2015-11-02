<?php
namespace Lyssal\CollectionBundle\Entity\Type;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audio.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Audio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="audio_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\OneToOne(targetEntity="\Lyssal\CollectionBundle\Entity\Element", inversedBy="audio", cascade={"persist"})
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="audio_duree", type="smallint", nullable=true, options={"unsigned"=true})
     */
    protected $duree;
    
    
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
     * @return Audio
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
     * Set duree
     *
     * @param integer $duree
     * @return Audio
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    
        return $this;
    }
    
    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree()
    {
        return $this->duree;
    }
}
