<?php

namespace App\Http\Controllers;

use App\Http\Requests\FooterSocialLinkRequest;
use App\Models\FooterSocialLink;
use Illuminate\Http\Request;

class FooterSocialLinkController extends Controller
{
    public function getSocialLinks()
    {
        $socialLinks = FooterSocialLink::get(['id', 'title', 'url', 'link', 'icon', 'is_display']);

        return $this->sendResponse($socialLinks);
    }

    public function store(FooterSocialLinkRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $name = str_replace([' '], '-', $data['title'])  . '.' . $file->getClientOriginalExtension();
            $request->file('icon')->storeAs('/', $name, 'public');
            $data['icon'] = $name;
        }

        if (isset($data['id'])) {
            $socialLink = FooterSocialLink::find($data['id']);
        } else {
            $socialLink = new FooterSocialLink();
        }

        $data['is_display'] = isset($data['is_display']) ? $data['is_display'] : 0;

        $socialLink->fill($data);
        $socialLink->save();

        return $this->sendResponse($socialLink->refresh(), 'Social Link created successfully.');
    }

    public function destroy(Request $request)
    {
        $socialLink = FooterSocialLink::find($request->id);

        if (!$socialLink) {
            return $this->sendError('Social Link not found.');
        }

        $socialLink->delete();

        return $this->sendResponse([], 'Social Link deleted successfully.');
    }
}
