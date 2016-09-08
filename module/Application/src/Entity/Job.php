<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Zend\Form\Annotation;
use Application\Entity\Activity;

/**
 * @ORM\Entity
 * @ORM\Table(name="job")
 * @ORM\HasLifecycleCallbacks 
 * @Annotation\Name("job")
 */
class Job
{
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Annotation\Exclude()
     */
    protected $id;
 
    /**
     * @ORM\Column(type="string")
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Attributes({"type":"Zend\Form\Element\Text"})
     * @Annotation\Options({"label":"application.job.title"})     
     */
    protected $title;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"StripTags"})     
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1}})
     * @Annotation\Attributes({"type":"Zend\Form\Element\Textarea"})
     * @Annotation\Options({"label":"application.job.description"})     
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"StripTags"})     
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1}})
     * @Annotation\Attributes({"type":"Zend\Form\Element\Textarea"})
     * @Annotation\Options({"label":"application.job.comments"})     
     */
    protected $comments;

    /**
     * @ORM\Column(type="datetime")
     * @Annotation\Exclude()
     */
    protected $created;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Submit"})
     */
    public $submit;
    
    private $entityOperationType;

    private $entityChangeSet;
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function setEntityOperationType($entityOperationType)
    {
        $this->entityOperationType = $entityOperationType;
    }

    public function getEntityOperationType()
    {
        return $this->entityOperationType;
    }

    public function setEntityChangeSet($entityChangeSet)
    {
        $this->entityChangeSet = $entityChangeSet;
    }

    public function getEntityChangeSet()
    {
        return $this->entityChangeSet;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(LifecycleEventArgs $event)
    {
        $this->setEntityOperationType(Activity::ENTITY_OPERATION_TYPE_UPDATE);
        $this->setEntityChangeSet($event->getEntityChangeSet());
    } 
    
    /**
     * @ORM\PrePersist
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $this->setEntityOperationType(Activity::ENTITY_OPERATION_TYPE_CREATE);
        $this->setEntityChangeSet(null);
    } 
    
}