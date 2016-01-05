<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\InstallationBundle\Model\BayInterface;
use JLM\InstallationBundle\Model\InstallationInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\CondominiumBundle\Model\PropertyInterface;
use JLM\CondominiumBundle\Model\AdministratorInterface;
use JLM\ProductBundle\Model\ProductInterface;
use JLM\ContractBundle\Model\ContractInterface;
use JLM\ContactBundle\Entity\Address;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Entity\Work;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Entity\Maintenance;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Door implements BayInterface, InstallationInterface
{
    /**
     * @var integer $id
     */
    private $id;
    
    /**
     * Batiment "officiel"
     * @var Site $site
     */
    private $site;
    
    /**
     * Indications internes
     * @var string $street
     * 
     * @Assert\Type(type="string")
     */
    private $street;
    
    /**
     * Type de porte
     * @var DoorType $type
     */
    private $type;
    
    /**
     * Localisation (ex: Entrée, façade...)
     * @var string $location
     *
     * @Assert\Type(type="string")
     */
    private $location;

    /**
     * Pièces de la porte (cellules, bp...)
     * @var Product[] $parts
     */
    private $parts;
    
    /**
     * Emeteurs
     * @var TransmitterType $transmitters
     */
    private $transmitters;
    
    /**
     * @var string $observations
     *
     * @Assert\Type(type="string")
     */
    private $observations;
    
    /**
     * @var string Google Maps (Street)
     * 
     * @Assert\Url
     */
    private $googlemaps;
    
    /**
     * @var int largeur en mm
     * 
     */
    private $width;
    
    /**
     * @var int hauteur en mm
     *
     */
    private $height;
    
    /**
     * Porte à l'arrêt
     * @var bool $stoped
     * @deprecated
     * 
     * @Assert\Type(type="bool")
     */
    private $stopped = false;
    
    /**
     * Liste des mises à l'arrêt
     * @var ArrayCollection
     */
    private $stops;
    
    /**
     * Prélibellé de factration
     * @var string $billingPrelabel
     * 
     * @Assert\Type(type="string")
     */
    private $billingPrelabel;
    
    /**
     * Contrats
     * @var Contract $contracts
     */
    private $contracts;
    
    /**
     * Interventions
     * @var ArrayCollection
     */
    private $interventions;
    
    /**
     * Latitude
     * @var float
     */
    private $latitude;
    
    /**
     * Longitude
     * @var float
     */
    private $longitude;
    
    /**
     * Code installation
     * @var string
     * 
     * @Assert\Regex(pattern="#[AZERTY][0-9]{4}#")
     */
    private $code;
    
    /**
     * Modèle / Marque
     * @var DoorModel
     */
    private $model;
    
    /**
     * Numéro de plaque
     * @var string
     */
    private $ceNumber;
    
    /**
     * E-mails syndic
     * @var string
     */
    private $managerEmails;
    
    /**
     * E-mails comptabilité
     * @var string
     */
    private $accountingEmails;
    
    /**
     * E-mails copro
     * @var string
     */
    private $administratorEmails;
    
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

    public function getCeNumber()
    {
    	return $this->ceNumber;
    }
    
    public function setCeNumber($number)
    {
    	$this->ceNumber = $number;
    	
    	return $this;
    }
    
    public function getModel()
    {
    	return $this->model;
    }
    
    public function getModelName()
    {
    	return ($this->getModel() !== null) ? $this->getModel()->getName() : null;
    }
    
    public function setModel(DoorModel $model = null)
    {
    	$this->model = $model;
    	
    	return $this;
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
        $address->setCity($this->getAdministrator()->getAddress()->getCity());
        
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
    	$arg = array();
    	foreach ($parms as $p)
    	{
    		list($key,$value) = explode('=',$p);
    		$arg[$key] = $value;
    	}

    	$url .= '?hl=fr&z=17&layer=c&output=svembed';
    	foreach (array('ll','cbll','cbp') as $key)
    	{
	    	if (isset($arg[$key]))
	    	{
	    		$url .= '&'.$key.'='.$arg[$key];
	    	}
    	}
    	
    	return $url;
    }
    
    /**
     * Get Maps Image Url
     *
     * @return float
     */
    public function getMapsImageUrl()
    {
    	$tab = explode('?',$this->googlemaps);
    	if (sizeof($tab) != 2)
    	{
    		return null;
    	}
    	list($url,$params) = $tab;
    	$parms = explode('&',$params);
    	$arg = array();
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
        return $this->getAdministrator();
    }

    /**
     * Set property
     *
     * @param PropertyInterface $site
     * @return self
     */
    public function setAdministrator(AdministratorInterface $administrator = null)
    {
        $this->site = $administrator;
    
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
    public function setType(DoorType $type = null)
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
        return ($this->getModelType() === null) ? $this->type : $this->getModelType();
    }
    
    public function getModelType()
    {
    	return ($this->getModel() === null) ? null : $this->getModel()->getType();
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
    public function addIntervention(Intervention $intervention)
    {
    	$this->interventions[] = $intervention;
    
    	return $this;
    }
    
    /**
     * Remove intervention
     *
     * @param JLM\DailyBundle\Entity\Intervention $interventions
     */
    public function removeIntervention(Intervention $intervention)
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
    		{
    			return $contract;
    		}
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
    		{
    			return $contract;
    		}
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
        
        return ($contract === null) ? $this->getAdministrator()->getManager() : $contract->getTrustee();
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
    	{
    		return null;
    	}
    	$lastMaintenance = $this->getLastMaintenance();
    	if ($lastMaintenance === null)
    	{
    		return 1;
    	}
    	$yearLast = $lastMaintenance->format('Y');
    	$today = new \DateTime;
    	$year = $today->format('Y');
    	
    	return ($yearLast == $year) ? 2 : 1;
    }
    
    /**
     * Get WorkInProgress
     */
    public function getWorkInProgress()
    {
    	return !empty(array_filter($this->interventions->toArray(), function($var) {
    		return ($var instanceof Work) && (!$var->getClosed()) && sizeof($var->getShiftTechnicians());
    	}));
    }
    
    /**
     * Get waitWork
     */
    public function getWaitWork()
    {
    	return !empty(array_filter($this->interventions->toArray(), function($var) {
    		return ($var instanceof Work) && (!$var->getClosed()) && !sizeof($var->getShiftTechnicians());
    	}));
    }
    
    public function getFixings()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv instanceof Fixing);
    	});
    }
    
    public function getWorks()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv instanceof Work);
    	});
    }
    
    public function getMaintenances()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv instanceof Maintenance);
    	});
    }
    
    public function getInterventionsNotClosed()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return (!$interv->getClosed());
    	});
    }
    
    public function getInterventionsClosed()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv->getClosed());
    	});
    }
    
    public function getNotMaintenancePublishedClosed()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv->getClosed() && !$interv instanceof Maintenance && $interv->isPublished());
    	});
    }
    
    public function getFixingsClosed()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv instanceof Fixing) && ($interv->getClosed());
    	});
    }
    
    public function getFixingsNotClosed()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv instanceof Fixing) && (!$interv->getClosed());
    	});
    }
    
    /**
     * Get FixingInProgress
     * @deprecated Not here
     */
    public function getFixingInProgress()
    {
    	return !empty(array_filter($this->getFixingsNotClosed(), function($var) {
    		return sizeof($var->getShiftTechnicians());
    	}));
    }
    
    /**
     * Get waitFixing
     * @deprecated Not here
     */
    public function getWaitFixing()
    {
    	return !empty(array_filter($this->getFixingsNotClosed(), function($var) {
    		return !sizeof($var->getShiftTechnicians());
    	}));
    }
    
    /**
     * Get lastMaintenance
     * @deprecated Not here
     * @return \DateTime | null
     */
    public function getLastMaintenance()
    {	
    	return array_reduce($this->getMaintenancesClosed(), function($last, $interv) {
    		$dt = array_reduce($interv->getShiftTechnicians()->toArray(), function ($date, $shift) {
    			$dateShift = ($shift->getEnd() === null) ? $shift->getBegin() : $shift->getEnd();
    			return ($date === null || $date < $dateShift) ? $dateShift : $date;
    		}, null);
    		return ($last === null || $last < $dt) ? $dt : $last;
    	}, null);
    }
    
    public function getMaintenancesClosed()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv instanceof Maintenance && $interv->getClosed());
    	});
    }
    
    public function getMaintenancesNotClosed()
    {
    	return array_filter($this->interventions->toArray(), function($interv) {
    		return ($interv instanceof Maintenance && !$interv->getClosed());
    	});
    }
    
    /**
     * Get nextMaintenance
     * @deprecated Not here
     * @return Maintenance | null
     */
    public function getNextMaintenance()
    {
    	return array_reduce($this->getMaintenancesNotClosed(), function($next, $interv) {
    		return $next === null ? $interv : null;
    	}, null);
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
    	$counter = function($count, $interv) use ($year) {
    		$shifts = $interv->getShiftTechnicians();
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
    		return $count;
    	};
    	
    	return array_reduce($this->getMaintenancesClosed(), $counter, 0);
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
    	return $this->getType().' - '.$this->getLocation().chr(10).$this->getAdministrator();
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
    	return $this->getAdministrator()->isBlocked();
    }

    /**
     * Add stops
     *
     * @param \JLM\ModelBundle\Entity\DoorStop $stops
     * @return Door
     */
    public function addStop(DoorStop $stops)
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
    public function removeStop(DoorStop $stops)
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
    
    public function setAdministratorEmails($emails)
    {
    	$this->administratorEmails = $emails;
    	
    	return $this;
    }
    
    public function getAdministratorEmails()
    {
    	return $this->administratorEmails;
    }
    
    public function setManagerEmails($emails)
    {
    	$this->managerEmails = $emails;
    	 
    	return $this;
    }
    
    public function getManagerEmails()
    {
    	return $this->managerEmails;
    }
    
    public function setAccountingEmails($emails)
    {
    	$this->accountingEmails = $emails;
    
    	return $this;
    }
    
    public function getAccountingEmails()
    {
    	return $this->accountingEmails;
    }
}
