<?php
namespace Lyssal\CollectionBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SupportLangageType.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class SupportLangageType implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="support_langage_type_id", type="smallint", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="support_langage_type_nom", type="string", nullable=false, length=16)
     * @Assert\NotBlank()
     * @Gedmo\Translatable()
     */
    protected $nom;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="ElementSupportLangue", mappedBy="type")
     */
    protected $elementSupportLangues;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Type", mappedBy="supportLangageTypeDefaut")
     */
    protected $defautTypes;


    /**
     * Constructeur.
     */
    public function __construct()
    {
        $this->elementSupportLangues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->defautTypes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return SupportLangageType
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
     * Add elementSupportLangues
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupportLangue $elementSupportLangues
     * @return SupportLangageType
     */
    public function addElementSupportLangue(\Lyssal\CollectionBundle\Entity\ElementSupportLangue $elementSupportLangues)
    {
        $this->elementSupportLangues[] = $elementSupportLangues;

        return $this;
    }

    /**
     * Remove elementSupportLangues
     *
     * @param \Lyssal\CollectionBundle\Entity\ElementSupportLangue $elementSupportLangues
     */
    public function removeElementSupportLangue(\Lyssal\CollectionBundle\Entity\ElementSupportLangue $elementSupportLangues)
    {
        $this->elementSupportLangues->removeElement($elementSupportLangues);
    }

    /**
     * Get elementSupportLangues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElementSupportLangues()
    {
        return $this->elementSupportLangues;
    }

    /**
     * Add defautTypes
     *
     * @param \Lyssal\CollectionBundle\Entity\Type $defautTypes
     * @return SupportLangageType
     */
    public function addDefautType(\Lyssal\CollectionBundle\Entity\Type $defautTypes)
    {
        $this->defautTypes[] = $defautTypes;

        return $this;
    }

    /**
     * Remove defautTypes
     *
     * @param \Lyssal\CollectionBundle\Entity\Type $defautTypes
     */
    public function removeDefautType(\Lyssal\CollectionBundle\Entity\Type $defautTypes)
    {
        $this->defautTypes->removeElement($defautTypes);
    }

    /**
     * Get defautTypes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDefautTypes()
    {
        return $this->defautTypes;
    }
    
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}
