<?php
namespace Lyssal\CollectionBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;
use Lyssal\CollectionBundle\Entity\Type;
use Lyssal\StructureBundle\Repository\EntityRepository;

/**
 * Manager de l'entité UtilisateurSupport.
 * 
 * @author Rémi Leclerc
 */
class UtilisateurSupportManager extends Manager
{
    /**
     * Retourne les supports utilisateur d'un type.
     * 
     * @param \Lyssal\CollectionBundle\Entity\Type $type Type
     * @return \Lyssal\CollectionBundle\Entity\UtilisateurSupport[] Supports utilisateur
     */
    public function findByType(Type $type)
    {
        return $this->findBy
        (
	        array('type' => $type),
            array('nom' => 'ASC'),
            null,
            null,
            array
            (
                EntityRepository::SELECTS => array
                (
                	'support' => EntityRepository::SELECT_JOIN,
                	'type' => EntityRepository::SELECT_JOIN
                ),
            	EntityRepository::INNER_JOINS => array
                (
                	'entity.support' => 'support',
                    'support.types' => 'type'
                )
            )
        );
    }
}
