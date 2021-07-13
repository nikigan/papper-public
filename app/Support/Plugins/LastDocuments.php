<?php


namespace Vanguard\Support\Plugins;


use Vanguard\Plugins\Plugin;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Repositories\Document\EloquentDocument;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class LastDocuments extends Plugin
{

    public function sidebar()
    {
        return Item::create(__('Last documents'))
            ->route('documents.last')
            ->icon('fas fa-history')
            ->permissions(function (User $user) {
                return $user->hasRole('Auditor') || $user->hasRole('Accountant');
            });
    }

}
