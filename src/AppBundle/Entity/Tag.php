<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag {
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string",name="name", length=100)
     */
    protected $name;
    // ...
    /**
     * Many Groups have Many Users.
     * @ORM\ManyToMany(targetEntity="Task", mappedBy="tag")
     */
    protected $task;
    
    public function __construct() {
        $this->task = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
   
    public function setName($name)
    {
        $this->name = $name;
    }
    public function addTask(Task $task)
    {
    if (!$this->task->contains($task)) {
        $this->task->add($task);
    }
    }
}