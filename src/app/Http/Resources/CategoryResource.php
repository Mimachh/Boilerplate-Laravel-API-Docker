<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'titleSEO' => $this->titleSEO,
            'descriptionSEO' => $this->descriptionSEO,
            'keywordsSEO' => $this->keywordsSEO,
            'status' => $this->status
        ];
    }
}
