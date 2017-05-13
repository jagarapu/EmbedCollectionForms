<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Test;
use AppBundle\Entity\Task;
use AppBundle\Entity\Tag;
use AppBundle\Form\Type\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Collections\ArrayCollection;

class DefaultController extends Controller
{
    /**   
     * @Route("/", name="homepage")   
     */  
    public function newAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $test = new Test();
        $test->setTaskname('Write a blog post');
        $test->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($test)
            ->add('taskname', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();
         $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        $test = $form->getData();
        // ... perform some action, such as saving the task to the database
         //for example, if Task is a Doctrine entity, save it!
         $em = $this->getDoctrine()->getManager();
         $em->persist($test);
         $em->flush();

        return new Response(
            'Task Saved Successfully'
        );  
    }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

 /**
   * @Route("/embforms", name="embforms")
   */
 public function TaskAction(Request $request)
    {
        $task = new Task();
        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $tag1 = new Tag();
        $tag1->setName('tag1');
        $task->getTags()->add($tag1);
        $tag2 = new Tag();
        $tag2->setName('tag2');
        $task->getTags()->add($tag2);
        // end dummy code
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
         $task = $form->getData();
         $em = $this->getDoctrine()->getManager();
         $em->persist($task);
         //without using cascade then it helps to persist
//         foreach ($task->getTags() as $tags) {
//            $em->persist($tags);
//         }
         $em->flush();
         
        return new Response(
            'Task Saved Successfully'
        );     
        }

        return $this->render('Task/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/editaction", name="editaction")
     */
    public function editAction($id=2, Request $request)
    {
    $em = $this->getDoctrine()->getManager();
    $task = $em->getRepository('AppBundle:Task')->find($id);

    if (!$task) {
        throw $this->createNotFoundException('No task found for id '.$id);
    }

    $originalTags = new ArrayCollection();

    // Create an ArrayCollection of the current Tag objects in the database
    foreach ($task->getTags() as $tag) {
        $originalTags->add($tag);
    }

    $editForm = $this->createForm(TaskType::class, $task);

    $editForm->handleRequest($request);

    if ($editForm->isValid()) {

        // remove the relationship between the tag and the Task
        foreach ($originalTags as $tag) {
            if (false === $task->getTags()->contains($tag)) {
                // remove the Task from the Tag
                $tag->getTasks()->removeElement($task);
                // if it was a many-to-one relationship, remove the relationship like this
                // $tag->setTask(null);
                $em->persist($tag);
                // if you wanted to delete the Tag entirely, you can also do that
                // $em->remove($tag);
            }
        }
        $em->persist($task);
        $em->flush();
        // redirect back to some edit page
        return $this->redirectToRoute('editaction', array('id' => $id));
    }

    return $this->render('Task/new.html.twig', array(
            'form' => $editForm->createView(),
        ));
}
}   


    /**   
     * @Route("/random", name="random")   
     */
    function random_string($length=9) {
    $key = '';
    $keys = array_merge(range('A', 'Z')); //if it wants numbers range(0, 9),

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
  // return $key;
    return  new Response('Random string is:  '.$key);    
}
  /**
   * @Route("/random1", name="random1")
   */
    function Mnemonic($letters = 9){
    $result = null;
    $charset = array
    (       
        0 => array('A', 'B', 'C', 'D','E', 'F', 'G', 'H','I', 'J', 'K', 'L', 'M', 'N','O', 'P', 'Q', 'R', 'S', 'T','U', 'V', 'W', 'X', 'Y', 'Z'),
       // 1 => array('a', 'b', 'c', 'd','e', 'f', 'g', 'h','i', 'j', 'k', 'l', 'm', 'n','o', 'p', 'q', 'r', 's', 't','u', 'v', 'w', 'x', 'y', 'z'),
       );

    for ($i = 0; $i < $letters; $i++)
    {
        $result .= $charset[$i % 1][array_rand($charset[$i % 1])];       
    } 

    //return $result;
    return new Response('Random String is:   '.$result);
}
/**
   * @Route("/random2", name="random2")
   */
function generateRandomString($length = 9) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    } 
    //return $randomString;
    return new Response('Random String is:   '.$randomString);
 }