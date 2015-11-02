<?php
namespace Lyssal\CollectionBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;

/**
 * Manager de l'entité Univers.
 * 
 * @author Rémi Leclerc
 */
class UniversManager extends Manager
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Manager\Manager::findAll()
     */
    public function findAll()
    {
        return $this->findBy(array(), array('nom' => 'ASC'));
    }
}
