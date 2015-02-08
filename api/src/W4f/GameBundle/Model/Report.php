<?php

namespace W4f\GameBundle\Model;

class Report {
    public $infos;
    public $errors;
    public $warnings;
    
    public function __construct() {
        $this->infos = array();
        $this->errors = array();
        $this->warnings = array();
    }
    
    public function logError($error){
        $this->errors[] = $error;
    }
}
