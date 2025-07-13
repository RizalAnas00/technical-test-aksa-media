<?php

namespace App\Traits;

trait Pagination
{
    protected function paginateData($resource) 
    {
        return [
            'current_page' => $resource->currentPage(),
            'from' => $resource->firstItem(),
            'last_page' => $resource->lastPage(),
            'links' => [
                [
                    'url' => $resource->previousPageUrl(),
                    'label' => 'pagination.previous',
                    'active' => false,
                ],
                ...collect(range(1, $resource->lastPage()))->map(function ($page) use ($resource) {
                    return [
                        'url' => $resource->url($page),
                        'label' => (string) $page,
                        'active' => $resource->currentPage() === $page,
                    ];
                }),
                [
                    'url' => $resource->nextPageUrl(),
                    'label' => 'pagination.next',
                    'active' => false,
                ],
            ],
            'per_page' => $resource->perPage(),
            'to' => $resource->lastItem(),
            'total' => $resource->total(),
            'next_page_url' => $resource->nextPageUrl(),
            'prev_page_url' => $resource->previousPageUrl(),
            'path' => $resource->path(),
        ];
    }
}
