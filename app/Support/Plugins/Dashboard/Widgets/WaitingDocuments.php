<?php

namespace Vanguard\Support\Plugins\Dashboard\Widgets;

use Vanguard\Plugins\Widget;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\User;

class WaitingDocuments extends Widget
{
    /**
     * {@inheritdoc}
     */
    public $width = '3';

    /**
     * {@inheritdoc}
     */
    protected $permissions = [];

    /**
     * @var DocumentRepository
     */
    private DocumentRepository $documents;

    /**
     * TotalUsers constructor.
     * @param DocumentRepository $documents
     */
    public function __construct(DocumentRepository $documents)
    {
        $this->documents = $documents;
        $this->permissions = function (User $user) {
            return $user->hasRole('Auditor') || $user->hasRole('Accountant');
        };
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return view('plugins.dashboard.widgets.waiting-documents', [
            'count' => $this->documents->documentsAuditor()->where('status', DocumentStatus::UNCONFIRMED)->count()
        ]);
    }
}
