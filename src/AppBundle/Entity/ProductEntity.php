<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductEntity
 *
 * @ORM\Table(name="product_entity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductEntityRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=64, unique=true)
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;
    
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=128, nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=128, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="dept", type="string", length=128, nullable=true)
     */
    private $dept;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=128, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=18, scale=6, nullable=true)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @var int
     *
     * @ORM\Column(name="visit", type="integer")
     */
    private $visit;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ref
     *
     * @param string $ref
     *
     * @return ProductEntity
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }
    
    /**
     * Set label
     *
     * @param string $label
     *
     * @return ProductDetailEntity
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ProductDetailEntity
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return ProductEntity
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return ProductEntity
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set dept
     *
     * @param string $dept
     *
     * @return ProductEntity
     */
    public function setDept($dept)
    {
        $this->dept = $dept;

        return $this;
    }

    /**
     * Get dept
     *
     * @return string
     */
    public function getDept()
    {
        return $this->dept;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return ProductEntity
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return ProductEntity
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @ORM\PrePersist
     * 
     * @return ProductEntity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $updatedAt
     * 
     * @ORM\PreUpdate
     *
     * @return ProductEntity
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set visit
     *
     * @param integer $visit
     *
     * @return ProductDetailEntity
     */
    public function setVisit($visit)
    {
        $this->visit = $visit;

        return $this;
    }

    /**
     * Get visit
     *
     * @return int
     */
    public function getVisit()
    {
        return $this->visit;
    }
    
    /**
     * 
     * @param array $datas
     * @return bool
     */
    public function __construct(array $datas) {
        $is_empty = true;
        if (is_array($datas) && !empty($datas)) {
            foreach ($datas as $key => $data) {
                $method = "set" . ucwords(strtolower($key));
                if (method_exists($this, $method)) {
                    $this->$method($data);
                    $is_empty = false;
                }
            }
        }
        return $is_empty;
    }

}

