<?php


namespace Vanguard\Repositories\Document;


use Illuminate\Database\Eloquent\Builder;
use Vanguard\Document;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\User;

class EloquentDocument implements DocumentRepository {


    public function sortDocuments(Builder $documents): Builder {
        if (request()->has('sort_prop')) {
            $documents->getQuery()->orders = null;
            $documents->orderBy(request()->get('sort_prop'), request()->get('sort_order') ?? 'desc');
        }

        return $documents;
    }
    public function documentsAuditor(): Builder {
        $current_user = auth()->user();

        return $this->sortDocuments(Document::query()
                       ->whereHas( 'user', function ( $q ) use ( $current_user ) {
                           $q->where( 'auditor_id', $current_user->id )
                             ->orWhere( 'accountant_id', $current_user->id );
                       } )
                       ->orderByDesc( 'document_date' ));
    }

    public function currentUserDocuments(): Builder {
        $current_user = auth()->user();
        if ( ! $current_user->hasRole( 'User' ) ) {
            $documents = $this->documentsAuditor();
        } else {
            $documents = Document::query()
                                 ->with( 'user' )
                                 ->where( 'user_id', '=', $current_user->id )
                                 ->orderByDesc( 'created_at' );
        }

        return $this->sortDocuments($documents);
    }

    public function waitingDocuments(): Builder {
        $documents = $this->currentUserDocuments();
        $documents->where( 'status', DocumentStatus::UNCONFIRMED );

        return $documents;
    }

    public function lastModifiedDocuments(): Builder {
        return $this->currentUserDocuments()
                       ->orderByDesc( 'updated_at' );

    }
}
