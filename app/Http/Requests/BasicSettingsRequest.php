<?php

namespace App\Http\Requests;

class BasicSettingsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cover_video.mimetypes' => 'The cover video must be a video',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'max:191',
            'cover_text' => 'max:191',
            'sender_name' => 'max:191',
            'sender_email' => 'max:191|email',
        ];

        //  if fileType is audio
        // if ($this->hasFile('fav_icon')) {
        //     $rules['fav_icon'] = 'image';
        // }
        
        if ($this->hasFile('logo')) {
            $rules['logo'] = 'image';
        }

        //if fileType is video
        if ($this->hasFile('cover_video')) {
            $rules['cover_video'] = 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi';

        }
        return $rules;
    }
}
