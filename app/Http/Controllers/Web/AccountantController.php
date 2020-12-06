<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;

class AccountantController extends Controller
{

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var RoleRepository
     */
    private $roles;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     * @param RoleRepository $roles
     */
    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function index()
    {
        $users = User::query()
            ->where('auditor_id', '=', auth()->id())
            ->where('role_id', '=', 4)
            ->get();
        return view('accountants.index', compact('users'));
    }

    private function parseCountries(CountryRepository $countryRepository)
    {
        return [0 => __('Select a Country')] + $countryRepository->lists()->toArray();
    }

    public function create(CountryRepository $countryRepository, RoleRepository $roleRepository)
    {
        return view('accountants.add', [
            'countries' => $this->parseCountries($countryRepository),
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

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'nullable',
            'password' => 'required|min:6|confirmed',
            'birthday' => 'nullable|date',
            'verified' => 'boolean'
        ]);

        $data = $request->all() + [
                'status' => UserStatus::ACTIVE,
                'email_verified_at' => now(),
                'auditor_id' => auth()->id(),
                'role_id' => $this->roles->findByName('Accountant')->id
            ];


        if (!data_get($data, 'country_id')) {
            $data['country_id'] = null;
        }

        // Username should be updated only if it is provided.
        if (!data_get($data, 'username')) {
            $data['username'] = null;
        }

        $this->users->create($data);

        return redirect()->route('accountants.index')
            ->withSuccess(__('Accountant created successfully.'));
    }


    public function show($id)
    {
        //$user = User::query()->with('documents')->where('id', '=', $id)->get();
        $accountant = User::query()->findOrFail($id);
        if ($accountant->auditor && $accountant->auditor->id == auth()->id()) {
            $clients = User::query()->where('accountant_id', $id)->get();
            $current_user = auth()->user();
            $clients_to_add = User::query()->where('accountant_id', '!=', $id)->orWhereNull('accountant_id')->where('role_id', $this->roles->findByName('User')->id)->get();
            return view('accountants.show', compact('accountant', 'clients', 'current_user', 'clients_to_add'));
        }


        return redirect()->back()->withErrors(__('You cannot look at client that is not yours'));
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
