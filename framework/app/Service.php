<?php

namespace App;

use Exception;
use Carbon\Carbon;
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
        'cron',
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
     * Get full status summary of all the services registered.
     *
     * @param  integer $minutesAgo
     * @return array
     */
    public function fullStatus($minutesAgo = 15)
    {
        $cacheTime = config('app.debug') ? 0 : 0.5;

        return app('cache')->remember('Service.fullStatus', $cacheTime, function () use ($minutesAgo) {
            $services = $this->all();

            $servicesSummary = [
                'operational'    => true,
                'brokeRecently'  => false,
                'healthStatus'   => Status::HEALTHY,
                'checks'         => 0,
                'lastCheck'      => null,
                'services'       => $services->count(),
                'summaries'      => [],
            ];

            foreach ($services as $service) {
                $serviceStatus = $service->status($minutesAgo);

                $serviceDetails = array_only($service->toArray(), [
                    'id','name','url','type','meta'
                ]);

                $servicesSummary['summaries'][] = $serviceDetails + ['summary' => $serviceStatus];

                if ($serviceStatus['broken'] === true) {
                    $servicesSummary['operational'] = false;
                }

                if ($serviceStatus['brokeRecently'] === true) {
                    $servicesSummary['brokeRecently'] = true;
                }

                $servicesSummary['checks'] += $serviceStatus['checks'];

                $healthStatus = $serviceStatus['healthStatus'];

                if ($healthStatus === Status::WARNING AND $servicesSummary['healthStatus'] !== Status::CRITICAL) {
                    $servicesSummary['healthStatus'] = Status::WARNING;
                }

                else if ($healthStatus === Status::CRITICAL) {
                    $servicesSummary['healthStatus'] = Status::CRITICAL;
                }
            }

            if ($lastStatus = Status::recent(1)->first()) {
                $servicesSummary['lastCheck'] = $lastStatus->created_at;
            }

            return $servicesSummary;
        });
    }

    /**
     * Generate a quick status summary for a service.
     *
     * @param  integer $minutesAgo
     * @return array|false
     */
    public function status($minutesAgo = 15)
    {
        $minutesAgo = (int) $minutesAgo;

        if ($minutesAgo < 5 OR $minutesAgo > (60*24*31)) {
            throw new Exception("Minutes are out of range.");
        }

        if ($this->exists) {
            $statusesSince = Carbon::now()->subMinutes($minutesAgo);

            $service = static::with(['statuses' => function ($statuses) use ($statusesSince) {
                $statuses->where('created_at', '>=', $statusesSince);
            }])->find($this->id);

            $checksAvailable = $service->statuses->count();

            $serviceStatus = [
                'broken'        => ($checksAvailable > 0 && ! $service->isOk()),
                'brokeRecently' => false,
                'breaks'        => 0,
                'checks'        => $service->statuses->count(),
                'healthStatus'  => Status::HEALTHY,
            ];

            $count = $serviceStatus['checks'];

            foreach ($service->statuses as $status) {
                $statusOk = $status->isResponseOk();

                if ( ! $statusOk) {
                    $serviceStatus['breaks']++;
                }

                // Check if the service broke within the last checks...
                if ($count <= 10 && ! $serviceStatus['brokeRecently'] && ! $statusOk) {
                    $serviceStatus['brokeRecently'] = true;
                }

                $count--;
            }

            $breaks = $serviceStatus['breaks'];

            $criticalThreshold = $breaks >= round($serviceStatus['checks'] * 0.5);
            $warningThreshold  = $breaks >= round($serviceStatus['checks'] * 0.2);

            if ($criticalThreshold && $checksAvailable >= 1) {
                $serviceStatus['healthStatus'] = Status::CRITICAL;
            }

            else if ($warningThreshold) {
                $serviceStatus['healthStatus'] = Status::WARNING;
            }

            return $serviceStatus;
        }

        return false;
    }

    /**
     * Shorter alias for isServiceOk() method.
     *
     * @return boolean
     */
    public function isOk()
    {
        return $this->isServiceOk();
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