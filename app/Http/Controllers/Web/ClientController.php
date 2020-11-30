<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;

class ClientController extends Controller
{

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users = User::query()->where('id', '!=', auth()->id())->get();
        return view('clients.index', compact('users'));
    }

    private function parseCountries(CountryRepository $countryRepository)
    {
        return [0 => __('Select a Country')] + $countryRepository->lists()->toArray();
    }

    public function create(CountryRepository $countryRepository, RoleRepository $roleRepository)
    {
        return view('clients.add', [
            'countries' => $this->parseCountries($countryRepository),
            'roles' => [2 => 'User'],
            'statuses' => UserStatus::lists()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all() + [
                'status' => UserStatus::ACTIVE,
                'email_verified_at' => now()
            ];

        if (! data_get($data, 'country_id')) {
            $data['country_id'] = null;
        }

        // Username should be updated only if it is provided.
        if (! data_get($data, 'username')) {
            $data['username'] = null;
        }

        $this->users->create($data);

        return redirect()->route('clients.index')
            ->withSuccess(__('Client created successfully.'));
    }


    public function show($id)
    {
        //$user = User::query()->with('documents')->where('id', '=', $id)->get();
        $user = User::query()->find($id);
        $documents = $user->documents;
        $sum = 0;
        $vat = 0;
        foreach ($documents as $document) {
            if ($document->status == 'Confirmed') {
                $k = $document->document_type ? 1 : -1;
                $sum += $k * $document->sum;
                $vat += $k * $document->vat;
            }
        }
        $sum_class = $sum > 0 ? 'text-success' : 'text-danger';
        $current_user = auth()->user();
        return view('clients.show', compact('user', 'documents', 'current_user', 'sum', 'sum_class', 'vat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
