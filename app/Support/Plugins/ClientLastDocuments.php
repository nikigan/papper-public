<?php

namespace Vanguard\Support\Plugins;

use Route;
use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientLastDocuments extends Plugin
{
    public function sidebar() {
        if ( Route::is( "clients.*" ) ) {
            $client = Route::current()->parameter( 'client' );
        }

        if ( isset( $client ) ) {
            return Item::create( __( 'Client\'s Last Documents' ) )
                       ->href( route( 'clients.last', [ 'client' => $client ] ) )
                       ->active( "clients.last" )
                       ->permissions( 'clients.manage' );
        } else {
            return false;
        }
    }
}
