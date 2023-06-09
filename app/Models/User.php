<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use function Illuminate\Events\queueable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'api_token',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * GetCapacity
     *
     * @return int
     */
    public function getCapacity(): int
    {
        return (int)config('payment.capacity')[$this->subscribed('default')];
    }    

    public function getUsedCapacity(): int
    {
        return (int)$this->photos()->withTrashed()->selectRaw('sum(capacity) as capacity')->first()->capacity
             + (int)$this->albums()->withTrashed()->selectRaw('sum(capacity) as capacity')->first()->capacity;
    }    

    public function checkCapacityOver(): bool
    {
        return $this->getUsedCapacity() >= $this->getCapacity();
    }

    /**
     * Relation
     */
    public function photos()  { return $this->hasMany(Photo::class); }
    public function albums()  { return $this->hasMany(Album::class); }
    public function categories() { return $this->hasMany(Category::class); }
    public function options()   { return $this->hasMany(Option::class); }
    public function activites() { return $this->hasMany(Activity::class); }

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(queueable(function($customer){
            if($customer->hasStripeId()){
                $customer->syncStripeCustomerDetails();
            }
        }));
    }
}
