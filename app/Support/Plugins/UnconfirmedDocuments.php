<?php


namespace Vanguard\Support\Plugins;


use Vanguard\Plugins\Plugin;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Repositories\Document\EloquentDocument;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class UnconfirmedDocuments extends Plugin
{

    public function sidebar()
    {
        $documents = new EloquentDocument();
        $count =  $documents->documentsAuditor()->where('status', DocumentStatus::UNCONFIRMED)->count();

        return Item::create(__('Waiting documents'))
            ->route('documents.waiting')
            ->icon('fas fa-file')
            ->permissions(function (User $user) {
                return !$user->hasRole('Admin');
            })
            ->count($count);
//            ->active('documents.waiting');
    }

}
