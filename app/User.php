<?php

namespace Vanguard;

use Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Mail;
use Vanguard\Events\User\RequestedPasswordResetEmail;
use Vanguard\Interfaces\Sortable;
use Vanguard\Mail\ClientRegistered;
use Vanguard\Mail\ResetPassword;
use Vanguard\Presenters\Traits\Presentable;
use Vanguard\Presenters\UserPresenter;
use Vanguard\Scopes\TableSortScope;
use Vanguard\Services\Auth\TwoFactor\Authenticatable as TwoFactorAuthenticatable;
use Vanguard\Services\Auth\TwoFactor\Contracts\Authenticatable as TwoFactorAuthenticatableContract;
use Vanguard\Support\Authorization\AuthorizationUserTrait;
use Vanguard\Support\CanImpersonateUsers;
use Vanguard\Support\Enum\UserStatus;

/**
 * Vanguard\User
 *
 * @property int $id
 * @property string $email
 * @property string|null $username
 * @property string $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string|null $avatar
 * @property string|null $address
 * @property int|null $country_id
 * @property int $role_id
 * @property Carbon|null $birthday
 * @property Carbon|null $last_login
 * @property string $status
 * @property int|null $two_factor_country_code
 * @property int|null $two_factor_phone
 * @property string|null $two_factor_options
 * @property string|null $email_verified_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $announcements_last_read_at
 * @property int|null $auditor_id
 * @property int|null $accountant_id
 * @property int|null $organization_type_id
 * @property string|null $vat_number
 * @property string|null $passport
 * @property float|null $tax_percent
 * @property float $social_security
 * @property int $report_period
 * @property string|null $social_security_number
 * @property int $default_income_type_id
 * @property string|null $mh_advances
 * @property string|null $mh_deductions
 * @property string|null $portfolio
 * @property-read User|null $accountant
 * @property-read User|null $auditor
 * @property-read Country|null $country
 * @property-read Collection|Document[] $documents
 * @property-read int|null $documents_count
 * @property-read bool $using_two_factor_auth
 * @property-read Collection|Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read OrganizationType|null $organization_type
 * @property-read Role $role
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAccountantId( $value )
 * @method static Builder|User whereAddress( $value )
 * @method static Builder|User whereAnnouncementsLastReadAt( $value )
 * @method static Builder|User whereAuditorId( $value )
 * @method static Builder|User whereAvatar( $value )
 * @method static Builder|User whereBirthday( $value )
 * @method static Builder|User whereCountryId( $value )
 * @method static Builder|User whereCreatedAt( $value )
 * @method static Builder|User whereDefaultIncomeTypeId( $value )
 * @method static Builder|User whereEmail( $value )
 * @method static Builder|User whereEmailVerifiedAt( $value )
 * @method static Builder|User whereFirstName( $value )
 * @method static Builder|User whereId( $value )
 * @method static Builder|User whereLastLogin( $value )
 * @method static Builder|User whereLastName( $value )
 * @method static Builder|User whereMhAdvances( $value )
 * @method static Builder|User whereMhDeductions( $value )
 * @method static Builder|User whereOrganizationTypeId( $value )
 * @method static Builder|User wherePassport( $value )
 * @method static Builder|User wherePassword( $value )
 * @method static Builder|User wherePhone( $value )
 * @method static Builder|User wherePortfolio( $value )
 * @method static Builder|User whereRememberToken( $value )
 * @method static Builder|User whereReportPeriod( $value )
 * @method static Builder|User whereRoleId( $value )
 * @method static Builder|User whereSocialSecurity( $value )
 * @method static Builder|User whereSocialSecurityNumber( $value )
 * @method static Builder|User whereStatus( $value )
 * @method static Builder|User whereTaxPercent( $value )
 * @method static Builder|User whereTwoFactorCountryCode( $value )
 * @method static Builder|User whereTwoFactorOptions( $value )
 * @method static Builder|User whereTwoFactorPhone( $value )
 * @method static Builder|User whereUpdatedAt( $value )
 * @method static Builder|User whereUsername( $value )
 * @method static Builder|User whereVatNumber( $value )
 * @mixin Eloquent
 * @property int $notify
 * @property int $notification_rate
 * @method static Builder|User whereNotificationRate( $value )
 * @method static Builder|User whereNotify( $value )
 * @property-read Collection|User[] $clients
 * @property-read int|null $clients_count
 * @property int $can_change_invoice_number
 * @method static Builder|User whereCanChangeInvoiceNumber( $value )
 */
class User extends Authenticatable implements TwoFactorAuthenticatableContract, MustVerifyEmail, Sortable
{
    use TwoFactorAuthenticatable,
        CanResetPassword,
        Presentable,
        AuthorizationUserTrait,
        Notifiable,
        CanImpersonateUsers,
        HasApiTokens;

    protected $presenter = UserPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $dates = ['last_login', 'birthday'];

    protected $fillable = [
        'email',
        'password',
        'username',
        'first_name',
        'last_name',
        'phone',
        'avatar',
        'address',
        'country_id',
        'birthday',
        'last_login',
        'confirmation_token',
        'status',
        'remember_token',
        'role_id',
        'email_verified_at',
        'accountant_id',
        'auditor_id',
        'organization_type_id',
        'vat_number',
        'passport',
        'report_period',
        'tax_percent',
        'social_security',
        'social_security_number',
        'mh_advances',
        'mh_deductions',
        'portfolio',
        'organization_type_id',
        'default_income_type_id',
        'notify',
        'notification_rate',
        'can_change_invoice_number'

    ];
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setBirthdayAttribute($value) {
        $this->attributes['birthday'] = trim($value) ?: null;
    }

    public function gravatar() {
        $hash = hash('md5', strtolower(trim($this->attributes['email'])));

        return sprintf("https://www.gravatar.com/avatar/%s?size=150", $hash);
    }

    public function isUnconfirmed() {
        return $this->status == UserStatus::UNCONFIRMED;
    }

    public function isActive() {
        return $this->status == UserStatus::ACTIVE;
    }

    public function isBanned() {
        return $this->status == UserStatus::BANNED;
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'creator_id');
    }

    public function auditor() {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function accountant() {
        return $this->belongsTo(User::class, 'accountant_id');
    }

    public function clients() {
        $role = Role::where('name', 'Accountant')->first();

        return $this->hasMany(User::class, 'auditor_id')->where('role_id', "<>", $role->id);
    }

    public function organization_type() {
        return $this->belongsTo( OrganizationType::class, 'organization_type_id' );
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        Mail::to($this)->send(new ResetPassword($token));

        event(new RequestedPasswordResetEmail($this));
    }

    public function sendEmailAccountCreated($token) {
        Mail::to($this)->send(new ClientRegistered($token, $this));
    }

    protected static function booted() {
        parent::booted();
        static::addGlobalScope(new TableSortScope);
    }


    public function sort_table_name(): string {
        return "users";
    }
}
