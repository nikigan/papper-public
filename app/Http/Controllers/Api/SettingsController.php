<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Setting;

/**
 * @package Vanguard\Http\Controllers\Api\Settings
 */
class SettingsController extends ApiController {
    public function __construct() {
        $this->middleware( 'permission:settings.general' );
    }

    /**
     * System settings.
     * @return JsonResponse
     */
    public function index() {
        return response()->json( Setting::all() );
    }
}
