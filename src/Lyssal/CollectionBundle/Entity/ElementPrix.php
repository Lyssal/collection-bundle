<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Prix d'un élément.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class ElementPrix
{
    /**
     * @var integer
     *
     * @ORM\Column(name="element_a_prix_id", type="bigint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     * 
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementPrix")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Pays
     * 
     * @ORM\ManyToOne(targetEntity="\Lyssal\GeographieBundle\Entity\Pays", inversedBy="elementPrix")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=false, onDelete="CASCADE")
     */
    protected $pays;
    
    /**
     * @var \Lyssal\MonnaieBundle\Entity\Monnaie
     * 
     * @ORM\ManyToOne(targetEntity="\Lyssal\MonnaieBundle\Entity\Monnaie", inversedBy="elementPrix")
     * @ORM\JoinColumn(name="monnaie_id", referencedColumnName="monnaie_id", nullable=false, onDelete="CASCADE")
     */
    protected $monnaie;
    
    /**
     * @var number
     * 
     * @ORM\Column(name="element_prix", type="decimal", nullable=false, precision=7, scale=2)
     */
    protected $prix;

    
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
     * @return ElementPrix
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
     * @return ElementPrix
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
     * Set monnaie
     *
     * @param \Lyssal\MonnaieBundle\Entity\Monnaie $monnaie
     * @return ElementPrix
     */
    public function setMonnaie(\Lyssal\MonnaieBundle\Entity\Monnaie $monnaie)
    {
        $this->monnaie = $monnaie;

        return $this;
    }

    /**
     * Get monnaie
     *
     * @return \Lyssal\MonnaieBundle\Entity\Monnaie 
     */
    public function getMonnaie()
    {
        return $this->monnaie;
    }

    /**
     * Set prix
     *
     * @param float $prix
     * @return ElementPrix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->prix.' '.$this->monnaie->getCode();
    }
}
