<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Services;

use AppBundle\Entity\ProductEntity as ProductEntity;

/**
 * Description of Leboncoin
 *
 * @author Clément
 */
class Leboncoin {

    private $em;
    private $url;
    private $productEntities;
    
    /**
     * 
     * @param type $url
     * @return boolean
     */
    public function __construct($em, $url) {
        $this->em = $em;
        $this->_url = $url;
        return true;
    }

    /**
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
            
            $request_url = "http://www.leboncoin.fr/$category/offres/$region/?o={$page}";
            $html = file_get_contents($request_url);
        
            
            $html_articles = explode(
                '<li itemscope itemtype="http://schema.org/Offer">', 
                str_replace('</li>', '', trim($html))
            );
            
            for ($i = 1; $i < count($html_articles); $i++) {
                
                if(count($articles) >= 100){
                    break;
                }
                
                $d = $html_articles[$i];
                preg_match('#<h2 class="item_title" itemprop="name">(.*?)</h2>#si', $d, $label_arr);
                preg_match('#<p class="item_supp" itemprop="availableAtOrFrom" itemscope itemtype="http://schema.org/Place">(.*?)</p>#si', $d, $place_arr);
                preg_match('#<h3 class="item_price" itemprop="price" content="(.*?)">(.*?)</h3>#si', $d, $price_arr);
                preg_match('#<div title="" class="saveAd" data-savead-id="(.*?)">(.*?)</div>#si', $d, $ref_arr);
                
                $city = "";
                $dept = "";
                if(isset($place_arr[1]) && is_string($place_arr[1])) { 
                    $t = explode('/', strip_tags($place_arr[1]));
                    $city = $t[0] ?? '';
                    $dept = $t[1] ?? '';
                }
                
                $articles[] = new ProductEntity(array(
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
            
            $page++;
            
        }

        $this->productEntities = $articles;
        
        return $this->productEntities;
        
    }
    
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
     * 
     * @param type $string
     * @return string
     */
    private function format($string, $mode) : string {
        
        switch($mode) {
            case 0:
                $string = trim(html_entity_decode($string));
                break;
            default:
            case 1:
                $string = utf8_encode(trim($string));
                break;
        }
        return $string;
    }

}
