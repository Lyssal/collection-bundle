<?php
namespace Lyssal\CollectionBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;

/**
 * Manager de l'entité Societe.
 * 
 * @author Rémi Leclerc
 */
class SocieteManager extends Manager
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->findBy(array(), array('nom' => 'ASC'));
    }
}
