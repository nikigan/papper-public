<?php

namespace Vanguard\Support\Plugins;

use Route;
use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientInfo extends Plugin
{
    public function sidebar() {
        if ( Route::is( "clients.*" ) ) {
            $client = Route::current()->parameter( 'client' );
        }

        if ( isset( $client ) ) {
            return Item::create( __( 'Client\'s Info' ) )
                       ->href( route( 'clients.info', $client ) )
                       ->active( "clients.info" )
                       ->permissions( 'clients.manage' );
        } else {
            return false;
        }
    }
}
