<?php
namespace Lyssal\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Support personnalisé d'un utilisateur.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class UtilisateurSupport
{
    /**
     * @var integer
     *
     * @ORM\Column(name="utilisateur_support_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="utilisateur_id", type="integer", nullable=false, options={"unsigned":true})
     */
    protected $utilisateur;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Support
     *
     * @ORM\ManyToOne(targetEntity="Support", inversedBy="utilisateurSupports")
     * @ORM\JoinColumn(name="support_id", referencedColumnName="support_id", nullable=false, onDelete="CASCADE")
     */
    protected $support;
    
    /**
     * @var string
     *
     * @ORM\Column(name="utilisateur_support_nom", nullable=false)
     */
    protected $nom;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementSupport", mappedBy="utilisateurSupport")
     */
    protected $elementSupports;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elementSupports = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return UtilisateurSupport
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
     * Set utilisateur
     *
     * @param object $utilisateur
     * @return UtilisateurSupport
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return object
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set support
     *
     * @param \Lyssal\CollectionBundle\Entity\Support $support
     * @return UtilisateurSupport
     */
    public function setSupport(\Lyssal\CollectionBundle\Entity\Support $support)
    {
        $this->support = $support;

        return $this;
    }

    /**
     * Get support
     *
     * @return \Lyssal\CollectionBundle\Entity\Support 
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Add elementSupports
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports
     * @return UtilisateurSupport
     */
    public function addElementSupport(\Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports)
    {
        $this->elementSupports[] = $elementSupports;

        return $this;
    }

    /**
     * Remove elementSupports
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports
     */
    public function removeElementSupport(\Lyssal\CollectionBundle\Entity\ElementSupport $elementSupports)
    {
        $this->elementSupports->removeElement($elementSupports);
    }

    /**
     * Get elementSupports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElementSupports()
    {
        return $this->elementSupports;
    }
    
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
