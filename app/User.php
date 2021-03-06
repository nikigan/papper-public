<?php

namespace Vanguard;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
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
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property \Illuminate\Support\Carbon|null $last_login
 * @property string $status
 * @property int|null $two_factor_country_code
 * @property int|null $two_factor_phone
 * @property string|null $two_factor_options
 * @property string|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property-read \Vanguard\User|null $accountant
 * @property-read \Vanguard\User|null $auditor
 * @property-read \Vanguard\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read bool $using_two_factor_auth
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Vanguard\OrganizationType|null $organization_type
 * @property-read \Vanguard\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereAccountantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereAnnouncementsLastReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereAuditorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereDefaultIncomeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereMhAdvances($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereMhDeductions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereOrganizationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User wherePortfolio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereReportPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereSocialSecurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereSocialSecurityNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereTwoFactorCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereTwoFactorOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereTwoFactorPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereVatNumber($value)
 * @mixin \Eloquent
 * @property int $notify
 * @property int $notification_rate
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereNotificationRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\User whereNotify($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $clients
 * @property-read int|null $clients_count
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
        'email', 'password', 'username', 'first_name', 'last_name', 'phone', 'avatar',
        'address', 'country_id', 'birthday', 'last_login', 'confirmation_token', 'status',
        'remember_token', 'role_id', 'email_verified_at', 'accountant_id', 'auditor_id',
        'organization_type_id', 'vat_number', 'passport', 'report_period', 'tax_percent', 'social_security', 'social_security_number', 'mh_advances', 'mh_deductions', 'portfolio', 'organization_type_id', 'default_income_type_id', 'notify', 'notification_rate'

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
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = trim($value) ?: null;
    }

    public function gravatar()
    {
        $hash = hash('md5', strtolower(trim($this->attributes['email'])));

        return sprintf("https://www.gravatar.com/avatar/%s?size=150", $hash);
    }

    public function isUnconfirmed()
    {
        return $this->status == UserStatus::UNCONFIRMED;
    }

    public function isActive()
    {
        return $this->status == UserStatus::ACTIVE;
    }

    public function isBanned()
    {
        return $this->status == UserStatus::BANNED;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'creator_id');
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function accountant()
    {
        return $this->belongsTo(User::class, 'accountant_id');
    }

    public function clients()
    {
        $role = Role::where('name', 'Accountant')->first();
        return $this->hasMany(User::class, 'auditor_id')->where('role_id', "<>", $role->id);
    }

    public function organization_type()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this)->send(new ResetPassword($token));

        event(new RequestedPasswordResetEmail($this));
    }

    public function sendEmailAccountCreated($token)
    {
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
