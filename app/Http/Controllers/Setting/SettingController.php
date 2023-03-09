<?php

namespace App\Http\Controllers\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function general()
    {
        $data = Setting::first();
        return view('dashboard.setting.general', compact('data'));
    }

    public function generalUpdate(Request $request)
    { 
        try {
            if (!$request->id) {
                $request->validate([
                    'site_title' => 'required',
                    'site_address' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'location' => 'required',
                    'logo' => 'required',
                    'favicon' => 'required',
                ]);

                $data = new Setting();
            } else {
                $data = Setting::findOrFail($request->id);
            }
            if ($request->file('logo')) {
                $file = $request->file('logo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/images/setting/logo/'), $filename);
                $data->logo = $filename;
            }
            if ($request->file('favicon')) {
                $file = $request->file('favicon');
                $filenamefavicon = time() . $file->getClientOriginalName();
                $file->move(public_path('/images/setting/favicon/'),  $filenamefavicon);
                $data->favicon =  $filenamefavicon;
            }
            $data->site_title = $request->site_title;
            $data->site_address = $request->site_address;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->location = $request->location;
            $data->map = $request->map;
            $data->site_description = $request->site_description;

            if (!$request->id) {
                $data->save();
                return back()->with('t-success', 'Setting Created Successfully');
            } else {
                $data->update();
                return back()->with('t-success', 'Setting updated Successfully');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
       
    }
}
