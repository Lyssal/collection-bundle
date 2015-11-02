<?php
namespace Lyssal\CollectionBundle\Entity\Type;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logiciel.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class Logiciel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="logiciel_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\OneToOne(targetEntity="\Lyssal\CollectionBundle\Entity\Element", inversedBy="logiciel", cascade={"persist"})
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\Lyssal\CollectionBundle\Entity\Plateforme", inversedBy="logiciels")
     * @ORM\JoinTable
     * (
     *  name="lyssal_collection_logiciel_a_plateforme",
     *  joinColumns={@ORM\JoinColumn(name="logiciel_id", referencedColumnName="logiciel_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="plateforme_id", referencedColumnName="plateforme_id", onDelete="CASCADE")}
     * )
     */
    protected $plateformes;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->plateformes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set element
     *
     * @param \Lyssal\CollectionBundle\Entity\Element $element
     * @return Logiciel
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
     * Add plateformes
     *
     * @param \Lyssal\CollectionBundle\Entity\Plateforme $plateformes
     * @return Logiciel
     */
    public function addPlateforme(\Lyssal\CollectionBundle\Entity\Plateforme $plateformes)
    {
        $this->plateformes[] = $plateformes;
    
        return $this;
    }
    
    /**
     * Remove plateformes
     *
     * @param \Lyssal\CollectionBundle\Entity\Plateforme $plateformes
     */
    public function removePlateforme(\Lyssal\CollectionBundle\Entity\Plateforme $plateformes)
    {
        $this->plateformes->removeElement($plateformes);
    }
    
    /**
     * Get plateformes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlateformes()
    {
        return $this->plateformes;
    }
}
