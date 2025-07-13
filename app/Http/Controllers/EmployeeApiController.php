<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EmployeeApiController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $employees = $this->employeeService->index($request->all());

            return new EmployeeResource(
                'success',
                'Employees retrieved successfully',
                $employees
            );

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Employees retrieved successfully',
            //     'data' => $employees,
            // ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validateCreateData($request);

            $this->employeeService->store($request);

            return response()->json([
                'status' => 'success',
                'message' => 'Employee created successfully',
                // 'data' => $employee,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all(), $id, $request->file('image')->getClientOriginalExtension());
        try {
            $this->validateCreateData($request);

            $employee = $this->employeeService->update($request, $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Employee updated successfully',
                // 'data' => $employee,
            ], 200);
        } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Employee not found',
        ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->employeeService->destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Employee deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Employee not found',
        ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function validateCreateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string|min:10',
            'position' => 'required|string',
            'division' => 'required|exists:divisions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'The name field is required.',
            'phone.min' => 'The phone field must be at least 10 digits.',
            'phone.required' => 'The phone field is required.',
            'position.required' => 'The position field is required.',
            'division.required' => 'The division field is required.',
            'image.required' => 'The image field is required.',
            'image.image' => 'The image field must be an image.',
            'image.mimes' => 'The image field must be a file of type: jpeg, png, jpg, webp.',
            'image.max' => 'The image field may not be greater than 2MB.',
        ]);
        
        return $validator->validated();
    }
}
