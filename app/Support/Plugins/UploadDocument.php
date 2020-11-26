<?php


namespace Vanguard\Support\Plugins;


use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class UploadDocument extends Plugin
{

    public function sidebar()
    {
        /*$list = Item::create(__('Show your documents'))
            ->route('document.show')
            ->active('document.show')
            ->permissions('document.show');

        $upload =  Item::create(__('Upload document'))
            ->route('document.upload')
            ->active('document.upload')
            ->permissions('document.upload');

        return Item::create(__('Documents'))
            ->href('#documents-dropdown')
            ->icon('fas fa-file')
            ->permissions(['document.show', 'document.upload'])
            ->addChildren([
                $list,
                $upload
            ]);*/
        return Item::create(__('Documents'))
            ->route('documents.index')
            ->icon('fas fa-file')
            ->active('document.index');
    }

}
