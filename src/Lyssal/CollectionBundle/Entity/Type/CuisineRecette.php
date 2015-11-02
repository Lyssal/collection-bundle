<?php
namespace Lyssal\CollectionBundle\Entity\Type;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Recette de cuisine.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass()
 */
abstract class CuisineRecette implements Translatable, TranslatableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="recette_cuisine_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Lyssal\CollectionBundle\Entity\Element
     *
     * @ORM\OneToOne(targetEntity="\Lyssal\CollectionBundle\Entity\Element", inversedBy="cuisineRecette", cascade={"persist"})
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var string
     * @Gedmo\Locale()
     */
    protected $locale;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="recette_cuisine_ingredients", type="text", nullable=true)
     * @Gedmo\Translatable()
     */
    protected $ingredients;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="recette_cuisine_preparation_temps", type="smallint", nullable=true, options={"unsigned"=true})
     */
    protected $preparationTemps;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="recette_cuisine_nombre_personnes", type="smallint", nullable=true, options={"unsigned"=true})
     */
    protected $nombrePersonnes;

    
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
     * @return CuisineRecette
     */
    public function setElement(\CollectoLys\CollectionBundle\Entity\Element $element)
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
     * Set ingredients
     *
     * @param string $ingredients
     * @return CuisineRecette
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    
        return $this;
    }
    
    /**
     * Get ingredients
     *
     * @return string
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
    
    /**
     * Set preparationTemps
     *
     * @param integer $preparationTemps
     * @return CuisineRecette
     */
    public function setPreparationTemps($preparationTemps)
    {
        $this->preparationTemps = $preparationTemps;
    
        return $this;
    }
    
    /**
     * Get preparationTemps
     *
     * @return integer
     */
    public function getPreparationTemps()
    {
        return $this->preparationTemps;
    }
    
    /**
     * Set nombrePersonnes
     *
     * @param integer $nombrePersonnes
     * @return CuisineRecette
     */
    public function setNombrePersonnes($nombrePersonnes)
    {
        $this->nombrePersonnes = $nombrePersonnes;
    
        return $this;
    }
    
    /**
     * Get nombrePersonnes
     *
     * @return integer
     */
    public function getNombrePersonnes()
    {
        return $this->nombrePersonnes;
    }
}
