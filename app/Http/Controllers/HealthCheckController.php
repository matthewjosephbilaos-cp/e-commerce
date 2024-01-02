<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;

class HealthCheckController extends Controller
{
    public function index()
    {
        $status = 200; // Default status code is OK

        // Check database connection
        try {
            DB::connection()->getPdo();
            $dbStatus = 'OK';
        } catch (\Exception $e) {
            $status = 500;
            $dbStatus = 'Unable to connect to the database: ' . $e->getMessage();
        }

        // Check Redis connection
        try {
            Redis::ping();
            $redisStatus = 'OK';
        } catch (\Exception $e) {
            $status = 500;
            $redisStatus = 'Unable to connect to Redis: ' . $e->getMessage();
        }

        // Check Horizon status
        $horizonCurrentStatus = $this->horizonCurrentStatus();
        if ($horizonCurrentStatus === 'running') {
            $horizonStatus = 'OK';
        } else {
            // Site is still healthy but horizon is not running
            $horizonStatus = 'Horizon is currently ' . $horizonCurrentStatus;
        }

        return response()->json([
            'status' => $status,
            'redis_status' => $redisStatus,
            'db_status' => $dbStatus,
            'horizon_status' => $horizonStatus,
        ], $status);
    }

    protected function horizonCurrentStatus()
    {
        if (!$masters = app(MasterSupervisorRepository::class)->all()) {
            return 'inactive';
        }

        return collect($masters)->every(function ($master) {
            return $master->status === 'paused';
        }) ? 'paused' : 'running';
    }
}
