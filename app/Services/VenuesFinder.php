<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB, Cache};
use LogicException;

class VenuesFinder
{
    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $radius
     * @return Collection|null
     * @throw LogicException
     */
    public function findByCords(float $longitude, float $latitude, int $radius = 10): ?Collection
    {
        if($radius < 0)
            throw new LogicException('Радиус не может быть отрицательный');

        $srid = env('SPATIAL_REF_ID', 6371);

        $venues = Cache::remember("venues-$longitude-$latitude-$radius", 1, function () use($longitude, $latitude, $radius, $srid) {
            return DB::table('venues')
                ->addSelect(['id', 'name', 'description', 'deleted_at'])
                ->selectRaw("($srid *
                            ACOS(
                                COS( RADIANS( latitude ) ) *
                                COS( RADIANS( $latitude ) ) *
                                COS( RADIANS( $longitude ) -
                                RADIANS( longitude ) ) +
                                SIN( RADIANS( latitude ) ) *
                                SIN( RADIANS( $latitude) )
                            )
                        ) AS distance")
                ->havingRaw("distance < $radius")
                ->whereNull('deleted_at')
                ->get();
        });

        return $venues;
    }

}
