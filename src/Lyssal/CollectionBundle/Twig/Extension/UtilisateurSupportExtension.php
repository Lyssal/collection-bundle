<?php
namespace Lyssal\CollectionBundle\Twig\Extension;

use Lyssal\StructureBundle\Decorator\DecoratorManager;
use Lyssal\CollectionBundle\Manager\UtilisateurSupportManager;
use Lyssal\CollectionBundle\Entity\Type;
use Lyssal\CollectionBundle\Decorator\TypeDecorator;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Lyssal\StructureBundle\Repository\EntityRepository;

/**
 * Extension Twig pour les supports utilisateur.
 * 
 * @author Rémi Leclerc
 */
class UtilisateurSupportExtension extends \Twig_Extension
{
    /**
     * @var mixed Utilisateur connecté
     */
    protected $user;
    
    /**
     * @var \Lyssal\StructureBundle\Decorator\DecoratorManager DecoratorManager
     */
    protected $decoratorManager;
    
    /**
     * @var \Lyssal\CollectionBundle\Manager\UtilisateurSupportManager UtilisateurSupportManager
     */
    protected $utilisateurSupportManager;
    
    
    /**
     * Constructeur.
     */
    public function __construct(SecurityContextInterface $securityContext, DecoratorManager $decoratorManager, UtilisateurSupportManager $utilisateurSupportManager)
    {
        $this->decoratorManager = $decoratorManager;
        $this->utilisateurSupportManager = $utilisateurSupportManager;
        
        $this->user = (null !== $securityContext->getToken() && is_object($securityContext->getToken()->getUser()) ? $securityContext->getToken()->getUser() : null);
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
       return array
       (
           new \Twig_SimpleFunction('lyssal_collection_utilisateur_supports_by_utilisateur', array($this, 'getUtilisateurSupportsByUser')),
       	   new \Twig_SimpleFunction('lyssal_collection_utilisateur_supports_by_type_and_utilisateur', array($this, 'getUtilisateurSupportsByTypeAndUser'))
       ); 
    }
    

    /**
     * Retourne tous les supports de l'utilisateur connecté.
     *
     * @return \Lyssal\CollectionBundle\Decorator\SupportDecorator[] Supports
     */
    public function getUtilisateurSupportsByUser()
    {
        if (null === $this->user)
            return array();
    
        return $this->decoratorManager->get($this->utilisateurSupportManager->findBy(
            array
            (
                'utilisateur' => $this->user->getId()
            ),
            array
            (
                'support.nom'
            ),
            null,
            null,
            array
            (
                EntityRepository::SELECTS => array
                (
                    'support' => EntityRepository::SELECT_JOIN
                ),
                EntityRepository::INNER_JOINS => array
                (
                    'entity.support' => 'support'
                )
            )
        ));
    }
    
    /**
     * Retourne tous les supports de l'utilisateur connecté pour un type donnée.
     * 
     * @param \Lyssal\CollectionBundle\Entity\Type|\Lyssal\CollectionBundle\Decorator\TypeDecorator Type
     * @return \Lyssal\CollectionBundle\Decorator\SupportDecorator[] Supports
     */
    public function getUtilisateurSupportsByTypeAndUser($type)
    {
        if (!($type instanceof Type) && !($type instanceof TypeDecorator))
            throw new \Exception('Le type passé en paramètre à lyssal_collection_utilisateur_supports_by_type_and_utilisateur doit être de type \Lyssal\CollectionBundle\Entity\Type ou \Lyssal\CollectionBundle\Decorator\TypeDecorator.');

        if (null === $this->user)
            return array();
        
        return $this->decoratorManager->get($this->utilisateurSupportManager->findBy(
            array
            (
                'type' => ($type instanceof Type ? $type : $type->getEntity()),
                'utilisateur' => $this->user->getId()
            ),
            array
            (
            	'support.nom'
            ),
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
        ));
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
       return 'lyssal_collection_utilisateur_support_extension';
    }
}
