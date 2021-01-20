<?php

namespace Vanguard\Support\Plugins\Dashboard\Widgets;

use Vanguard\Plugins\Widget;
use Vanguard\Repositories\User\UserRepository;

class TotalClients extends Widget
{
    /**
     * {@inheritdoc}
     */
    public $width = '3';

    /**
     * {@inheritdoc}
     */
    protected $permissions = 'clients.manage';

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * TotalUsers constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return view('plugins.dashboard.widgets.total-clients', [
            'count' => $this->users->clients()->count()
        ]);
    }
}
