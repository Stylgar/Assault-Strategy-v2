<?php

namespace W4f\GameBundle\Model;

use W4f\GameBundle\Model\Report;

class ControllerResponse{

    /**
     * Real response to the query. Can be anything (boolean, list, object...)
     */
    public $response;
    
    /**
     * The report containing errors, warnings and informations.
     * @var \W4f\GameBundle\Model\Report 
     */
    public $report;
    
    /**
     * Basic constructor.
     */
    public function __construct(){
        $this->report = new Report();
    }  
}