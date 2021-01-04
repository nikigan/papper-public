<?php


namespace Vanguard\Repositories\Document;


use Illuminate\Database\Eloquent\Builder;
use Vanguard\Document;

class EloquentDocument implements DocumentRepository
{

    public function documentsAuditor(): Builder
    {
        $current_user = auth()->user();
         return Document::query()
            ->whereHas('user', function($q) use ($current_user) {
                $q->where('auditor_id', $current_user->id)
                    ->orWhere('accountant_id', $current_user->id);
            })
            ->orderByDesc('document_date');
    }
}
