<?php


namespace Vanguard\Support\Plugins;


use Vanguard\Plugins\Plugin;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Repositories\Document\EloquentDocument;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class Trash extends Plugin
{

    public function sidebar()
    {
        return Item::create(__('Trash'))
            ->route('trash.index')
            ->icon('fas fa-trash')
            ->active('trash');
    }

}
