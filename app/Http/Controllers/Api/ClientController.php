<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Resources\ClientResource;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;

class ClientController extends Controller {

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    private RoleRepository $roleRepository;


    /**
     * UsersController constructor.
     *
     * @param UserRepository $users
     * @param RoleRepository $roles
     */
    public function __construct( UserRepository $users, RoleRepository $roles ) {
        $this->userRepository = $users;
        $this->roleRepository = $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ClientResource::collection(auth()->user()->clients()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
