<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="test")
 */
class Test
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string",name="taskname", length=100,nullable=true)
     */
    protected $taskname;
    
    /**
     * @ORM\Column(type="datetime",name="dueDate",nullable=true)
     */
    protected $dueDate;

    function getId() {
        return $this->id;
    }

    function getTaskname() {
        return $this->taskname;
    }

    function getDueDate() {
        return $this->dueDate;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTaskname($taskname) {
        $this->taskname = $taskname;
    }

    function setDueDate($dueDate) {
        $this->dueDate = $dueDate;
    }

}