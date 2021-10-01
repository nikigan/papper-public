<?php

namespace Vanguard\Support\Plugins;

use Route;
use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientDocuments extends Plugin
{
    public function sidebar() {
        if ( Route::is( "clients.*" ) ) {
            $client = Route::current()->parameter( 'client' );
        }

        if ( isset( $client ) ) {
            return Item::create( __( 'Client\'s Documents' ) )
                       ->href( route( 'clients.documents', [ 'client' => $client ] ) )
                       ->active( "clients.documents" )
                       ->permissions( 'clients.manage' );
        } else {
            return false;
        }
    }
}
