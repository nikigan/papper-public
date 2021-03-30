<?php

namespace Vanguard\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Vanguard\Document;
use Vanguard\User;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Vanguard\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Vanguard\User  $user
     * @param  \Vanguard\Document  $document
     * @return mixed
     */
    public function view(User $user, Document $document)
    {
        $auditor = $document->user->auditor;
        $accountant = $document->user->accountant;
        $canView = $document->user->is($user) || $auditor->is($user) || $accountant->is($user);
        return $canView ?
            Response::allow():
            Response::deny(__("You don't own this document!"));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Vanguard\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Vanguard\User  $user
     * @param  \Vanguard\Document  $document
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Vanguard\User  $user
     * @param  \Vanguard\Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Vanguard\User  $user
     * @param  \Vanguard\Document  $document
     * @return mixed
     */
    public function restore(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Vanguard\User  $user
     * @param  \Vanguard\Document  $document
     * @return mixed
     */
    public function forceDelete(User $user, Document $document)
    {
        //
    }
}
