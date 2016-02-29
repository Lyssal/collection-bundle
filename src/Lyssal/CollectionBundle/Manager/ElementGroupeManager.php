<?php
namespace Lyssal\CollectionBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;

/**
 * Manager de l'entité ElementGroupe.
 * 
 * @author Rémi Leclerc
 */
class ElementGroupeManager extends Manager
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->findBy(array(), array('nom' => 'ASC'));
    }
}
