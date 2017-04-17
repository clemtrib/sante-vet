<?php

namespace AppBundle\Services;

use AppBundle\Entity\ProductEntity as ProductEntity;

/**
 * Service utilisé pour aller récupérer sur www.leboncoin.fr une liste d'articles.
 *
 * @author Clément
 */
class Leboncoin {

    private $em;
    private $productEntities;
    
    /**
     * 
     * @param type $em
     * @return boolean
     */
    public function __construct($em) {
        $this->em = $em;
        return true;
    }

    /**
     * Récupérer sur www.leboncoin.fr une liste d'articles.
     * 
     * @param type $region
     * @param type $category
     * @param type $length
     * @return type
     */
    public function getProductEntities($region, $category, $length) {
        
        $articles = array();
        $page = 1;
        
        while (count($articles) < $length) {
            
            $request_url = "https://www.leboncoin.fr/$category/offres/$region/?o={$page}";
            
            $html = file_get_contents($request_url);
            $html_articles = explode(
                '<li itemscope itemtype="http://schema.org/Offer">', 
                str_replace('</li>', '', trim($html))
            );
            
            for ($i = 1; $i < count($html_articles); $i++) {
                if(count($articles) >= $length){
                    break;
                }
                $articles[] = $this->getDatasInHtmlContainer(
                    $html_articles[$i],
                    $category,
                    $region
                );
            }
            $page++; // on passe à la page suivante si on n'a pas assez de résultats
            
        }

        $this->productEntities = $articles;
        return $this->productEntities;
        
    }
    
    /**
     * Enregistrer une liste d'articles dans notre base de données.
     * 
     * @return boolean
     */
    public function setProductEntities() {
        $em = $this->em;
        if (is_array($this->productEntities) && !empty($this->productEntities)) {
            foreach ($this->productEntities as $productEntity) {
                $em->persist($productEntity);
            }
            $em->flush();
        }
        return true;
    }
    
    /**
     * Résoudre différents problèmes d'encodage
     * @param type $string
     * @return string
     */
    private function format($string) : string {
        return html_entity_decode(utf8_encode(trim($string)));;
    }
    
    /**
     * Récupèrer divers éléments dans un container HTML et les retourne dans un objet.
     * @param type $container
     * @return ProductEntity
     */
    private function getDatasInHtmlContainer($container, $category, $region): ProductEntity {
        
        foreach ($this->getDatasContainerDescription() as $match => $pattern) {
            ${$match} = array();
            preg_match($pattern, $container, ${$match});
        }

        $city = "";
        $dept = "";
        if (isset($place_arr[1]) && is_string($place_arr[1])) {
            $t = explode('/', strip_tags($place_arr[1]));
            $city = $t[0] ?? '';
            $dept = $t[1] ?? '';
        }

        return new ProductEntity(array(
            'ref' => $this->format($ref_arr[1], 1),
            'url' => "https://leboncoin.fr/{$category}/{$this->format($ref_arr[1], 1)}.htm",
            'label' => $this->format($label_arr[1], 0),
            'category' => $category,
            'region' => $region,
            'dept' => $city && $dept ? $this->format($dept, 1) : $this->format($city, 1),
            'city' => $city && $dept ? $this->format($city, 1) : '',
            'price' => isset($price_arr[1]) ? (int) $price_arr[1] : null,
            'visit' => 0
        ));
            
    }
    
    /**
     * Patterns à rechercher et variables à affecter
     * @return array
     */
    private function getDatasContainerDescription(): array {
        return array(
            'label_arr' => '#<h2 class="item_title" itemprop="name">(.*?)</h2>#si',
            'place_arr' => '#<p class="item_supp" itemprop="availableAtOrFrom" itemscope itemtype="http://schema.org/Place">(.*?)</p>#si',
            'price_arr' => '#<h3 class="item_price" itemprop="price" content="(.*?)">(.*?)</h3>#si',
            'ref_arr' => '#<div title="" class="saveAd" data-savead-id="(.*?)">(.*?)</div>#si'
        );
    }

}
