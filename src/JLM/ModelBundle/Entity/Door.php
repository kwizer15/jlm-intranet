<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\InstallationBundle\Model\BayInterface;
use JLM\InstallationBundle\Model\InstallationInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\CondominiumBundle\Model\PropertyInterface;
use JLM\CondominiumBundle\Model\AdministratorInterface;
use JLM\ProductBundle\Model\ProductInterface;
use JLM\ContractBundle\Model\ContractInterface;

/**
 * JLM\ModelBundle\Entity\Door
 *
 * @ORM\Table(name="doors")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\DoorRepository")
 */
class Door implements BayInterface, InstallationInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Batiment "officiel"
     * @var Site $site
     * 
     * @ORM\ManyToOne(targetEntity="Site",inversedBy="doors")
     */
    private $site;
    
    /**
     * Indications internes
     * @var string $street
     * 
     * @ORM\Column(name="street",type="text")
     * @Assert\Type(type="string")
     */
    private $street;
    
    /**
     * Type de porte
     * @var DoorType $type
     * 
     * @ORM\ManyToOne(targetEntity="DoorType")
     */
    private $type;
    
    /**
     * Localisation (ex: Entrée, façade...)
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $location;

    /**
     * Pièces de la porte (cellules, bp...)
     * @var Product[] $parts
     * 
     * @ORM\ManyToMany(targetEntity="JLM\ProductBundle\Entity\Product")
     * @ORM\JoinTable(name="doors_parts",
     *      joinColumns={@ORM\JoinColumn(name="door_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="part_id", referencedColumnName="id")}
     *      )
     * 
     */
    private $parts;
    
    /**
     * Emeteurs
     * @var TransmitterType $transmitters
     * 
     * @ORM\ManyToMany(targetEntity="TransmitterType")
     * @ORM\JoinTable(name="doors_transmitters",
     * 		joinColumns={@ORM\JoinColumn(name="door_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="transmitters_id", referencedColumnName="id")}
     * 		)
     * 
     */
    private $transmitters;
    
    /**
     * @var string $observations
     *
     * @ORM\Column(name="observations", type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    private $observations;
    
    /**
     * @var string Google Maps (Street)
     * 
     * @ORM\Column(name="googlemaps", type="text", nullable=true)
     * @Assert\Url
     */
    private $googlemaps;
    
    /**
     * @var int largeur en mm
     * 
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;
    
    /**
     * @var int hauteur en mm
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;
    
    /**
     * Porte à l'arrêt
     * @var bool $stoped
     * @deprecated
     * 
     * @ORM\Column(name="stopped", type="boolean")
     * @Assert\Type(type="bool")
     */
    private $stopped = false;
    
    /**
     * Liste des mises à l'arrêt
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="DoorStop", mappedBy="door")
     * @ORM\OrderBy({"begin" = "DESC"})
     */
    private $stops;
    
    /**
     * Prélibellé de factration
     * @var string $billingPrelabel
     * 
     * @ORM\Column(name="billing_prelabel", type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    private $billingPrelabel;
    
    /**
     * Contrats
     * @var Contract $contracts
     * 
     * @ORM\OneToMany(targetEntity="JLM\ContractBundle\Entity\Contract",mappedBy="door")
     *
     */
    private $contracts;
    
    /**
     * Interventions
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="JLM\DailyBundle\Entity\Intervention",mappedBy="door")
     * @ORM\OrderBy({"creation" = "DESC"})
     * 
     */
    private $interventions;
    
    /**
     * Latitude
     * @var float
     * 
     * @ORM\Column(name="latitude", type="float",nullable=true)
     */
    private $latitude;
    
    /**
     * Longitude
     * @var float
     *
     * @ORM\Column(name="longitude", type="float",nullable=true)
     */
    private $longitude;
    
    /**
     * Code installation
     * @var string
     * 
     * @ORM\Column(name="code", type="string", length=10, nullable=true)
     * @Assert\Regex(pattern="#[AZERTY][0-9]{4}#")
     */
    private $code;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->parts = new ArrayCollection;
    	$this->transmitters = new ArrayCollection;
    	$this->contracts = new ArrayCollection;
    	$this->interventions = new ArrayCollection;
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
     * Set street
     * 
     * @param string $street
     * @return Door
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     * 
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the address
     * @param AddressInterface $address
     * @return self
     */
    public function setAddress(AddressInterface $address)
    {
        $this->street = $address->getStreet();
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        $address = new Address();
        $address->setStreet($this->getStreet());
        $address->setCity($this->getProperty()->getAddress()->getCity());
        
        return $address;
    }
    
    /**
     * Set location
     *
     * @param string $location
     * @return Door
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set observations
     *
     * @param string $observations
     * @return Door
     */
    public function setObservations($observations)
    {
    	$this->observations = $observations;
    
    	return $this;
    }
    
    /**
     * Get observations
     *
     * @return string
     */
    public function getObservations()
    {
    	return $this->observations;
    }
    
    /**
     * Set googlemaps
     *
     * @param string $googlemaps
     * @return Door
     */
    public function setGooglemaps($url)
    {
        $this->googlemaps = $url;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getGooglemaps()
    {
        return $this->googlemaps;
    }
    
    /**
     * Get Maps Url
     *
     * @return float
     */
    public function getMapsUrl()
    {
    	list($url,$params) = explode('?',$this->googlemaps);
    	$parms = explode('&',$params);
    	foreach ($parms as $p)
    	{
    		list($key,$value) = explode('=',$p);
    		$arg[$key] = $value;
    	}

    	$url .= '?hl=fr&z=17&layer=c&output=svembed';
    	if (isset($arg['ll']))
    		$url .= '&ll='.$arg['ll'];
    	if (isset($arg['cbll']))
    		$url .= '&cbll='.$arg['cbll'];
    	if (isset($arg['cbp']))
    		$url .= '&cbp='.$arg['cbp'];
    	return $url;
    }
    
    /**
     * Get Maps Image Url
     *
     * @return float
     */
    public function getMapsImageUrl()
    {
    	list($url,$params) = explode('?',$this->googlemaps);
    	$parms = explode('&',$params);
    	foreach ($parms as $p)
    	{
    		list($key,$value) = explode('=',$p);
    		$arg[$key] = $value;
    	}
    	$url = 'http://maps.googleapis.com/maps/api/streetview';
    	$url .= '?size=350x300&sensor=false';
    	if (isset($arg['ll']))
	   		$url .= '&location='.$arg['ll'];
    	if (isset($arg['cbp']))
    	{
    		$cbp = explode(',',$arg['cbp']);
 	  		$url .= '&heading='.$cbp[1];
    	}
    	return $url;
    }

    /**
     * Set site
     *
     * @param AdministratorInterface $site
     * @deprecated Use setAdministrator(AdministratorInterface $administrator)
     * @return self
     */
    public function setSite(AdministratorInterface $site = null)
    {
        return $this->setAdministrator($site);
    }

    /**
     * Get site
     * @deprecated Use getAdministrator()
     * @return AdministratorInterface 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set property
     *
     * @param PropertyInterface $site
     * @return self
     */
    public function setAdministrator(AdministratorInterface $property = null)
    {
        $this->site = $property;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAdministrator()
    {
        return $this->site;
    }
    
    /**
     * Set type
     *
     * @param JLM\ModelBundle\Entity\DoorType $type
     * @return Door
     */
    public function setType(\JLM\ModelBundle\Entity\DoorType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return JLM\ModelBundle\Entity\DoorType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add parts
     *
     * @param ProductInterface $parts
     * @return Door
     */
    public function addPart(ProductInterface $parts)
    {
        return $this->parts->add($parts);
    }

    /**
     * Remove parts
     *
     * @param ProductInterface $parts
     */
    public function removePart(ProductInterface $parts)
    {
        return $this->parts->removeElement($parts);
    }

    /**
     * Get parts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * {@inheritdoc}
     */
    public function getInstallation()
    {
        return $this;
    }
    
    /**
     * Add contract
     *
     * @param ContractInterface $contract
     * @return Door
     */
    public function addContract(ContractInterface $contract)
    {
    	$this->contracts[] = $contract;
    	
    	return $this;
    }
    
    /**
     * Remove contract
     *
     * @param ContractInterface $contract
     */
    public function removeContract(ContractInterface $contract)
    {
    	$this->contracts->removeElement($contract);
    }
    
    /**
     * Get contracts
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getContracts()
    {
    	return $this->contracts;
    }
    
    /**
     * Add intervention
     *
     * @param JLM\DailyBundle\Entity\Intervention $interventions
     * @return Door
     */
    public function addIntervention(\JLM\DailyBundle\Entity\Intervention $intervention)
    {
    	$this->interventions[] = $intervention;
    
    	return $this;
    }
    
    /**
     * Remove intervention
     *
     * @param JLM\DailyBundle\Entity\Intervention $interventions
     */
    public function removeIntervention(\JLM\DailyBundle\Entity\Intervention $intervention)
    {
    	$this->interventions->removeElement($intervention);
    }
    
    /**
     * Get interventions
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getInterventions()
    {
    	return $this->interventions;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getActualContract()
    {
    	return $this->getContract();
    }
    
    /**
     * Get contract on date
     * 
     * @return ContractInterface
     */
    public function getContract(\DateTime $date = null)
    {
    	$date = ($date === null) ? new \DateTime : $date;
    	foreach ($this->contracts as $contract)
    	{
    		if ($contract->getInProgress($date))
    			return $contract;
    	}
    	return null;
    }
    
    /**
     * Get last contract
     * 
     * @return ContractInterface
     */
    public function getLastContract()
    {
    	$date = new \DateTime;
    	foreach ($this->contracts as $contract)
    	{
    		if ($contract->getBegin() > $date)
    			return $contract;
    	}
    	return null;
    }
    
    /**
     * Get Trustee
     * @deprecated
     * @return ManagerInterface
     */
    public function getTrustee()
    {
    	return $this->getManager();
    }
    
    /**
     * Get Manager
     *
     * @return ManagerInterface
     */
    public function getManager()
    {
        $contract = $this->getActualContract();
        if ($contract === null)
        {
            return $this->getAdministrator()->getManager();
        }
        
        return $contract->getTrustee();
    }
    
    /**
     * Add transmitters
     *
     * @param JLM\ModelBundle\Entity\TransmitterType $transmitters
     * @return Door
     */
    public function addTransmitter(TransmitterType $transmitters)
    {
        $this->transmitters[] = $transmitters;
    
        return $this;
    }

    /**
     * Remove transmitters
     *
     * @param JLM\ModelBundle\Entity\TransmitterType $transmitters
     */
    public function removeTransmitter(TransmitterType $transmitters)
    {
        $this->transmitters->removeElement($transmitters);
    }

    /**
     * Get transmitters
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTransmitters()
    {
        return $this->transmitters;
    }
    
    /**
     * Set largeur
     * 
     * @param int $width
     */
    public function setWidth($width)
    {
    	$this->width = $width;
    	return $this;
    }
    
    /**
     * Get largeur
     * 
     * @return int $width
     */
    public function getWidth()
    {
    	return $this->width;
    }
    
    /**
     * Set hauteur
     *
     * @param int $height
     */
    public function setHeight($height)
    {
    	$this->height = $height;
    	return $this;
    }
    
    /**
     * Get hauteur
     *
     * @return int $height
     */
    public function getHeight()
    {
    	return $this->height;
    }
    
    /**
     * Get stopped
     * 
     * @return bool $stopped
     */
    public function getStopped()
    {
    	return $this->getLastStop() != null;
    }
    
    /**
     * Is stopped
     * 
     * @return bool $stopped
     */
    public function isStopped()
    {
    	return $this->getStopped();
    }
    
    /**
     * Set stopped
     * @deprecated
     * @param bool $stopped
     */
    public function setStopped($stopped = true)
    {
    	$this->stopped = (bool)$stopped;
    	return $this;
    }
    
    /**
     * Get waitMaintenance
     * 
     * @return bool
     */
    public function getWaitMaintenance()
    {
		return ($this->getNextMaintenance() !== null);
    }
    
    /**
     * Get numberWaitMaintenance
     *
     * @return int|null
     */
    public function getNumberWaitMaintenance()
    {
    	if (!$this->getWaitMaintenance())
    		return null;
    	if ($this->getLastMaintenance() === null)
    		return 1;
    	$yearLast = $this->getLastMaintenance()->format('Y');
    	$today = new \DateTime;
    	$year = $today->format('Y');
    	if ($yearLast == $year)
    		return 2;
    	return 1;
    }
    
    /**
     * Get WorkInProgress
     */
    public function getWorkInProgress()
    {
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Work)
    		{
    			if (!$interv->getClosed())
    			{
    				if (sizeof($interv->getShiftTechnicians()))
    				{
    					return true;
    				}
    			}
    		}
    	}
    	
    	return false;
    }
    
    /**
     * Get waitWork
     */
    public function getWaitWork()
    {
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Work)
    		{
    			if (!$interv->getClosed())
    			{
    				if (!sizeof($interv->getShiftTechnicians()))
    				{
    					return true;
    				}
    			}
    		}
    	}
    	return false;
    }
    
    /**
     * Get FixingInProgress
     * @deprecated Not here
     */
    public function getFixingInProgress()
    {
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Fixing)
    		{
    			if (!$interv->getClosed())
    			{
    				if (sizeof($interv->getShiftTechnicians()))
    				{
    					return true;
    				}
    			}
    		}
    	}
    	
    	return false;
    }
    
    /**
     * Get waitFixing
     * @deprecated Not here
     */
    public function getWaitFixing()
    {
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Fixing)
    		{
    			if (!$interv->getClosed())
    			{
    				if (!sizeof($interv->getShiftTechnicians()))
    				{
    					return true;
    				}
    			}
    		}
    	}
    	
    	return false;
    }
    
    /**
     * Get lastMaintenance
     * @deprecated Not here
     * @return \DateTime | null
     */
    public function getLastMaintenance()
    {
    	$last = null;
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Maintenance)
    		{
    			if ($interv->getClosed())
    			{
    				$shifts = $interv->getShiftTechnicians();
    				$date = null;
    				foreach ($shifts as $shift)
    				{
    					$dateShift = ($shift->getEnd() === null) ? $shift->getBegin() : $shift->getEnd();
    					if ($date === null || $date < $dateShift)
    						$date = $dateShift;
    				}
    				if ($last === null || $last < $date)
    				{
    					$last = $date;
    				}
    			}
    		}
    	}
    	return $last;
    }
    
    /**
     * Get nextMaintenance
     * @deprecated Not here
     * @return Maintenance | null
     */
    public function getNextMaintenance()
    {
    	$last = null;
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Maintenance)
    		{
    			if (!$interv->getClosed())
    			{
    				return $interv;
    			}
    		}
    	}
    	return null;
    }
    
    /**
     * @deprecated Not here
     * @param string $year
     * @return number
     */
    public function getCountMaintenance($year = null)
    {
    	if ($year === null)
    	{
    		$d = new \DateTime;
    		$year  = $d->format('Y');
    		unset($d);
    	}
    	$count = 0;
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Maintenance)
    		{
    			if ($interv->getClosed())
    			{
    				$shifts = $interv->getShiftTechnicians();
    				$date = null;
    				$flag = false;
    				foreach ($shifts as $shift)
    				{
    					$dateShift = ($shift->getEnd() === null) ? $shift->getBegin() : $shift->getEnd();
    					if ($dateShift->format('Y') == $year && !$flag)
    					{
    						$count++;
    						$flag = true;
    					}
    				}
    			}
    		}
    	}
    	return $count;
    }
    
    /**
     * Get billingPrelabel
     * 
     * @return string
     */
    public function getBillingPrelabel()
    {
    	return $this->billingPrelabel;
    }
    
    /**
     * Set billingPrelabel
     * 
     * @param string $label
     * @return Door
     */
    public function setBillingPrelabel($label)
    {
    	$this->billingPrelabel = $label;
    	return $this;
    }
    
    /**
     * To String
     * @return string
     */
    public function __toString()
    {
    	return $this->getType().' - '.$this->getLocation().chr(10).$this->getProperty();
    }
    
    /**
     * To String
     * @return string
     */
    public function toString()
    { 
        if (!$this->getAdministrator() instanceof Site)
        {
            return $this->__toString();
        }
        
        return $this->getType().' - '.$this->getLocation().chr(10).$this->getAdministrator()->__toString();
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Door
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Door
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    /**
     * Get coordinates
     * 
     * @return string
     */
    public function getCoordinates()
    {
    	return $this->getLatitude().','.$this->getLongitude();
    }
    
    /**
     * Is blocked
     * 
     * @return bool
     */
    public function isBlocked()
    {
    	return $this->getSite()->isBlocked();
    }

    /**
     * Add stops
     *
     * @param \JLM\ModelBundle\Entity\DoorStop $stops
     * @return Door
     */
    public function addStop(\JLM\ModelBundle\Entity\DoorStop $stops)
    {
    	$stops->setDoor($this);
        $this->stops[] = $stops;
        
        return $this;
    }

    /**
     * Remove stops
     *
     * @param \JLM\ModelBundle\Entity\DoorStop $stops
     */
    public function removeStop(\JLM\ModelBundle\Entity\DoorStop $stops)
    {
    	$stops->setDoor();
        $this->stops->removeElement($stops);
        
        return $this;
    }

    /**
     * Get stops
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStops()
    {
        return $this->stops;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isUnderWarranty()
    {
    	$guarantee = $this->getEndWarranty();
    	if ($guarantee === null)
    	{
    		return false;
    	}
    	$today = new \DateTime;

    	return ($guarantee >= $today);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEndWarranty()
    {
    	$contract = $this->getActualContract();
    	if ($contract === null)
    	{
    		return null;
    	}
    	return $contract->getEndWarranty();
    }
    
	/**
     * Get Last Stop
     * 
     * @return \JLM\ModelBundle\Entity\DoorStop
     */
    public function getLastStop()
    {
    	$stops = $this->getStops();
    	foreach ($stops as $stop)
    	{
    		if ($stop->getEnd() === null)
    		{
    			return $stop;
    		}
    	}
    	return null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
    	return $this->code;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasCode()
    {
    	return $this->getCode() !== null;
    }
    
    /**
     * Set code
     * 
     * @param string $code
     * @return this
     */
    public function setCode($code)
    {
    	$this->code = strtoupper($code);
    	
    	return $this;
    }
}
