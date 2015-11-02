# LyssalCollectionBundle

Bundle permettant de gérer toutes sortes de collections.


## Entités

Toutes les entités possèdent leur manager et leur gestion administrative (optionnelle) si vous utilisez Sonata.

Les entités sont :
* Element : Élément d'une collection (par exemple "Les Misérables : Tome 2" ou "Age of Empires")
* Type : Type de collection (par exemple "Audiothèque" ou "Ludothèque")
* ElementGroupe : Groupement d'élément (par exemple "Les aventures de Tintin" ou "La Seconde Guerre Mondiale en couleur")
* Genre : Genre d'un élément (par exemple "Suspense" pour une vidéothèque ou "Polar" pour une bibliothèque)
* Univers : Univers d'un élément (par exemple "Mythologie grecque" ou "Disney")
* Illustration : Image d'un élément, jaquette, etc
* SocieteRole : Rôle de société (par exemple "Studio de développement" pour une ludothèque ou "Éditeur" pour une bibliothèque)
* Société : Société liée à un élément
* Support : Support d'un élément (DVD pour une vidéo, PDF pour un livre, etc)
* ElementSupport : Liaison entre un élément et un utilisateur qui le possède
* SupportLangageType : Par exemple Texte (pour un PDF) ou Audio (pour un DivX) ou les deux (pour une vidéo sous-titrée).
* UtilisateurSupport : Support personnalisé d'un utilisateur (par exemple un meuble pour DVD, une sacoche, etc)

## Utilisation

`LyssalCollectionBundle` utilise `LyssalGeographieBundle`, reportez-vous à sa documentation pour son installation.

Vous devez créer un bundle héritant `LyssalCollectionBundle` :

```php
namespace Acme\CollectionBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeCollectionBundle extends Bundle
{
    public function getParent()
    {
        return 'LyssalCollectionBundle';
    }
}
```

Ensuite, vous devez créer dans votre bundle les entités héritant celles de `LyssalCollectionBundle` et redéfinir certaines propriétés :
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\Element as ElementBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Type de collection.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_element")
 */
class Element extends ElementBase
{
    /**
     * @var \Acme\CollectionBundle\Entity\Illustration
     *
     * @ORM\OneToOne(targetEntity="Illustration", inversedBy="rectoElement", cascade={"persist"})
     * @ORM\JoinColumn(name="illustration_recto_id", referencedColumnName="illustration_id", nullable=true, onDelete="SET NULL")
     */
    protected $illustrationRecto;

