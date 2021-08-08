<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoutesTest extends TestCase {
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample() {
        $routeCollection = Route::getRoutes();
        foreach ( $routeCollection as $value ) {
            $response = $this->call( $value->getMethods()[0], $value->getPath() );
            $this->assertNotEquals( 500, $response->status(), "{$value->getMethods()[0]} {$value->getPath()}" );
        }
    }
}
