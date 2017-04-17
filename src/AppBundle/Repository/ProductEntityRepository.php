<?php

namespace AppBundle\Repository;

/**
 * ProductEntityRepository
 *
 * 
 */
class ProductEntityRepository extends \Doctrine\ORM\EntityRepository
{
 
    /**
     * 
     * @param String $orderby
     * @param String $name
     * @param int $min
     * @param int $max
     * @return type
     */
    public function findAllOrderBy($orderby, $name, $min, $max) {
        
        $dql1 = <<<DQL
            SELECT p 
            FROM AppBundle:ProductEntity p
            WHERE p.{$orderby} IS NOT NULL
DQL;
        $dql2 = <<<DQL
            SELECT p 
            FROM AppBundle:ProductEntity p
            WHERE p.{$orderby} IS NULL
DQL;
        
        // On filtre les résultats et on les ordonne
        if ($name) {
            $nameArr = explode(' ', $name);
            foreach ($nameArr as $name) {
                $dql1 .= $name ? " AND p.label LIKE '%{$name}%' " : '';
                $dql2 .= $name ? " AND p.label LIKE '%{$name}%' " : '';
            }
        }
        $dql1 .= $min ? " AND p.price >= {$min} " : '';
        $dql1 .= $max ? " AND p.price <= {$max} " : '';
        $dql1 .= " ORDER BY p.{$orderby}";
        $dql2 .= " ORDER BY p.{$orderby}";
        
        // On récupère les articles pour lesquelles les prix sont indiqués...
        $wp1 = $this
            ->getEntityManager()
            ->createQuery($dql1)
            ->getResult();
        
        // ...puis ceux pour lesquels les prix ne le sont pas
        $wp2 = $this
            ->getEntityManager()
            ->createQuery($dql2)
            ->getResult();
        
        // On retourne le tout
        return array_merge($wp1, $wp2);
    }
    
}
