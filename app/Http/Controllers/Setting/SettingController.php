<?php

namespace App\Http\Controllers\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function general()
    {
        $setting = Setting::first();
        return view('dashboard.setting.general', compact('setting'));
    }

    public function generalUpdate(Request $request)
    {
        try {
            $isDbHas = Setting::first();

            //logo
            if ($request->has('logo')) {
                if(isset($isDbHas->logo)){
                    $imagePath = public_path('images/setting/logo/');
                    $old_image = $imagePath . $isDbHas->logo;

                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }
                }

                $logoUploade = $request->file('logo');
                $logoName = 'logo_' . time() . '.' . $logoUploade->getClientOriginalExtension();
                $logoPath = public_path('images/setting/logo/');
                $logoUploade->move($logoPath, $logoName);
            }

            //favicon
            if ($request->has('favicon')) {
                if(isset($isDbHas->favicon)) {
                    $faviconPath = public_path('images/setting/favicon/');
                    $old_favicon_image = $faviconPath . $isDbHas->favicon;

                    if (file_exists($old_favicon_image)) {
                        unlink($old_favicon_image);
                    }
                }

                $imageUploade = $request->file('favicon');
                $imageName = 'favicon_' . time() . '.' . $imageUploade->getClientOriginalExtension();
                $imagePath = public_path('images/setting/favicon/');
                $imageUploade->move($imagePath, $imageName);
            }

            //update
            if($isDbHas) {
                $setting = Setting::findOrFail($isDbHas->id);

                $setting->site_title = $request->site_title;
                $setting->site_address = $request->site_address;
                $setting->site_description = $request->site_description;
                $setting->logo = $logoName;
                $setting->favicon = $imageName;
                $setting->update();

                return back()->with('t-success', 'Setting Updated Successfully');
            }
            //store
            else {
                $setting = new Setting();

                $setting->site_title = $request->site_title;
                $setting->site_address = $request->site_address;
                $setting->site_description = $request->site_description;
                $setting->logo = $logoName;
                $setting->favicon = $imageName;
                $setting->save();

                return back()->with('t-success', 'Setting Created Successfully');
            }

        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
