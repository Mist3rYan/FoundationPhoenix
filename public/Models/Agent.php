<?php
require_once('../Models/User.php'); //charge les fonctions liées aux agents

class Agent extends User
{
    private array $speciality = [];

    /**
     * Get the value of speciality
     */ 
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * Set the value of speciality
     *
     * @return  self
     */ 
    public function setSpeciality(array $speciality)
    {
        $this->speciality = $speciality;
        return $this;
    }

}
