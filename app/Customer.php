<?php

namespace Vanguard;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Vanguard\Customer
 *
 * @property int $id
 * @property string $vat_number
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property int $creator_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereAddress( $value )
 * @method static Builder|Customer whereCreatedAt( $value )
 * @method static Builder|Customer whereCreatorId( $value )
 * @method static Builder|Customer whereEmail( $value )
 * @method static Builder|Customer whereId( $value )
 * @method static Builder|Customer whereName( $value )
 * @method static Builder|Customer wherePhone( $value )
 * @method static Builder|Customer whereUpdatedAt( $value )
 * @method static Builder|Customer whereVatNumber( $value )
 * @mixin Eloquent
 * @property-read Collection|Document[] $documents
 * @property-read int|null $documents_count
 * @property-read Collection|Invoice[] $invoices
 * @property-read int|null $invoices_count
 */
class Customer extends Model {
    protected $table = 'customers';

    protected $fillable = [ 'name', 'email', 'phone', 'address', 'creator_id', 'vat_number' ];


    public function creator() {
        $this->belongsTo( User::class, 'creator_id' );
    }

    public function invoices() {
        return $this->hasMany( Invoice::class );
    }

    public function documents() {
        return $this->hasMany( Document::class );
    }
}
