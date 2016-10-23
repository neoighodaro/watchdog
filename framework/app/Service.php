<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model {

    use SoftDeletes;

    /**
     * Items to load per page.
     *
     * @var integer
     */
    protected $perPage = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'name',
        'type',
        'meta',
        'user_id',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['meta' => 'object'];

    /**
     * Eager-load the relationships.
     *
     * @var array
     */
    protected $with = ['user', 'statuses'];

    /**
     * Allowed types of services.
     *
     * @var array
     */
    protected $allowedTypes = [
        'HTTP(S)' => 'http',
    ];

    /**
     * Get the allowed types of services.
     *
     * @return array
     */
    public function allowedTypes()
    {
        return $this->allowedTypes;
    }

    /**
     * Checks to see if the service status checker has run
     * at least once.
     *
     * @return boolean
     */
    public function hasRunAtLeastOnce()
    {
        if ($this->exists) {
            return $this->statuses->count() > 0;
        }

        return false;
    }

    /**
     * Checks to see if the service is running okay.
     *
     * @return boolean
     */
    public function isServiceOk()
    {
        if ($this->exists && $this->hasRunAtLeastOnce()) {
            return (bool) $this->statuses->last()->isResponseOk();
        }

        return false;
    }

    /**
     * Get the user that added the service.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the statuses associated with this service.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(Status::class, 'service_id');
    }
}