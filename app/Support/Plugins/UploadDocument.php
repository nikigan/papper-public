<?php


namespace Vanguard\Support\Plugins;


use Vanguard\Plugins\Plugin;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Repositories\Document\EloquentDocument;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class UploadDocument extends Plugin
{

    public function sidebar()
    {

        return Item::create(__('Documents'))
            ->route('documents.index')
            ->icon('fas fa-file')
            ->permissions(function (User $user) {
                return !$user->hasRole('Admin');
            })
            ->active('documents');
    }

}
