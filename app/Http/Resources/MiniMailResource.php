<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MiniMailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'htmlContent' => $this->html_content,
            'subject' => $this->subject,
            'status' => $this->status,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'attachmentsCount' => $this->attachments_count ?? 0,
            'sentAt' => $this->sent_at ? $this->sent_at->format('c') : null,
            'createdAt' => $this->created_at ? $this->created_at->format('c') : null,
            'updatedAt' => $this->updated_at ? $this->updated_at->format('c') : null,
        ];
    }
}
