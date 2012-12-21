<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification de travaux
 * JLM\OfficeBundle\Entity\Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity
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
	 * Intervention source
	 * @var Intervention
	 * 
	 * @ORM\OneToOne(targetEntity="JLM\DailyBundle\Entity\Intervention", mappedBy="officeAction")
	 */
	private $intervention;
	
	/**
	 * A faire
	 * @var string
	 *
	 * @ORM\Column(name="todo",type="text")
	 */
	private $todo;
	
	/**
	 * Raccourci vers l'action à effectuer
	 * @var string
	 * 
	 * @ORM\Column(name="url",type="text")
	 */
	private $url;
	
	/**
	 * Tache terminée
	 * @var bool
	 *
	 * @ORM\Column(name="closed",type="boolean")
	 */
	private $closed = false;
	
	

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
     * Set closed
     *
     * @param boolean $closed
     * @return Task
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    
        return $this;
    }

    /**
     * Get closed
     *
     * @return boolean 
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set intervention
     *
     * @param JLM\DailyBundle\Entity\Intervention $intervention
     * @return Task
     */
    public function setIntervention(\JLM\DailyBundle\Entity\Intervention $intervention = null)
    {
        $this->intervention = $intervention;
    
        return $this;
    }

    /**
     * Get intervention
     *
     * @return JLM\DailyBundle\Entity\Intervention 
     */
    public function getIntervention()
    {
        return $this->intervention;
    }
}