<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Vanguard\Http\Resources\CountryResource;
use Vanguard\Repositories\Country\CountryRepository;

/**
 * @package Vanguard\Http\Controllers\Api
 */
class CountriesController extends ApiController {
    /**
     * @var CountryRepository
     */
    private $countries;

    public function __construct( CountryRepository $countries ) {
        $this->countries = $countries;
    }

    /**
     * Get list of all available countries.
     * @return AnonymousResourceCollection
     */
    public function index() {
        return CountryResource::collection( $this->countries->all() );
    }
}
