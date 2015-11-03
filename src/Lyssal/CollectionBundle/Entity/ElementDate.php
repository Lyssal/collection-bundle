<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Date d'un élément.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class ElementDate
{
    /**
     * @var integer
     *
     * @ORM\Column(name="element_a_date_id", type="bigint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     * 
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementDates")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Pays
     * 
     * @ORM\ManyToOne(targetEntity="\Lyssal\GeographieBundle\Entity\Pays", inversedBy="elementDates")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=false, onDelete="CASCADE")
     */
    protected $pays;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="element_annee", type="smallint", nullable=false)
     */
    protected $annee;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="element_date", type="date", nullable=true)
     */
    protected $date;

    
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
     * @return ElementDate
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
     * Set pays
     *
     * @param \Lyssal\GeographieBundle\Entity\Pays $pays
     * @return ElementDate
     */
    public function setPays(\Lyssal\GeographieBundle\Entity\Pays $pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \Lyssal\GeographieBundle\Entity\Pays 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return ElementDate
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ElementDate
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        if (null !== $this->date)
            return $this->date->format('d/m/Y');
        return $this->annee;
    }
}
