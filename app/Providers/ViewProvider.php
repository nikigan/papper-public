<?php

namespace Vanguard\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Vanguard\Announcements\Announcements;
use Vanguard\Document;
use Vanguard\Invoice;
use Vanguard\Support\Plugins\RolesAndPermissions;
use Vanguard\Support\Plugins\Reports;
use Vanguard\Support\Plugins\Users;
use Vanguard\UserActivity\UserActivity;
use function foo\func;

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

            /*$invoices = Invoice::query()->where('creator_id', $id)->get();

            foreach ($invoices as $key => $value) {
                $tax_k = $value->include_tax ? 1 : -1;
                $invoices[$key]['total_amount'] = $value->total_amount + ($tax_k * $value->tax_percent/100 * $value->include_tax);
                $invoices[$key]['vat'];

            }
            dump($documents);
            dd($invoices);*/

            $view->with(['documents' => $documents, 'sum' => $sum, 'vat' => $vat, 'sum_class' => $sum_class]);
        });

        /*View::composer('partials.sidebar.main', function(\Illuminate\View\View $view) {
           if (auth()->user()->hasRole('Admin')) {
               $plugins = [
                   Users::class,
                   UserActivity::class,
                   RolesAndPermissions::class,
                   Settings::class,
                   Announcements::class
               ];

               $view->with(compact('plugins'));
           }
        });*/
    }
}
