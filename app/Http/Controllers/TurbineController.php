<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TurbineController extends Controller
{
    /**
     * Divisors and corresponding messages
     */
    const STATUS_CODES = [
        3 => 'Coating Damage',
        5 => 'Lightning Strike',
    ];

    /**
     * Get the application data
     */
    public function index(): JsonResponse
    {
        $data = $this->inspectTurbines();
        return response()->json($data);
    }

    /**
     * Get the status for an individual turbine
     */
    public function show($turbine): JsonResponse
    {
        return response()->json($this->turbineInspect($turbine));
    }

    /**
     * Get the status codes
     */
    public function codes(): JsonResponse
    {
        return response()->json(self::STATUS_CODES);
    }

    /**
     * Map over turbines and inspect each
     */
    private function inspectTurbines(): Array
    {
        return array_map(
            array($this, 'turbineInspect'),
            range(1, 100)
        );
    }

    /**
     * Inspect a turbine
     * 
     * @param string $turbineNumber
     */
    private function turbineInspect(int $turbineNumber): array
    {
        $output = [];
        $status = '';
        foreach (self::STATUS_CODES as $code => $message) {
            if ($turbineNumber % $code === 0) {
                $output[] = $message;
            }
        }

        if (!empty($output)) {
            $status =  implode(" and ", $output);
        }

        return ['id' => $turbineNumber, 'status' => $status];
    }
}
