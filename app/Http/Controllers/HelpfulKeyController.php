<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HelpfulKey;
use App\Http\Requests\HelpfulKeyRequest;

class HelpfulKeyController extends Controller
{
    public function getHelpfulKeys() {
        $helpful_keys = HelpfulKey::get(['id', 'title', 'icon', 'description']);

        return $this->sendResponse($helpful_keys);
    }

    public function store(HelpfulKeyRequest $request) {
        $data = $request->all();

        $helpful_key = isset($data['id']) ? HelpfulKey::find($data['id']) : new HelpfulKey();

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $name = strtolower(str_replace([' '], '-', $data['title']))  . '.' . $file->getClientOriginalExtension();
            $request->file('icon')->storeAs('/helpful-keys', $name, 'public');
            $data['icon'] = $name;
        }

        $helpful_key->fill($data);
        $helpful_key->save();

        return $this->sendResponse($helpful_key->refresh(), 'Helpful key saved successfully.');
    }

    public function destroy(Request $request) {
        $helpful_key = HelpfulKey::find($request->id);

        $helpful_key->delete();

        return $this->sendResponse([], 'Helpful key deleted successfully.');
    }
}
