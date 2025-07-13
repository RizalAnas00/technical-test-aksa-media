<?php

namespace App\Http\Controllers;

use App\Http\Resources\DivisionResource;
use App\Services\DivisionService;
use Exception;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    protected $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->divisionService = $divisionService;
    }

    public function index(Request $request)
    {
        try {
            $divisions = $this->divisionService->index($request->all());

            return new DivisionResource(
                'success',
                'Divisions retrieved successfully',
                $divisions
            );

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Divisions retrieved successfully',
            //     'data' => $divisions
            // ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
