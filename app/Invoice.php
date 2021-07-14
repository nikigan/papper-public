<?php

namespace Vanguard;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $document_type
 * @property int $currency_id
 * @property PaymentType $payment_type
 * @property int $include_tax
 * @property string|null $note
 * @property int|null $income_type_id
 * @property-read User $creator
 * @property-read Currency $currency
 * @property-read Customer $customer
 * @property-read DocumentType $dt
 * @property-read mixed $grand_total
 * @property-read mixed $total_amount
 * @property-read IncomeType|null $income_type
 * @property-read Collection|InvoicesItem[] $invoice_items
 * @property-read int|null $invoice_items_count
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereCreatedAt( $value )
 * @method static Builder|Invoice whereCreatorId( $value )
 * @method static Builder|Invoice whereCurrencyId( $value )
 * @method static Builder|Invoice whereCustomerId( $value )
 * @method static Builder|Invoice whereDocumentType( $value )
 * @method static Builder|Invoice whereId( $value )
 * @method static Builder|Invoice whereIncludeTax( $value )
 * @method static Builder|Invoice whereIncomeTypeId( $value )
 * @method static Builder|Invoice whereInvoiceDate( $value )
 * @method static Builder|Invoice whereInvoiceNumber( $value )
 * @method static Builder|Invoice whereNote( $value )
 * @method static Builder|Invoice wherePaymentType( $value )
 * @method static Builder|Invoice whereTaxPercent( $value )
 * @method static Builder|Invoice whereUpdatedAt( $value )
 * @mixin Eloquent
 * @property Carbon|null $deleted_at
 * @method static Builder|Invoice currentUserInvoices()
 * @method static \Illuminate\Database\Query\Builder|Invoice onlyTrashed()
 * @method static Builder|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Invoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Invoice withoutTrashed()
 */
class Invoice extends Model implements Sortable {

    use SoftDeletes;

    protected $guarded = [];
    protected $with = [ 'invoice_items', 'creator', 'currency' ];

    protected static function booted() {
        parent::booted();
        static::addGlobalScope( new TableSortScope );
    }

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

    public function getGrandTotalAttribute() {
        $tax   = $this->tax_percent / 100;
        $total = $this->getTotalAmountAttribute();

        if ($this->sale) {
            $total *= (100 - $this->sale)/100;
        }

        if ( $this->include_tax ) {
            return $total;
        } else {
            return $total + ( $total / ( 1 + $tax ) ) * $tax;
        }
    }

    public function getTotalAmountAttribute() {
        $total_amount = 0;
        foreach ( $this->invoice_items as $item ) {
            $total_amount += $item->price * $item->quantity;
        }

        return $total_amount;
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
