<?php


namespace Vanguard\Repositories\Document;


use Illuminate\Database\Eloquent\Builder;

interface DocumentRepository {

    public function documentsAuditor(): Builder;

    public function waitingDocuments(): Builder;

    public function currentUserDocuments(): Builder;

    public function lastModifiedDocuments(): Builder;


}
