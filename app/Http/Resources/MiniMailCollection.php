<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MiniMailCollection extends ResourceCollection
{
    public $collects = MiniMailResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'current_page' => $this->currentPage(),
            'first_page_url' => $this->url(1),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'last_page_url' => $this->url($this->lastPage()),
            'next_page_url' => $this->nextPageUrl(),
            'per_page' => $this->perPage(),
            'prev_page_url' => $this->previousPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }

    // public function collect($collection)
    // {
    //     $rows = [];
    //     foreach ($collection as $key => $row) {
    //         $rows[] = [
    //             // 'id' => $row->id,
    //             // 'from' => $row->from,
    //             // 'to' => $row->to,
    //             // 'htmlContent' => $row->html_content,
    //             // 'status' => $row->status,
    //             // 'createdAt' => $row->created_at->format('c') ?? null,
    //             // 'updatedAt' => $row->updated_at->format('c') ?? null,
    //         ];
    //     }
    //     return $rows;
    // }
}
