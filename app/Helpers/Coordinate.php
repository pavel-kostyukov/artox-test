<?php
namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;

class Coordinate implements Arrayable
{
    private float $latitude;
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function toArray()
    {
        return [
            'lat' => $this->getLatitude(),
            'lon' => $this->getLongitude(),
        ];
    }
}
