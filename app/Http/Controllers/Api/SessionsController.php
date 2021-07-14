<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Vanguard\Http\Resources\SessionResource;
use Vanguard\Repositories\Session\SessionRepository;

/**
 * Class SessionsController
 * @package Vanguard\Http\Controllers\Api\Users
 */
class SessionsController extends ApiController {
    /**
     * @var SessionRepository
     */
    private $sessions;

    public function __construct( SessionRepository $sessions ) {
        $this->middleware( 'session.database' );
        $this->sessions = $sessions;
    }

    /**
     * Get info about specified session.
     *
     * @param $session
     *
     * @return SessionResource
     * @throws AuthorizationException
     */
    public function show( $session ) {
        $this->authorize( 'manage-session', $session );

        return new SessionResource( $session );
    }

    /**
     * Destroy specified session.
     *
     * @param $session
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy( $session ) {
        $this->authorize( 'manage-session', $session );

        $this->sessions->invalidateSession( $session->id );

        return $this->respondWithSuccess();
    }
}
