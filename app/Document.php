<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Vanguard\Interfaces\Sortable;
use Vanguard\Presenters\DocumentPresenter;
use Vanguard\Presenters\Traits\Presentable;
use Vanguard\Scopes\TableSortScope;
use Vanguard\Support\Enum\DocumentStatus;

/**
 * Vanguard\Document
 *
 * @property int $id
 * @property string|null $file
 * @property int $user_id
 * @property string|null $document_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property string|null $document_number
 * @property int|null $document_type
 * @property float|null $sum
 * @property float|null $sum_without_vat
 * @property float|null $vat
 * @property string|null $document_date
 * @property int|null $currency_id
 * @property int|null $vendor_id
 * @property int|null $expense_type_id
 * @property string|null $note
 * @property int|null $document_type_id
 * @property int|null $income_type_id
 * @property int|null $customer_id
 * @property-read \Vanguard\Currency|null $currency
 * @property-read \Vanguard\Customer|null $customer
 * @property-read \Vanguard\DocumentType|null $dt
 * @property-read \Vanguard\ExpenseGroup $expense_group
 * @property-read \Vanguard\ExpenseType|null $expense_type
 * @property-read \Vanguard\IncomeType|null $income_type
 * @property-read \Vanguard\User $user
 * @property-read \Vanguard\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereCurrencyId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereCustomerId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereDocumentDate( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereDocumentNumber( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereDocumentText( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereDocumentType( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereDocumentTypeId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereExpenseTypeId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereFile( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereIncomeTypeId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereNote( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereStatus( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereSum( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereSumWithoutVat( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereUserId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereVat( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Document whereVendorId( $value )
 * @mixin \Eloquent
 * @property Carbon|null $deleted_at
 * @method static Builder|Document currentYear()
 * @method static \Illuminate\Database\Query\Builder|Document onlyTrashed()
 * @method static Builder|Document waiting()
 * @method static Builder|Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Document withoutTrashed()
 */
class Document extends Model implements Sortable {
    use Presentable, SoftDeletes;

    protected $presenter = DocumentPresenter::class;
    protected $fillable = [
        'file',
        'user_id',
        'document_number',
        'sum',
        'sum_without_vat',
        'vat',
        'document_type',
        'status',
        'document_date',
        'vendor_id',
        'currency_id',
        'expense_type_id',
        'note',
        'document_type_id',
        'income_type_id',
        'customer_id'
    ];

    public function user() {
        return $this->belongsTo( 'Vanguard\User' );
    }

    public function currency() {
        return $this->belongsTo( Currency::class );
    }

    public function vendor() {
        return $this->belongsTo( Vendor::class );
    }

    public function customer() {
        return $this->belongsTo( Customer::class );
    }

    public function expense_type() {
        return $this->belongsTo( ExpenseType::class, 'expense_type_id' );
    }

    public function expense_group() {
        return $this->belongsTo( ExpenseGroup::class );
    }

    public function income_type() {
        return $this->belongsTo( IncomeType::class, 'income_type_id' );
    }

    public function dt() {
        return $this->belongsTo( DocumentType::class, 'document_type_id' );
    }

    public function getDate() {
        return Carbon::parse( $this->created_at )->format( 'H:i d.m.Y' );
    }

    public function getDocumentDate() {
        return Carbon::parse( $this->document_date )->format( config( 'app.date_format' ) );
    }

    public function getDocumentDateAttribute( $value ) {
        return Carbon::parse( $value )->format( config( 'app.date_format' ) );
    }

    public function getConvertedVat() {
        return $this->vat / $this->currency->value;
    }

    public function getConvertedSum() {
        return $this->sum / $this->currency->value;
    }

    protected static function booted() {
        parent::booted();
        static::addGlobalScope( new TableSortScope );
    }

    public function sort_table_name(): string {
        return "documents";
    }

    public function scopeWaiting( Builder $query ) {
        return $query->where( 'status', DocumentStatus::UNCONFIRMED );
    }

    public function scopeCurrentYear( Builder $query ) {
        return $query->whereYear( 'document_date', '=', now()->year );
    }
}
