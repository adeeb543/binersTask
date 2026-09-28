<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectDiscussionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'file_name' => $this->file_name,
            'file_url' => $this->file_path ? asset('storage/' . $this->file_path) : null,
            'sender' => [
                'id' => $this->sender->id ?? null,
                'name' => $this->sender->name ?? 'مستخدم',
                'type' => $this->sender_type, 
            ],
            'created_at' => $this->created_at->toIso8601String(),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}
