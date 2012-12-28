<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification de travaux
 * JLM\OfficeBundle\Entity\Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="JLM\OfficeBundle\Entity\TaskRepository")
 */
class Task
{
	/**
	 * @var int $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * Date de création
	 * @var \DateTime
	 *
	 * @ORM\Column(name="open",type="datetime")
	 */
	private $open;
	
	/**
	 * Porte (lien)
	 * @var JLM\ModelBundle\Entity\Door
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
	 */
	private $door;
	
	/**
	 * Type de tache
	 * @var JLM\ModelBundle\Entity\Door
	 * @ORM\ManyToOne(targetEntity="TaskType")
	 */
	private $type;
	
	/**
	 * A faire
	 * @var string
	 *
	 * @ORM\Column(name="todo",type="text")
	 */
	private $todo;
	
	/**
	 * Raccourci vers l'origine de la tache
	 * @var string
	 * 
	 * @ORM\Column(name="url_source",type="text",nullable=true)
	 */
	private $urlSource;
	
	/**
	 * Raccourci vers l'action à effectuer
	 * @var string
	 *
	 * @ORM\Column(name="url_action",type="text",nullable=true)
	 */
	private $urlAction;
	
	/**
	 * Date de création
	 * @var \DateTime
	 *
	 * @ORM\Column(name="close",type="datetime")
	 */
	private $close;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->open = new \DateTime;
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set todo
     *
     * @param string $todo
     * @return Task
     */
    public function setTodo($todo)
    {
        $this->todo = $todo;
    
        return $this;
    }

    /**
     * Get todo
     *
     * @return string 
     */
    public function getTodo()
    {
        return $this->todo;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Task
     */
    public function setUrlSource($url)
    {
        $this->urlSource = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrlSource()
    {
        return $this->urlSource;
    }
    
    /**
     * Set url
     *
     * @param string $url
     * @return Task
     */
    public function setUrlAction($url)
    {
    	$this->urlAction = $url;
    
    	return $this;
    }
    
    /**
     * Get url
     *
     * @return string
     */
    public function getUrlAction()
    {
    	return $this->urlAction;
    }

    /**
     * Set closed
     *
     * @param boolean $close
     * @return Task
     */
    public function setClose($closed = true)
    {
        $this->closed = $closed;
    
        return $this;
    }

    /**
     * Get closed
     *
     * @return boolean 
     */
    public function getClose()
    {
        return $this->close;
    }
    
    /**
     * Is closed
     *
     * @return boolean
     */
    public function isClose()
    {
    	return $this->getClose();
    }
    
    /**
     * Set door
     *
     * @param JLM\ModelBundle\Entity\Door $door
     * @return Task
     */
    public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
    {
    	$this->door = $door;
    
    	return $this;
    }
    
    /**
     * Get door
     *
     * @return JLM\ModelBundle\Entity\Door
     */
    public function getDoor()
    {
    	return $this->door;
    }
    
    /**
     * Set type
     *
     * @param JLM\OfficeBundle\Entity\TaskType $type
     * @return Task
     */
    public function setType(TaskType $type = null)
    {
    	$this->type = $type;
    
    	return $this;
    }
    
    /**
     * Get type
     *
     * @return JLM\OfficeBundle\Entity\TaskType
     */
    public function getType()
    {
    	return $this->type;
    }
}