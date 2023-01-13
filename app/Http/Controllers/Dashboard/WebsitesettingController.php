<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WebsitesettingController extends Controller
{
    public function index()
    {
        // $settings = WebsiteSetting::all();
        $categories = Category::all();
        return view('Dashboard.website_setting.index', compact('categories'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'welcome_text_ar' => "nullable|string",
            'welcome_text_en' => "nullable|string",
            'header_phone' => "nullable|string",
            'website_title_ar' => "nullable|string",
            'website_title_en' => "nullable|string",
            'header_logo' => "nullable|image",
            'header_icon' => "nullable|image",
            'secondary_color' => "nullable|string",
            'primary_color' => "nullable|string",
            'flash_news_ar' => "nullable|array",
            'flash_news_en' => "nullable|array",
            'categories' => "nullable|array",
            'categories_2' => "nullable|array",
            'top_collection_text_ar' => "nullable|string",
            'top_collection_text_en' => "nullable|string",
            'top_collection_description_ar' => "nullable|string",
            'top_collection_description_en' => "nullable|string",
            'best_selling_text_ar' => "nullable|string",
            'best_selling_text_en' => "nullable|string",
            'best_selling_description_ar' => "nullable|string",
            'best_selling_description_en' => "nullable|string",
            'icon_title_1_ar' => "nullable|string",
            'icon_title_1_en' => "nullable|string",
            'icon_description_1_ar' => "nullable|string",
            'icon_description_1_en' => "nullable|string",
            'icon_1' => "nullable|image",
            'icon_title_2_ar' => "nullable|string",
            'icon_title_2_en' => "nullable|string",
            'icon_description_2_ar' => "nullable|string",
            'icon_description_2_en' => "nullable|string",
            'icon_2' => "nullable|image",
            'icon_title_3_ar' => "nullable|string",
            'icon_title_3_en' => "nullable|string",
            'icon_description_3_ar' => "nullable|string",
            'icon_description_3_en' => "nullable|string",
            'icon_3' => "nullable|image",
            'icon_title_4_ar' => "nullable|string",
            'icon_title_4_en' => "nullable|string",
            'icon_description_4_ar' => "nullable|string",
            'icon_description_4_en' => "nullable|string",
            'icon_4' => "nullable|image",
            'footer_about_ar' => "nullable|string",
            'footer_address_ar' => "nullable|string",
            'footer_follow_ar' => "nullable|string",
            'footer_about_en' => "nullable|string",
            'footer_address_en' => "nullable|string",
            'footer_follow_en' => "nullable|string",
            'footer_facebook' => "nullable|string",
            'footer_instagram' => "nullable|string",
            'footer_youtube' => "nullable|string",
            'footer_linkedin' => "nullable|string",
            'footer_email' => "nullable|string",
            'footer_phone' => "nullable|string",
            'copyright_text_ar' => "nullable|string",
            'copyright_text_en' => "nullable|string",
            'order_success_ar' => "nullable|string",
            'order_success_en' => "nullable|string",
            'about_banar' => "nullable|image",
            'about_title_ar' => "nullable|string",
            'about_title_en' => "nullable|string",
            'about_description_ar' => "nullable|string",
            'about_description_en' => "nullable|string",

        ]);


        $setting = WebsiteSetting::where('type', 'about')->first();
        if ($setting == null) {
            $setting = WebsiteSetting::create([
                'type' => 'about',
                'value_ar' => $request['about_title_ar'],
                'value_en' => $request['about_title_en'],
                'description_ar' => $request['about_description_ar'],
                'description_en' => $request['about_description_en'],
            ]);
            if ($request->hasFile('about_banar')) {
                $media_id = saveMedia('image', $request['about_banar'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        } else {
            $setting->update([
                'value_ar' => $request['about_title_ar'],
                'value_en' => $request['about_title_en'],
                'description_ar' => $request['about_description_ar'],
                'description_en' => $request['about_description_en'],
            ]);
            if ($request->hasFile('about_banar')) {

                if ($setting->media_id != null) {
                    deleteImage($setting->media_id);
                }
                $media_id = saveMedia('image', $request['about_banar'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        }


        $setting = WebsiteSetting::where('type', 'order_success')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'order_success',
                'value_ar' => $request['order_success_ar'],
                'value_en' => $request['order_success_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['order_success_ar'],
                'value_en' => $request['order_success_en'],
            ]);
        }


        $setting = WebsiteSetting::where('type', 'icon_1')->first();
        if ($setting == null) {
            $setting = WebsiteSetting::create([
                'type' => 'icon_1',
                'value_ar' => $request['icon_title_1_ar'],
                'value_en' => $request['icon_title_1_en'],
                'description_ar' => $request['icon_description_1_ar'],
                'description_en' => $request['icon_description_1_en'],
            ]);
            if ($request->hasFile('icon_1')) {
                $media_id = saveMedia('image', $request['icon_1'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        } else {
            $setting->update([
                'value_ar' => $request['icon_title_1_ar'],
                'value_en' => $request['icon_title_1_en'],
                'description_ar' => $request['icon_description_1_ar'],
                'description_en' => $request['icon_description_1_en'],
            ]);
            if ($request->hasFile('icon_1')) {

                if ($setting->media_id != null) {
                    deleteImage($setting->media_id);
                }
                $media_id = saveMedia('image', $request['icon_1'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        }



        $setting = WebsiteSetting::where('type', 'icon_2')->first();
        if ($setting == null) {
            $setting = WebsiteSetting::create([
                'type' => 'icon_2',
                'value_ar' => $request['icon_title_2_ar'],
                'value_en' => $request['icon_title_2_en'],
                'description_ar' => $request['icon_description_2_ar'],
                'description_en' => $request['icon_description_2_en'],
            ]);
            if ($request->hasFile('icon_2')) {
                $media_id = saveMedia('image', $request['icon_2'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        } else {
            $setting->update([
                'value_ar' => $request['icon_title_2_ar'],
                'value_en' => $request['icon_title_2_en'],
                'description_ar' => $request['icon_description_2_ar'],
                'description_en' => $request['icon_description_2_en'],
            ]);
            if ($request->hasFile('icon_2')) {
                if ($setting->media_id != null) {
                    deleteImage($setting->media_id);
                }
                $media_id = saveMedia('image', $request['icon_2'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        }




        $setting = WebsiteSetting::where('type', 'icon_3')->first();
        if ($setting == null) {
            $setting = WebsiteSetting::create([
                'type' => 'icon_3',
                'value_ar' => $request['icon_title_3_ar'],
                'value_en' => $request['icon_title_3_en'],
                'description_ar' => $request['icon_description_3_ar'],
                'description_en' => $request['icon_description_3_en'],
            ]);
            if ($request->hasFile('icon_3')) {
                $media_id = saveMedia('image', $request['icon_3'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        } else {
            $setting->update([
                'value_ar' => $request['icon_title_3_ar'],
                'value_en' => $request['icon_title_3_en'],
                'description_ar' => $request['icon_description_3_ar'],
                'description_en' => $request['icon_description_3_en'],
            ]);


            if ($request->hasFile('icon_3')) {
                if ($setting->media_id != null) {
                    deleteImage($setting->media_id);
                }
                $media_id = saveMedia('image', $request['icon_3'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        }




        $setting = WebsiteSetting::where('type', 'icon_4')->first();
        if ($setting == null) {
            $setting = WebsiteSetting::create([
                'type' => 'icon_4',
                'value_ar' => $request['icon_title_4_ar'],
                'value_en' => $request['icon_title_4_en'],
                'description_ar' => $request['icon_description_4_ar'],
                'description_en' => $request['icon_description_4_en'],
            ]);
            if ($request->hasFile('icon_4')) {
                $media_id = saveMedia('image', $request['icon_4'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        } else {
            $setting->update([
                'value_ar' => $request['icon_title_4_ar'],
                'value_en' => $request['icon_title_4_en'],
                'description_ar' => $request['icon_description_4_ar'],
                'description_en' => $request['icon_description_4_en'],
            ]);
            if ($request->hasFile('icon_4')) {
                if ($setting->media_id != null) {
                    deleteImage($setting->media_id);
                }
                $media_id = saveMedia('image', $request['icon_4'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        }







        $setting = WebsiteSetting::where('type', 'top_collection')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'top_collection',
                'value_ar' => $request['top_collection_text_ar'],
                'value_en' => $request['top_collection_text_en'],
                'description_ar' => $request['top_collection_description_ar'],
                'description_en' => $request['top_collection_description_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['top_collection_text_ar'],
                'value_en' => $request['top_collection_text_en'],
                'description_ar' => $request['top_collection_description_ar'],
                'description_en' => $request['top_collection_description_en'],
            ]);
        }


        $setting = WebsiteSetting::where('type', 'best_selling')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'best_selling',
                'value_ar' => $request['best_selling_text_ar'],
                'value_en' => $request['best_selling_text_en'],
                'description_ar' => $request['best_selling_description_ar'],
                'description_en' => $request['best_selling_description_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['best_selling_text_ar'],
                'value_en' => $request['best_selling_text_en'],
                'description_ar' => $request['best_selling_description_ar'],
                'description_en' => $request['best_selling_description_en'],
            ]);
        }

        $settings = WebsiteSetting::where('type', 'categories')->get();
        if ($settings == null) {
            foreach ($request['categories'] as $value) {
                WebsiteSetting::create([
                    'type' => 'categories',
                    'value_ar' => $value,
                    'value_en' => $value,
                ]);
            }
        } else {
            if ($settings) {
                foreach ($settings as $setting) {
                    $setting->delete();
                }
            }
            if ($request['categories']) {
                foreach ($request['categories'] as $value) {
                    WebsiteSetting::create([
                        'type' => 'categories',
                        'value_ar' => $value,
                        'value_en' => $value,
                    ]);
                }
            }
        }


        $settings = WebsiteSetting::where('type', 'categories_2')->get();
        if ($settings == null) {
            foreach ($request['categories_2'] as $value) {
                WebsiteSetting::create([
                    'type' => 'categories_2',
                    'value_ar' => $value,
                    'value_en' => $value,
                ]);
            }
        } else {
            if ($settings) {
                foreach ($settings as $setting) {
                    $setting->delete();
                }
            }
            if ($request['categories_2']) {
                foreach ($request['categories_2'] as $value) {
                    WebsiteSetting::create([
                        'type' => 'categories_2',
                        'value_ar' => $value,
                        'value_en' => $value,
                    ]);
                }
            }
        }

        $settings = WebsiteSetting::where('type', 'flash_news')->get();
        if ($settings == null) {
            foreach ($request['flash_news_ar'] as $index => $value) {
                WebsiteSetting::create([
                    'type' => 'flash_news',
                    'value_ar' => $value,
                    'value_en' => $request['flash_news_en'][$index],
                ]);
            }
        } else {
            if ($settings) {
                foreach ($settings as $setting) {
                    $setting->delete();
                }
            }
            if ($request['flash_news_ar']) {
                foreach ($request['flash_news_ar'] as $index => $value) {
                    WebsiteSetting::create([
                        'type' => 'flash_news',
                        'value_ar' => $value,
                        'value_en' => $request['flash_news_en'][$index],
                    ]);
                }
            }
        }




        $setting = WebsiteSetting::where('type', 'welcome_text')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'welcome_text',
                'value_ar' => $request['welcome_text_ar'],
                'value_en' => $request['welcome_text_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['welcome_text_ar'],
                'value_en' => $request['welcome_text_en'],
            ]);
        }

        $setting = WebsiteSetting::where('type', 'header_phone')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'header_phone',
                'value_ar' => $request['header_phone'],
                'value_en' => $request['header_phone'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['header_phone'],
                'value_en' => $request['header_phone'],
            ]);
        }

        $setting = WebsiteSetting::where('type', 'primary_color')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'primary_color',
                'value_ar' => $request['primary_color'],
                'value_en' => $request['primary_color'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['primary_color'],
                'value_en' => $request['primary_color'],
            ]);
        }


        $setting = WebsiteSetting::where('type', 'secondary_color')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'secondary_color',
                'value_ar' => $request['secondary_color'],
                'value_en' => $request['secondary_color'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['secondary_color'],
                'value_en' => $request['secondary_color'],
            ]);
        }


        $setting = WebsiteSetting::where('type', 'website_title')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'website_title',
                'value_ar' => $request['website_title_ar'],
                'value_en' => $request['website_title_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['website_title_ar'],
                'value_en' => $request['website_title_en'],
            ]);
        }

        $setting = WebsiteSetting::where('type', 'footer_about')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_about',
                'value_ar' => $request['footer_about_ar'],
                'value_en' => $request['footer_about_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_about_ar'],
                'value_en' => $request['footer_about_en'],
            ]);
        }


        $setting = WebsiteSetting::where('type', 'footer_address')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_address',
                'value_ar' => $request['footer_address_ar'],
                'value_en' => $request['footer_address_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_address_ar'],
                'value_en' => $request['footer_address_en'],
            ]);
        }


        $setting = WebsiteSetting::where('type', 'footer_phone')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_phone',
                'value_ar' => $request['footer_phone'],
                'value_en' => $request['footer_phone'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_phone'],
                'value_en' => $request['footer_phone'],
            ]);
        }


        $setting = WebsiteSetting::where('type', 'footer_email')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_email',
                'value_ar' => $request['footer_email'],
                'value_en' => $request['footer_email'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_email'],
                'value_en' => $request['footer_email'],
            ]);
        }

        $setting = WebsiteSetting::where('type', 'footer_follow')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_follow',
                'value_ar' => $request['footer_follow_ar'],
                'value_en' => $request['footer_follow_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_follow_ar'],
                'value_en' => $request['footer_follow_en'],
            ]);
        }




        $setting = WebsiteSetting::where('type', 'copyright_text')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'copyright_text',
                'value_ar' => $request['copyright_text_ar'],
                'value_en' => $request['copyright_text_en'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['copyright_text_ar'],
                'value_en' => $request['copyright_text_en'],
            ]);
        }

        $setting = WebsiteSetting::where('type', 'footer_facebook')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_facebook',
                'value_ar' => $request['footer_facebook'],
                'value_en' => $request['footer_facebook'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_facebook'],
                'value_en' => $request['footer_facebook'],
            ]);
        }

        $setting = WebsiteSetting::where('type', 'footer_instagram')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_instagram',
                'value_ar' => $request['footer_instagram'],
                'value_en' => $request['footer_instagram'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_instagram'],
                'value_en' => $request['footer_instagram'],
            ]);
        }

        $setting = WebsiteSetting::where('type', 'footer_youtube')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_youtube',
                'value_ar' => $request['footer_youtube'],
                'value_en' => $request['footer_youtube'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_youtube'],
                'value_en' => $request['footer_youtube'],
            ]);
        }

        $setting = WebsiteSetting::where('type', 'footer_linkedin')->first();
        if ($setting == null) {
            WebsiteSetting::create([
                'type' => 'footer_linkedin',
                'value_ar' => $request['footer_linkedin'],
                'value_en' => $request['footer_linkedin'],
            ]);
        } else {
            $setting->update([
                'value_ar' => $request['footer_linkedin'],
                'value_en' => $request['footer_linkedin'],
            ]);
        }




        if ($request->hasFile('header_logo')) {


            $setting = WebsiteSetting::where('type', 'header_logo')->first();
            if ($setting == null) {
                $media_id = saveMedia('image', $request['header_logo'], 'settings');
                WebsiteSetting::create([
                    'type' => 'header_logo',
                    'media_id' => $media_id,
                ]);
            } else {
                deleteImage($setting->media_id);
                $media_id = saveMedia('image', $request['header_logo'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        }


        if ($request->hasFile('header_icon')) {


            $setting = WebsiteSetting::where('type', 'header_icon')->first();
            if ($setting == null) {
                $media_id = saveMedia('image', $request['header_icon'], 'settings');
                WebsiteSetting::create([
                    'type' => 'header_icon',
                    'media_id' => $media_id,
                ]);
            } else {
                deleteImage($setting->media_id);
                $media_id = saveMedia('image', $request['header_icon'], 'settings');
                $setting->update([
                    'media_id' => $media_id,
                ]);
            }
        }



        alertSuccess('Settings saved successfully', 'تم حفظ الإعدادات بنجاح');
        return redirect()->route('website-setting.index');
    }
}
