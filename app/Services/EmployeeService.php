<?php

namespace App\Services;

use App\Models\Employee;
use BcMath\Number;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Traits\SaveImageEmployee;

class EmployeeService
{
    use SaveImageEmployee;

    public function index($params = [])
    {
        $limit = $params['limit'] ?? 10;
        $name = $params['name'] ?? null;
        $divisionId = $params['division_id'] ?? null;

        // Logic for listing all Employees
        $employees = Employee::query()
            ->where('name', 'like', "%{$name}%");

        if ($divisionId) {
            $employees->where('division_id', $divisionId);
        }

        return $employees
            ->with('division')
            ->paginate($limit);
    }

    public function store($request)
    {
        $request = $this->saveImage($request);

        $employee = Employee::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'position' => $request->position,
            'image' => $request->image,
            'division_id' => $request->division
        ]);


        return $employee;
    }

    public function update($request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request = $this->saveImage($request, $employee);

        $employee->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'position' => $request->position,
            'division_id' => $request->division,
            'image' => $request->image ?? $employee->image,
        ]);

        return $employee;
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
    }
}
