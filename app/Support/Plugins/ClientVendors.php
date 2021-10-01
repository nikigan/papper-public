<?php

namespace Vanguard\Support\Plugins;

use Route;
use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientVendors extends Plugin
{
    public function sidebar() {
        if ( Route::is( "clients.*" ) ) {
            $client = Route::current()->parameter( 'client' );
        }

        if ( isset( $client ) ) {
            return Item::create( __( 'Client\'s Vendors' ) )
                       ->href( route( 'clients.vendors', $client ) )
                       ->active( "clients.vendors" )
                       ->permissions( 'clients.manage' );
        } else {
            return false;
        }
    }
}
