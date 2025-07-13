<?php

namespace App\Http\Controllers;

use App\Services\NilaiService;
use Exception;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    protected $nilaiService;

    public function __construct(NilaiService $nilaiService)
    {
        $this->nilaiService = $nilaiService;
    }

    public function nilaiRt() 
    {
        try {
            $data = $this->nilaiService->nilaiRt();

            return response()->json([
                'status' => 'success',
                'message' => 'Nilai RT retrieved successfully',
                'data' => $data->original
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function nilaiSt() 
    {
        try {
            $data = $this->nilaiService->nilaiSt();

            return response()->json([
                'status' => 'success',
                'message' => 'Nilai ST retrieved successfully',
                'data' => $data->original
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
