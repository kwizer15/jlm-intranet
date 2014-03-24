<?php

namespace JLM\TransmitterBundle\Model;

use JLM\TransmitterBundle\Model\TransmitterInterface;

interface AttributionInterface
{
    /**
     * Get creation
     *
     * @return \DateTime 
     */
    public function getCreation();

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact();

    /**
     * Get individual
     *
     * @return boolean 
     */
    public function getIndividual();
    
    /**
     * Add transmitters
     *
     * @param TransmitterInterface $transmitters
     * @return Attribution
     */
    public function addTransmitter(TransmitterInterface $transmitters);

    /**
     * Remove transmitters
     *
     * @param TransmitterInterface $transmitters
     */
    public function removeTransmitter(TransmitterInterface $transmitters);

    /**
     * Get transmitters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransmitters();

    /**
     * Get ask
     *
     * @return \JLM\OfficeBundle\Entity\Ask
     */
    public function getAsk();
    
    /**
     * Get Site
     * 
     * @return \JLM\ModelBundel\Entity\Site 
     */
    public function getSite();
}