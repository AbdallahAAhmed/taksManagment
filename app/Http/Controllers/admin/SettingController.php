<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{

    function __construct()
    {
         $this->middleware(['auth','ISManager']);
    }

    public function edit($id)
    {

        $setting = Setting::where('id',$id)->first();

        return view('admin.setting.edit', compact('setting'));
    }

    public function update(Request $request,$id)
    {
        $setting = Setting::find($id);
        $array = [];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . Str::random(12) . '.' . $file->getClientOriginalExtension();
            if (File::exists(public_path('/images/settings/logo/') . $setting->logo)) {
                File::delete(public_path('/images//settings/logo/') . $setting->logo);
            }
            $file->move(public_path('/images/settings/logo/'), $fileName);
            $array = ['logo' => $fileName] + $array;
        }

        if ($request->title != $setting->title) {
            $array['title'] = $request->title;
        }

        if ($request->contact_number != $setting->contact_number) {
            $array['contact_number'] = $request->contact_number;
        }
         if ($request->email != $setting->email) {
            $array['email'] = $request->email;
        }

        if ($request->sub_title != $setting->sub_title) {
            $array['sub_title'] = $request->sub_title;
        }

        if ($request->facebook_url != $setting->facebook_url) {
            $array['facebook_url'] = $request->facebook_url;
        }

        if ($request->twitter_url != $setting->twitter_url) {
            $array['twitter_url'] = $request->twitter_url;
        }

        if ($request->instagram_url != $setting->instagram_url) {
            $array['instagram_url'] = $request->instagram_url;
        }
        if (!empty($array)) {
            $setting->update($array);
        }
        return response()->json(['status' => 1, 'msg' => 'Setting Updated', 'data' => $array]);
    }

}
