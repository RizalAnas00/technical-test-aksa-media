<?php

namespace App\Http\Resources;

use App\Traits\Pagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
{
    use Pagination;

    public $status;
    public $message;

    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource); // $resource = ['token' => ..., 'admin' => User]
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'divisions' => collect($this->resource->items())->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                    ];
                }),
            ],
            'pagination' => $this->paginateData($this->resource),
        ];
    }
}
