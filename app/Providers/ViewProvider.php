<?php

namespace Vanguard\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Vanguard\Document;

class ViewProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('document.partials.table', function (\Illuminate\View\View $view) {
            $id = Route::current()->parameters()['client'] ?? false;
            /*if ($id) {
                $documents = Document::query()->where('user_id', $id)->orderByDesc('document_date')->get();
            } else {
                $documents = Document::query()->orderByDesc('document_date')->get();
            }*/
            $documents = $view->getData()['documents'] ?? Document::query()->where('user_id', $id)->orderByDesc('document_date')->paginate(10);
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
            $view->with(['documents' => $documents, 'sum' => $sum, 'vat' => $vat, 'sum_class' => $sum_class]);
        });
    }
}
