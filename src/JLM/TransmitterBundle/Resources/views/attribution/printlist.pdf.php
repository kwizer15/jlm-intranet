<?php
 
use JLM\TransmitterBundle\Pdf\AttributionList;

echo AttributionList::get($entity, $transmitters, $withHeader);
