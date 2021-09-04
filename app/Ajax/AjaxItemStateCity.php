<?php

namespace App\Ajax;

use App\Models\ItemStateCity;

class AjaxItemCidadeEstado 
{
    /** @var instance*/
    private $itemStateCity;

    public function __construct()
    {
        $this->itemStateCity = new ItemStateCity();
    }

    /**
     * Returns all cities by state id.
     * 
     * @param int $stateId
     */
    public function getCityByStateId(int $stateId)
    {
        if(!is_null($stateId) && is_numeric($stateId)) {
            $cities = $this->itemStateCity->findAllCitiesByStateId($stateId);

            die(json);
        }
    }
}