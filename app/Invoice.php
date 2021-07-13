<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Interfaces\Sortable;
use Vanguard\Scopes\TableSortScope;

/**
 * Vanguard\Invoice
 *
 * @property int $id
 * @property string $invoice_number
 * @property string $invoice_date
 * @property int $customer_id
 * @property int $creator_id
 * @property float $tax_percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $document_type
 * @property int $currency_id
 * @property \Vanguard\PaymentType $payment_type
 * @property int $include_tax
 * @property string|null $note
 * @property int|null $income_type_id
 * @property-read \Vanguard\User $creator
 * @property-read \Vanguard\Currency $currency
 * @property-read \Vanguard\Customer $customer
 * @property-read \Vanguard\DocumentType $dt
 * @property-read mixed $grand_total
 * @property-read mixed $total_amount
 * @property-read \Vanguard\IncomeType|null $income_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\InvoicesItem[] $invoice_items
 * @property-read int|null $invoice_items_count
 * @method static Builder|\Vanguard\Invoice newModelQuery()
 * @method static Builder|\Vanguard\Invoice newQuery()
 * @method static Builder|\Vanguard\Invoice query()
 * @method static Builder|\Vanguard\Invoice whereCreatedAt( $value )
 * @method static Builder|\Vanguard\Invoice whereCreatorId( $value )
 * @method static Builder|\Vanguard\Invoice whereCurrencyId( $value )
 * @method static Builder|\Vanguard\Invoice whereCustomerId( $value )
 * @method static Builder|\Vanguard\Invoice whereDocumentType( $value )
 * @method static Builder|\Vanguard\Invoice whereId( $value )
 * @method static Builder|\Vanguard\Invoice whereIncludeTax( $value )
 * @method static Builder|\Vanguard\Invoice whereIncomeTypeId( $value )
 * @method static Builder|\Vanguard\Invoice whereInvoiceDate( $value )
 * @method static Builder|\Vanguard\Invoice whereInvoiceNumber( $value )
 * @method static Builder|\Vanguard\Invoice whereNote( $value )
 * @method static Builder|\Vanguard\Invoice wherePaymentType( $value )
 * @method static Builder|\Vanguard\Invoice whereTaxPercent( $value )
 * @method static Builder|\Vanguard\Invoice whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class Invoice extends Model implements Sortable {

    protected $guarded = [];
    protected $with = ['invoice_items', 'creator', 'currency'];

    public function customer() {
        return $this->belongsTo( Customer::class, 'customer_id' );
    }

    public function creator() {
        return $this->belongsTo( User::class );
    }

    public function invoice_items() {
        return $this->hasMany( InvoicesItem::class );
    }

    public function dt() {
        return $this->belongsTo( DocumentType::class, 'document_type' );
    }

    public function currency() {
        return $this->belongsTo( Currency::class, 'currency_id' );
    }

    public function payment_type() {
        return $this->belongsTo( PaymentType::class, 'payment_type' );
    }

    public function income_type() {
        return $this->belongsTo( IncomeType::class );
    }

    public function getTotalAmountAttribute() {
        $total_amount = 0;
        foreach ( $this->invoice_items as $item ) {
            $total_amount += $item->price * $item->quantity;
        }

        return $total_amount;
    }

    public function getGrandTotalAttribute() {
        $tax   = $this->tax_percent / 100;
        $total = $this->getTotalAmountAttribute();

        if ( $this->include_tax ) {
            return $total;
        } else {
            return $total + ( $total / ( 1 + $tax ) ) * $tax;
        }
    }

    protected static function booted() {
        parent::booted();
        static::addGlobalScope( new TableSortScope );
    }

    public function sort_table_name(): string {
        return "invoices";
    }

    public function scopeCurrentUserInvoices( Builder $query ) {
        $current_user = auth()->user();

        if ( $current_user->hasRole( 'Auditor' ) || $current_user->hasRole( 'Accountant' ) ) {
            $clients = $current_user->clients()->pluck( 'id' )->toArray();
            return $query->whereIn( 'creator_id', $clients );
        } else {
            return $query->where( 'creator_id', $current_user->id );
        }
    }

}
