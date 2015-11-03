<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ÉlémentSupport a langue.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class ElementSupportLangue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="element_a_support_a_langue_id", type="bigint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\ElementSupport
     *
     * @ORM\ManyToOne(targetEntity="ElementSupport", inversedBy="langues")
     * @ORM\JoinColumn(name="element_a_support_id", referencedColumnName="element_a_support_id", nullable=false, onDelete="CASCADE")
     */
    protected $elementSupport;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Langue
     *
     * @ORM\ManyToOne(targetEntity="Lyssal\GeographieBundle\Entity\Langue", inversedBy="elementSupportLangues")
     * @ORM\JoinColumn(name="langue_id", referencedColumnName="langue_id", nullable=false, onDelete="CASCADE")
     */
    protected $langue;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\SupportLangageType
     *
     * @ORM\ManyToOne(targetEntity="SupportLangageType", inversedBy="elementSupportLangues")
     * @ORM\JoinColumn(name="support_langage_type_id", referencedColumnName="support_langage_type_id", nullable=false, onDelete="CASCADE")
     */
    protected $type;

    
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
     * @param \Lyssal\CollectionBundle\Entity\ElementSupport $element
     * @return ElementSupportLangue
     */
    public function setElementSupport(\Lyssal\CollectionBundle\Entity\ElementSupport $elementSupport)
    {
        $this->elementSupport = $elementSupport;

        return $this;
    }

    /**
     * Get elementSupport
     *
     * @return \Lyssal\CollectionBundle\Entity\ElementSupport 
     */
    public function getElementSupport()
    {
        return $this->elementSupport;
    }

    /**
     * Set langue
     *
     * @param \Lyssal\GeographieBundle\Entity\Langue $langue
     * @return ElementSupportLangue
     */
    public function setLangue(\Lyssal\GeographieBundle\Entity\Langue $langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return \Lyssal\GeographieBundle\Entity\Langue 
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Set type
     *
     * @param \Lyssal\CollectionBundle\Entity\SupportLangageType $type
     * @return ElementSupportLangue
     */
    public function setType(\Lyssal\CollectionBundle\Entity\SupportLangageType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Lyssal\CollectionBundle\Entity\SupportLangageType 
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->elementSupport->__toString().' ('.$this->langue->__toString().')';
    }
}
