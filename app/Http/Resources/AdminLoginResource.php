<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminLoginResource extends JsonResource
{
    public $status;
    public $message;

    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource); // $resource = ['token' => ..., 'admin' => User]
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray(Request $request): array
    {
        // Pastikan resource bukan null
        if (!$this->resource || !isset($this->resource['admin'])) {
            return [
                'status' => 'error',
                'message' => 'Internal login resource error',
                'data' => null,
            ];
        }

        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'token' => $this->resource['token'],
                'admin' => [
                    'id' => $this->resource['admin']->admin->id,
                    'name' => $this->resource['admin']->admin->name,
                    'username' => $this->resource['admin']->username,
                    'phone' => $this->resource['admin']->admin->phone,
                    'email' => $this->resource['admin']->email,
                ],
            ],
        ];
    }
}

