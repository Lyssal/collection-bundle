<?php
namespace Lyssal\CollectionBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Lyssal\CollectionBundle\Entity\Type;
use Lyssal\StructureBundle\Repository\EntityRepository;

/**
 * Manager de l'entité Support.
 * 
 * @author Rémi Leclerc
 */
class SupportManager extends Manager
{
    /**
     * @var mixed Utilisateur connecté
     */
    protected $user;
    
    /**
     * Constructeur.
     * 
     * @param \Doctrine\ORM\EntityManagerInterface                      $entityManager   EntityManager
     * @param string                                                    $class           Classe de l'entité
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext SecurityContext
     */
    public function __construct(EntityManagerInterface $entityManager, $class, SecurityContextInterface $securityContext)
    {
        parent::__construct($entityManager, $class);
        
        $this->user = (null !== $securityContext->getToken() && is_object($securityContext->getToken()->getUser()) ? $securityContext->getToken()->getUser() : null);
    }
    
    
    /**
     * Retourne les supports d'un type.
     * 
     * @param \Lyssal\CollectionBundle\Entity\Type $type Type
     * @return \Lyssal\CollectionBundle\Entity\Support[] Supports
     */
    public function findByType(Type $type)
    {
        return $this->findBy
        (
            array('type' => $type),
            array('slug' => 'ASC'),
            null,
            null,
            array
            (
            	EntityRepository::SELECTS => array
                (
                	'type' => EntityRepository::SELECT_JOIN
                ),
                EntityRepository::INNER_JOINS => array
                (
                	'types' => 'type'
                )
            )
        );
    }
    
    /**
     * Retourne les supports de l'utilisateur pour un type.
     * 
     * @todo Utilisateur connecté
     * @param \Lyssal\CollectionBundle\Entity\Type $type Type
     * @return \Lyssal\CollectionBundle\Entity\Support[] Supports
     */
    public function findByTypeAndUser(Type $type)
    {
        if (null === $this->user)
            return array();
            
        return $this->findBy
        (
            array('type' => $type, 'elementSupport.utilisateur' => $this->user->getId()),
            array('nom' => 'ASC'),
            null,
            null,
            array
            (
                EntityRepository::INNER_JOINS => array
                (
        	        'entity.types' => 'type',
        	        'entity.elementSupports' => 'elementSupport'
                )
            )
        );
    }
}
