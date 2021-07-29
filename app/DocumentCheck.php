<?php

namespace Vanguard;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Vanguard\DocumentCheck
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|DocumentCheck newModelQuery()
 * @method static Builder|DocumentCheck newQuery()
 * @method static Builder|DocumentCheck query()
 * @method static Builder|DocumentCheck whereCreatedAt( $value )
 * @method static Builder|DocumentCheck whereId( $value )
 * @method static Builder|DocumentCheck whereText( $value )
 * @method static Builder|DocumentCheck whereTitle( $value )
 * @method static Builder|DocumentCheck whereUpdatedAt( $value )
 * @mixin Eloquent
 */
class DocumentCheck extends Model {
    protected $guarded = [];
}
