<?php


namespace Vanguard\Support\Plugins;


use Vanguard\Plugins\Plugin;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Repositories\Document\EloquentDocument;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\Support\Sidebar\Item;

class UploadDocument extends Plugin
{

    public function sidebar()
    {

        return Item::create(__('Documents'))
            ->route('documents.index')
            ->icon('fas fa-file')
            ->active('document.index');
    }

}
