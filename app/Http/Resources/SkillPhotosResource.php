<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SkillPhotosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $skills = $this->user_skills()->distinct('skill_id')->get();
        
        $result = $skills->map(function ($skill) {
            return [$skill->skill_id => $skill->skill_photos()->toArray()];
        })->toArray();

        dd($result);

        return $result;

        // foreach ($skills as $skill) {
        //     $photos = $skill->skill_photos();
        //     $result[] = [$skill->skill_id =>$photos->toArray()];
        // }

        // return $result;
    }
}
