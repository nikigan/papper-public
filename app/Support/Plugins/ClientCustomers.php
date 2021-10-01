<?php

namespace Vanguard\Support\Plugins;

use Route;
use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientCustomers extends Plugin
{
    public function sidebar() {
        if ( Route::is( "clients.*" ) ) {
            $client = Route::current()->parameter( 'client' );
        }

        if ( isset( $client ) ) {
            return Item::create( __( 'Client\'s Customers' ) )
                       ->href( route( 'clients.customers', [ 'client' => $client ] ) )
                       ->active( "clients.customers" )
                       ->permissions( 'clients.manage' );
        } else {
            return false;
        }
    }
}
