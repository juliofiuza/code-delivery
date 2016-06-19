<?php

namespace CodeDelivery\Models;

use Illuminate\Contracts\Support\Jsonable;

class Geo implements Jsonable
{
    public $lat;
    public $lng;

    public function toJson($options = 0)
    {
    	return json_encode([
    		'lat' => $this->lat,
    		'lng' => $this->lng
    	]);
    }
}