    /**
     * @var \Acme\CollectionBundle\Entity\Illustration
     *
     * @ORM\OneToOne(targetEntity="Illustration", inversedBy="versoElement", cascade={"persist"})
     * @ORM\JoinColumn(name="illustration_verso_id", referencedColumnName="illustration_id", nullable=true, onDelete="SET NULL")
     */
    protected $illustrationVerso;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     *
     * @ORM\ManyToMany(targetEntity="Element", inversedBy="enfants")
     * @ORM\JoinTable
     * (
     *  name="lyssal_collection_element_a_element_parent",
     *  joinColumns={@ORM\JoinColumn(name="element_parent_id", referencedColumnName="element_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="element_id", referencedColumnName="element_id", onDelete="CASCADE")}
     * )
     */
    protected $parents;
    
    /**
     * @var \Doctrine\Common\Collections\Collection 
     * 
     * @ORM\ManyToMany(targetEntity="Element", mappedBy="parents")
     */
    protected $enfants;
    
    /**
     * @var \Doctrine\Common\Collections\Collection 
     *
     * @ORM\ManyToMany(targetEntity="\Acme\GeographieBundle\Entity\Pays", inversedBy="elements")
     * @ORM\JoinTable
     * (
     *  name="acme_element_a_origine",
     *  joinColumns={@ORM\JoinColumn(name="element_id", referencedColumnName="element_id", onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", onDelete="CASCADE")}
     * )
     */
    protected $origines;
    
    /**
     * @var \Doctrine\Common\Collections\Collection 
     *
     * @ORM\OneToMany(targetEntity="ElementDate", mappedBy="element", cascade={"persist"}, orphanRemoval=true)
     */
    protected $elementDates;
    
    /**
     * @var \Doctrine\Common\Collections\Collection 
     *
     * @ORM\OneToMany(targetEntity="ElementPrix", mappedBy="element", cascade={"persist"}, orphanRemoval=true)
     */
    protected $elementPrix;
    
    /**
     * @var \Doctrine\Common\Collections\Collection 
     * 
     * @ORM\OneToMany(targetEntity="ElementSociete", mappedBy="element", cascade={"persist"}, orphanRemoval=true)
     */
    protected $elementSocietes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection 
     * 
     * @ORM\OneToMany(targetEntity="ElementPersonne", mappedBy="element", cascade={"persist"}, orphanRemoval=true)
     */
    protected $elementPersonnes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection 
     * 
     * @ORM\OneToMany(targetEntity="Illustration", mappedBy="element", cascade={"persist"}, orphanRemoval=true)
     */
    protected $illustrations;
    
    /**
     * @var \Doctrine\Common\Collections\Collection 
     * 
     * @ORM\OneToMany(targetEntity="ElementSupport", mappedBy="element", cascade={"persist"})
     */
    protected $elementSupports;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\CollectionBundle\Entity\ElementDate as ElementDateBase;

/**
 * Date d'un élément.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_element_a_date", uniqueConstraints={@ORM\UniqueConstraint(name="ELEMENT_PAYS", columns={"element_id", "pays_id"})})
 */
class ElementDate extends ElementDateBase
{
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     * 
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementDates")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Acme\GeographieBundle\Entity\Pays
     * 
     * @ORM\ManyToOne(targetEntity="\Acme\GeographieBundle\Entity\Pays", inversedBy="elementDates")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=false, onDelete="CASCADE")
     */
    protected $pays;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\ElementGroupe as ElementGroupeBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe d'éléments.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_element_groupe")
 */
class ElementGroupe extends ElementGroupeBase
{
    
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\ElementPersonne as ElementPersonneBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Élément a personne.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_element_a_personne")
 */
class ElementPersonne extends ElementPersonneBase
{
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     * 
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementPersonnes")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=true, onDelete="CASCADE")
     */
    protected $element;

    /**
     * @var \Acme\CollectionBundle\Entity\Personne
     * 
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="elementPersonnes", cascade={"persist"})
     * @ORM\JoinColumn(name="personne_id", referencedColumnName="personne_id", nullable=false, onDelete="CASCADE")
     */
    protected $personne;
    
    /**
     * @var \Acme\CollectionBundle\Entity\PersonneRole
     * 
     * @ORM\ManyToOne(targetEntity="PersonneRole", inversedBy="elementPersonnes")
     * @ORM\JoinColumn(name="personne_role_id", referencedColumnName="personne_role_id", nullable=false, onDelete="CASCADE")
     */
    private $personneRole;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\CollectionBundle\Entity\ElementPrix as ElementPrixBase;

/**
 * Prix d'un élément.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_element_a_prix")
 */
class ElementPrix extends ElementPrixBase
{
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     * 
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementPrix")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Acme\GeographieBundle\Entity\Pays
     * 
     * @ORM\ManyToOne(targetEntity="\Acme\GeographieBundle\Entity\Pays", inversedBy="elementPrix")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=false, onDelete="CASCADE")
     */
    protected $pays;
    
    /**
     * @var \Acme\MonnaieBundle\Entity\Monnaie
     * 
     * @ORM\ManyToOne(targetEntity="\Acme\MonnaieBundle\Entity\Monnaie", inversedBy="elementPrix")
     * @ORM\JoinColumn(name="monnaie_id", referencedColumnName="monnaie_id", nullable=false, onDelete="CASCADE")
     */
    protected $monnaie;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\ElementSociete as BaseElementSociete;
use Doctrine\ORM\Mapping as ORM;

/**
 * Élément a société.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_element_a_societe", uniqueConstraints={@ORM\UniqueConstraint(name="ELEMENT_SOCIETE_SOCIETEROLE", columns={"element_id", "societe_id", "societe_role_id"})})
 */
class ElementSociete extends BaseElementSociete
{
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     * 
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementSocietes")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=true, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Societe
     * 
     * @ORM\ManyToOne(targetEntity="Societe", inversedBy="elementSocietes")
     * @ORM\JoinColumn(name="societe_id", referencedColumnName="societe_id", nullable=false, onDelete="CASCADE")
     */
    protected $societe;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\ElementSupport as ElementSupportBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Élément a support.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_element_a_support")
 */
class ElementSupport extends ElementSupportBase
{
    /**
     * // Ceci est un exemple, utilisez l'utilisateur souhaité (LyssalUtilisateur, FOSUser, etc)
     * @var \Acme\UtilisateurBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="\Acme\UtilisateurBundle\Entity\Utilisateur", inversedBy="elementSupports")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $utilisateur;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     *
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="elementSupports", cascade={"persist"})
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=false, onDelete="CASCADE")
     */
    protected $element;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Support
     *
     * @ORM\ManyToOne(targetEntity="Support", inversedBy="elementSupports")
     * @ORM\JoinColumn(name="support_id", referencedColumnName="support_id", nullable=true, onDelete="CASCADE")
     */
    protected $support;
    
    /**
     * @var \Acme\CollectionBundle\Entity\UtilisateurSupport
     *
     * @ORM\ManyToOne(targetEntity="UtilisateurSupport", inversedBy="elementSupports")
     * @ORM\JoinColumn(name="utilisateur_support_id", referencedColumnName="utilisateur_support_id", nullable=true, onDelete="CASCADE")
     */
    protected $utilisateurSupport;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="ElementSupportLangue", mappedBy="elementSupport", cascade={"persist"})
     */
    protected $langues;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\ElementSupportLangue as ElementSupportLangueBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="acme_element_a_support_a_langue")
 */
class ElementSupportLangue extends ElementSupportLangueBase
{
    /**
     * @var \Acme\CollectionBundle\Entity\ElementSupport
     *
     * @ORM\ManyToOne(targetEntity="ElementSupport", inversedBy="langues")
     * @ORM\JoinColumn(name="element_a_support_id", referencedColumnName="element_a_support_id", nullable=false, onDelete="CASCADE")
     */
    protected $elementSupport;
    
    /**
     * @var \Acme\GeographieBundle\Entity\Langue
     *
     * @ORM\ManyToOne(targetEntity="Acme\GeographieBundle\Entity\Langue", inversedBy="elementSupportLangues")
     * @ORM\JoinColumn(name="langue_id", referencedColumnName="langue_id", nullable=false, onDelete="CASCADE")
     */
    protected $langue;
}
```
```
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\Genre as GenreBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Type.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\Entity()
 * @ORM\Table(name="acme_genre")
 */
class Genre extends GenreBase
{
    
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\CollectionBundle\Entity\Illustration as IllustrationBase;

/**
 * Illustration.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_illustration")
 */
class Illustration extends IllustrationBase
{
    /**
     * @var \Acme\CollectionBundle\Entity\Illustration
     * 
     * @ORM\OneToOne(targetEntity="Illustration", inversedBy="originale", cascade={"persist"})
     * @ORM\JoinColumn(name="miniature_id", referencedColumnName="illustration_id", nullable=true, onDelete="CASCADE")
     */
    protected $miniature;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Illustration
     *
     * @ORM\OneToOne(targetEntity="Illustration", mappedBy="miniature")
     */
    protected $originale;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     * 
     * @ORM\OneToOne(targetEntity="Element", mappedBy="illustrationRecto")
     */
    protected $rectoElement;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     * 
     * @ORM\OneToOne(targetEntity="Element", mappedBy="illustrationVerso")
     */
    protected $versoElement;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Element
     *
     * @ORM\ManyToOne(targetEntity="Element", inversedBy="illustrations")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="element_id", nullable=true)
     * @Gedmo\SortableGroup()
     */
    protected $element;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\Personne as PersonneBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Personne.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_personne")
 */
class Personne extends PersonneBase
{
    /**
     * @var \Acme\GeographieBundle\Entity\Pays
     *
     * @ORM\ManyToOne(targetEntity="\Acme\GeographieBundle\Entity\Pays", inversedBy="personnes")
     * @ORM\JoinColumn(name="nationalite_id", referencedColumnName="pays_id", nullable=true, onDelete="SET NULL")
     */
    protected $nationalite;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="ElementPersonne", mappedBy="personne")
     */
    protected $elementPersonnes;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\PersonneRole as PersonneRoleBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * PersonneRole.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_personne_role")
 */
class PersonneRole extends PersonneRoleBase
{
    
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\Plateforme as PlateformeBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Plateforme.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_plateforme")
 */
class Plateforme extends PlateformeBase
{
    
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\Societe as BaseSociete;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Société.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_societe")
 */
class Societe extends BaseSociete
{
    /**
     * @var \Acme\GeographieBundle\Entity\Pays
     *
     * @ORM\ManyToOne(targetEntity="\Acme\GeographieBundle\Entity\Pays", inversedBy="societes")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="pays_id", nullable=true, onDelete="CASCADE")
     */
    protected $pays;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Societe
     * 
     * @ORM\ManyToOne(targetEntity="Societe", inversedBy="enfants")
     * @ORM\JoinColumn(name="societe_parent_id", referencedColumnName="societe_id", nullable=true, onDelete="SET NULL")
     */
    protected $parent;
    
    /**
     * @var array<\Acme\CollectionBundle\Entity\Societe>
     * 
     * @ORM\OneToMany(targetEntity="Societe", mappedBy="parent")
     */
    protected $enfants;
    
    /**
     * @var array<\Acme\CollectionBundle\Entity\ElementSociete>
     * 
     * @ORM\OneToMany(targetEntity="ElementSociete", mappedBy="societe")
     */
    protected $elementSocietes;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\SocieteRole as SocieteRoleBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * SocieteRole.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\Entity()
 * @ORM\Table(name="acme_societe_role")
 */
class SocieteRole extends SocieteRoleBase
{
    
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\CollectionBundle\Entity\Support as SupportBase;

/**
 * Support.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_support")
 */
class Support extends SupportBase
{
    /**
     * @var array<\Acme\CollectionBundle\Entity\ElementSupport>
     *
     * @ORM\OneToMany(targetEntity="ElementSupport", mappedBy="support")
     */
    protected $elementSupports;
    
    /**
     * @var array<\Acme\CollectionBundle\Entity\UtilisateurSupport>
     *
     * @ORM\OneToMany(targetEntity="UtilisateurSupport", mappedBy="support")
     */
    protected $utilisateurSupports;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\SupportLangageType as SupportLangageTypeBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * SupportLangageType.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_support_langage_type")
 */
class SupportLangageType extends SupportLangageTypeBase
{
    
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\Univers as UniversBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Univers.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_univers")
 */
class Univers extends UniversBase
{
    
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\UtilisateurSupport as UtilisateurSupportBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Support personnalisé d'un utilisateur.
 * 
 * @ORM\Entity()
 * @ORM\Table(name="acme_utilisateur_a_support")
 */
class UtilisateurSupport extends UtilisateurSupportBase
{
    /**
     * // Ceci est un exemple, utilisez l'utilisateur souhaité (LyssalUtilisateur, FOSUser, etc)
     * @var \Acme\UtilisateurBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="\Acme\UtilisateurBundle\Entity\Utilisateur", inversedBy="utilisateurSupports")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $utilisateur;
    
    /**
     * @var \Acme\CollectionBundle\Entity\Support
     *
     * @ORM\ManyToOne(targetEntity="Support", inversedBy="utilisateurSupports")
     * @ORM\JoinColumn(name="support_id", referencedColumnName="support_id", nullable=false, onDelete="CASCADE")
     */
    protected $support;
    
    /**
     * @var array<\Acme\CollectionBundle\Entity\ElementSupport>
     * 
     * @ORM\OneToMany(targetEntity="ElementSupport", mappedBy="utilisateurSupport")
     */
    protected $elementSupports;
}
```
```php
namespace Acme\CollectionBundle\Entity;

use Lyssal\CollectionBundle\Entity\Type as TypeBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Type.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\Entity()
 * @ORM\Table(name="acme_type")
 */
class Type extends TypeBase
{
    
}
```

Vous devez également mettre à jour certaines entités de `LyssalGeographieBundle` :
```php
class Pays extends BasePays
{
    /**
     * @var array<\Acme\CollectionBundle\Entity\Element>
     *
     * @ORM\ManyToMany(targetEntity="\Acme\CollectionBundle\Entity\Element", mappedBy="origines")
     */
    private $elements;
    
    /**
     * @var array<\Acme\CollectionBundle\Entity\ElementDate>
     *
     * @ORM\OneToMany(targetEntity="\Acme\CollectionBundle\Entity\ElementDate", mappedBy="pays")
     */
    private $elementDates;
    
    /**
     * @var array<\Acme\CollectionBundle\Entity\ElementPrix>
     *
     * @ORM\OneToMany(targetEntity="\Acme\CollectionBundle\Entity\ElementPrix", mappedBy="pays")
     */
    private $elementPrix;
    
    /**
     * @var array<\Acme\CollectionBundle\Entity\Societe>
     *
     * @ORM\OneToMany(targetEntity="\Acme\CollectionBundle\Entity\Societe", mappedBy="pays")
     */
    private $societes;
    
    /**
     * @var array<\Acme\CollectionBundle\Entity\Personne>
     *
     * @ORM\OneToMany(targetEntity="\Acme\CollectionBundle\Entity\Personne", mappedBy="nationalite")
     */
    private $personnes;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementDates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementPrix = new \Doctrine\Common\Collections\ArrayCollection();
        $this->societes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->personnes = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add elements
     *
     * @param \Acme\CollectionBundle\Entity\Element $elements
     * @return Pays
     */
    public function addElement(\Acme\CollectionBundle\Entity\Element $elements)
    {
        $this->elements[] = $elements;

        return $this;
    }

    /**
     * Remove elements
     *
     * @param \Acme\CollectionBundle\Entity\Element $elements
     */
    public function removeElement(\Acme\CollectionBundle\Entity\Element $elements)
    {
        $this->elements->removeElement($elements);
    }

    /**
     * Get elements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Add elementDates
     *
     * @param \Acme\CollectionBundle\Entity\ElementDate $elementDates
     * @return Pays
     */
    public function addElementDate(\Acme\CollectionBundle\Entity\ElementDate $elementDates)
    {
        $this->elementDates[] = $elementDates;

        return $this;
    }

    /**
     * Remove elementDates
     *
     * @param \Acme\CollectionBundle\Entity\ElementDate $elementDates
     */
    public function removeElementDate(\Acme\CollectionBundle\Entity\ElementDate $elementDates)
    {
        $this->elementDates->removeElement($elementDates);
    }

    /**
     * Get elementDates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElementDates()
    {
        return $this->elementDates;
    }

    /**
     * Add elementPrix
     *
     * @param \Acme\CollectionBundle\Entity\ElementPrix $elementPrix
     * @return Pays
     */
    public function addElementPrix(\Acme\CollectionBundle\Entity\ElementPrix $elementPrix)
    {
        $this->elementPrix[] = $elementPrix;

        return $this;
    }

    /**
     * Remove elementPrix
     *
     * @param \Acme\CollectionBundle\Entity\ElementPrix $elementPrix
     */
    public function removeElementPrix(\Acme\CollectionBundle\Entity\ElementPrix $elementPrix)
    {
        $this->elementPrix->removeElement($elementPrix);
    }

    /**
     * Get elementPrix
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElementPrix()
    {
        return $this->elementPrix;
    }

    /**
     * Add societes
     *
     * @param \Acme\CollectionBundle\Entity\Societe $societes
     * @return Pays
     */
    public function addSociete(\Acme\CollectionBundle\Entity\Societe $societes)
    {
        $this->societes[] = $societes;

        return $this;
    }

    /**
     * Remove societes
     *
     * @param \Acme\CollectionBundle\Entity\Societe $societes
     */
    public function removeSociete(\Acme\CollectionBundle\Entity\Societe $societes)
    {
        $this->societes->removeElement($societes);
    }

    /**
     * Get societes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSocietes()
    {
        return $this->societes;
    }

    /**
     * Add personnes
     *
     * @param \Acme\CollectionBundle\Entity\Personne $personnes
     * @return Pays
     */
    public function addPersonne(\Acme\CollectionBundle\Entity\Personne $personnes)
    {
        $this->personnes[] = $personnes;

        return $this;
    }

    /**
     * Remove personnes
     *
     * @param \Acme\CollectionBundle\Entity\Personne $personnes
     */
    public function removePersonne(\Acme\CollectionBundle\Entity\Personne $personnes)
    {
        $this->personnes->removeElement($personnes);
    }

    /**
     * Get personnes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersonnes()
    {
        return $this->personnes;
    }
}
```
```php
/**
 * Langue.
 * 
 * @ORM\Entity()
 * @ORM\Table
 * (
 *     name="acme_langue"
 * )
 */
class Langue extends \Lyssal\GeographieBundle\Entity\Langue
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Acme\UtilisateurBundle\Entity\Utilisateur", mappedBy="langue")
     */
    protected $utilisateurs;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Acme\CollectionBundle\Entity\ElementSupportLangue", mappedBy="langue")
     */
    protected $elementSupportLangues;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Acme\CollectionBundle\Entity\Traduction\Element", mappedBy="langue")
     */
    protected $traductionElements;
    
    
    /**
     * Constructeur.
     */
    public function __construct()
    {
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elementSupportLangues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->traductionElements = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    /**
     * Add utilisateurs
     *
     * @param \Acme\UtilisateurBundle\Entity\Utilisateur $utilisateurs
     * @return Langue
     */
    public function addUtilisateur(\Acme\UtilisateurBundle\Entity\Utilisateur $utilisateurs)
    {
        $this->utilisateurs[] = $utilisateurs;

        return $this;
    }

    /**
     * Remove utilisateurs
     *
     * @param \Acme\UtilisateurBundle\Entity\Utilisateur $utilisateurs
     */
    public function removeUtilisateur(\Acme\UtilisateurBundle\Entity\Utilisateur $utilisateurs)
    {
        $this->utilisateurs->removeElement($utilisateurs);
    }

    /**
     * Get utilisateurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
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
     * Add traductionElements
     *
     * @param \Acme\CollectionBundle\Entity\Traduction\Element $traductionElements
     * @return Langue
     */
    public function addTraductionElement(\Acme\CollectionBundle\Entity\Traduction\Element $traductionElements)
    {
        $this->traductionElements[] = $traductionElements;

        return $this;
    }

    /**
     * Remove traductionElements
     *
     * @param \Acme\CollectionBundle\Entity\Traduction\Element $traductionElements
     */
    public function removeTraductionElement(\Acme\CollectionBundle\Entity\Traduction\Element $traductionElements)
    {
        $this->traductionElements->removeElement($traductionElements);
    }

    /**
     * Get traductionElements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTraductionElements()
    {
        return $this->traductionElements;
    }
}
```

Vous devez également mettre à jour certaines entités de `LyssalMonnaieBundle` :
```php
class Monnaie extends BaseMonnaie
{
    /**
     * @var array<\Acme\CollectionBundle\Entity\ElementPrix>
     *
     * @ORM\OneToMany(targetEntity="\Acme\CollectionBundle\Entity\ElementPrix", mappedBy="monnaie")
     */
    protected $elementPrix;
}
```

Enfin, vous pouvez également utiliser des compléments à la class `Element` :
* Type\Audio
* Type\Video
* Type\Livre
* Type\Periodique
* Type\Logiciel
* Type\JeuVideo
* Type\RecetteCuisine


Vous devez ensuite redéfinir les paramètres suivants (exemple avec sur `Acme/CollectionBundle/Resources/config/services.xml`) :
```xml
<?xml version="1.0" ?>
<container xmlns="http://symfony.com/schema/dic/services" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <parameters>
        <parameter key="lyssal.collection.entity.societe.class">Acme\CollectionBundle\Entity\Societe</parameter>
        <parameter key="lyssal.collection.entity.societe_role.class">Acme\CollectionBundle\Entity\SocieteRole</parameter>
    </parameters>
</container>
```

## Managers

Les services sont :
* lyssal.collection.manager.element
* lyssal.collection.manager.element_date
* lyssal.collection.manager.element_groupe
* lyssal.collection.manager.element_personne
* lyssal.collection.manager.element_prix
* lyssal.collection.manager.element_societe
* lyssal.collection.manager.element_support
* lyssal.collection.manager.element_support_langue
* lyssal.collection.manager.genre
* lyssal.collection.manager.illustration
* lyssal.collection.manager.personne
* lyssal.collection.manager.personne_role
* lyssal.collection.manager.plateforme
* lyssal.collection.manager.societe
* lyssal.collection.manager.societe_role
* lyssal.collection.manager.support
* lyssal.collection.manager.support_langage_type
* lyssal.collection.manager.type
* lyssal.collection.manager.type.audio
* lyssal.collection.manager.type.cuisine_recette
* lyssal.collection.manager.type.jeu_video
* lyssal.collection.manager.type.livre
* lyssal.collection.manager.type.logiciel
* lyssal.collection.manager.type.periodique
* lyssal.collection.manager.type.video
* lyssal.collection.manager.univers
* lyssal.collection.manager.utilisateur_support






### Exemple d'utilisation

Dans votre contrôleur :

```php
$tousLesTypes = $this->container->get('lyssal.collection.manager.type')->findAll();
```

### Utiliser vos managers hérités de LyssalCollectionBundle

Si vous utilisez vos propres managers héritant des managers de `LyssalCollectionBundle`, vous pouvez redéfinir les paramètres suivants :
* `lyssal.collection.manager.element.class`
* Etc

Exemple en XML :
```xml
<parameters>
    <parameter key="lyssal.collection.manager.element.class">Acme\CollectionBundle\Manager\ElementManager</parameter>
</parameters>
```

## SonataAdmin

Les entités seront automatiquement intégrées à `SonataAdmin` si vous l'avez installé.

Si vous souhaitez redéfinir les classes `Admin`, il suffit de surcharger les paramètres dans `LyssalCollectionBundle\Resources\config\admin.xml`


## Installation

1. Mettez à jour votre `composer.json` :
```json
"require": {
    "lyssal/collection-bundle": "*"
}
```
2. Installez le bundle :
```sh
php composer.phar update
```
3. Mettez à jour `AppKernel.php` :
```php
new Lyssal\CollectionBundle\LyssalCollectionBundle(),
new Acme\CollectionBundle\AcmeCollectionBundle(),
```
4. Configurez votre `config.yml` :
```php
doctrine:
    orm:
        default_repository_class: Lyssal\StructureBundle\Repository\EntityRepository
```
5. Créez les tables en base de données :
```sh
php app/console doctrine:schema:update --force
```

## Twig

### Fonctions

* `lyssal_collection_plateformes()` : Retourne la liste de tous les plateformes
* `lyssal_collection_supports_by_type_and_utilisateur(type)` : Retourne la liste des supports d'élément que possède l'utilisateur pour un type
* `lyssal_collection_utilisateur_supports_by_type_and_utilisateur(type)` : Retourne la liste des supports utilisateur de l'utilisateur pour un type
* `lyssal_collection_types()` : Retourne la liste de tous les types

### Filtres

* `lyssal_collection_elements(nombreElements)` : Retourne les éléments. nombreElements (optionnel) : Nombre d'éléments à récupérer. S'emploi sur un ElementGroupe.
