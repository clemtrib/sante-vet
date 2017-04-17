<?php

namespace AppBundle\Entity;

/**
 * ProductEntity
 *
 * 
 */
class ProductSearchEntity {

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * Set label
     *
     * @param string $label
     *
     * @return ProductSearchEntity
     */
    public function setLabel($label) {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * Set min
     *
     * @param string $min
     *
     * @return ProductSearchEntity
     */
    public function setMin($min) {
        $this->min = $min;

        return $this;
    }

    /**
     * Get min
     *
     * @return string
     */
    public function getMin() {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     *
     * @return ProductSearchEntity
     */
    public function setMax($max) {
        $this->max = $max;

        return $this;
    }

    /**
     * Get max
     *
     * @return int
     */
    public function getMax() {
        return $this->max;
    }

}
