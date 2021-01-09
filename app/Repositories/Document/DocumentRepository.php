<?php


namespace Vanguard\Repositories\Document;


use Illuminate\Database\Eloquent\Builder;

interface DocumentRepository
{

    public function documentsAuditor() : Builder;

}
