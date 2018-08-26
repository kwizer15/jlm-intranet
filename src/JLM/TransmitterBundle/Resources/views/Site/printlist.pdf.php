<?php
 
use JLM\TransmitterBundle\Pdf\SiteList;

echo SiteList::get($entity, $transmitters, $withHeader);
