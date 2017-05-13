<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="task")
 */
class Task {
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string",name="description", length=100)
     */
    protected $description;
    /**
     * Many Tasks have Many Tags
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"}, inversedBy="task")
     * @ORM\JoinTable(name="task_tag")
     */
    protected $tags;

    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTags()
    {
        return $this->tags;
    }
    public function addTag(Tag $tag)
    {
        $tag->addTask($this);
        $this->tags->add($tag);
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }
    
}