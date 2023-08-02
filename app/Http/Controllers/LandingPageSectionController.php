<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSection;
use Illuminate\Http\Request;

class LandingPageSectionController extends Controller
{
    public function index()
    {
        if(\Auth::user()->type == 'company')
        {
            $get_section = LandingPageSection::orderBy('section_order', 'ASC')->get();

            return view('custom_landing_page.index', compact('get_section'));
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function setConetent(Request $request)
    {

        if(\Auth::user()->type == 'company')
        {
            $id                = $request->id;
            $section_type      = $request->section_type;
            $menu_name         = $request->menu_name;
            $text_value        = $request->text_value;
            $image             = $request->image;
            $logo              = $request->logo;
            $button            = $request->button;
            $section_order     = $request->section_order;
            $image_array       = $request->image_array;
            $system_page_id    = $request->system_page_id;
            $system_element_id = $request->system_element_id;
            $content_type      = $request->content_type;
            $system_new_tab    = $request->system_new_tab;
            $custom_class_name = $request->custom_class_name;

            $get_section = LandingPageSection::where(['id' => $id])->first();

            if(!is_null($get_section))
            {
                if($get_section->section_type == "section-plan")
                {
                    $content = $get_section->default_content;
                }
                else
                {
                    $data = [];
                    if($get_section->content == "" || $get_section->content == null)
                    {
                        $get_content = $get_section->default_content;
                    }
                    else
                    {
                        $get_content = $get_section->content;
                    }

                    $decode_content = json_decode($get_content);


                    foreach($decode_content as $key => $value)
                    {
                        if($key == "custom_class_name")
                        {
                            $data['custom_class_name'] = $custom_class_name;
                        }
                        if($key == "logo")
                        {
                            if($request->hasFile('logo'))
                            {
                                $ext      = $logo->getClientOriginalExtension();
                                $fileName = 'logo_' . time() . rand() . '.' . $ext;
                                $request->file('logo')->storeAs('uploads/custom_landing_page_image', $fileName);
                                $data['logo'] = $fileName;
                            }
                            else
                            {
                                $data['logo'] = $value;
                            }
                        }
                        else if($key == "image")
                        {
                            if($request->hasFile('image'))
                            {
                                $ext      = $image->getClientOriginalExtension();
                                $fileName = 'image_' . time() . rand() . '.' . $ext;
                                $request->file('image')->storeAs('uploads/custom_landing_page_image', $fileName);
                                $data['image'] = $fileName;
                            }
                            else
                            {
                                $data['image'] = $value;
                            }
                        }
                        else if($key == "button")
                        {
                            if(!is_null($button))
                            {
                                foreach($button as $text_key => $text_val)
                                {

                                    if($text_key == "text")
                                    {
                                        $btn_data['text'] = $text_val;
                                        $data['button']   = $btn_data;
                                    }
                                    else if($text_key == "href")
                                    {
                                        $btn_data['href'] = $text_val;
                                        $data['button']   = $btn_data;
                                    }
                                }
                            }
                            else
                            {
                                $data['button'] = $value;
                            }
                        }
                        else if($key == "menu")
                        {
                            if(!is_null($menu_name))
                            {
                                foreach($menu_name as $menu_key => $menu_value)
                                {
                                    $menu_data['menu'] = $menu_value['text'];
                                    $menu_data['href'] = $menu_value['href'];
                                    $data['menu'][]    = $menu_data;
                                }
                            }
                            else
                            {
                                $data['menu'] = $value;
                            }
                        }
                        else if($key == "text")
                        {
                            if(!is_null($text_value))
                            {
                                $no = 1;
                                foreach($text_value as $text_key => $text_val)
                                {
                                    $text_data['text-' . $no] = $text_val;
                                    $data['text']             = $text_data;
                                    $no++;
                                }
                            }
                            else
                            {
                                $data['text'] = $value;
                            }
                        }
                        else if($key == "image_array")
                        {
                            $no = 1;
                            if(!is_null($image_array))
                            {

                                foreach($image_array as $image_array_key => $image_array_val)
                                {
                                    foreach($value as $val_key => $val_data)
                                    {
                                        if($val_data->id == $image_array_key)
                                        {
                                            $ext      = $image_array_val->getClientOriginalExtension();
                                            $fileName = 'logo_' . $no . '_' . time() . rand() . '.' . $ext;
                                            $image_array_val->storeAs('uploads/custom_landing_page_image', $fileName);
                                            $val_data->image = $fileName;
                                        }
                                    }
                                }
                                $data['image_array'] = $value;
                            }
                            else
                            {
                                $data['image_array'] = $value;
                            }
                        }
                        else if($key == "system")
                        {

                            if($content_type == "new_tab")
                            {
                                $sys_data['id']   = count($value) + 1;
                                $sys_data['name'] = $system_new_tab;
                                $sys_data['data'] = [];
                                $value[]          = $sys_data;
                                $data['system']   = $value;
                            }
                            else if($content_type == "update_tab_content")
                            {
                                $system_data = [];
                                foreach($value as $key => $sys_value)
                                {

                                    $system_inner_data = [];
                                    if($sys_value->id == $system_element_id)
                                    {

                                        foreach($sys_value->data as $data_key => $data_value)
                                        {
                                            if($data_value->data_id == $system_page_id)
                                            {
                                                $no        = 1;
                                                $data_text = [];
                                                foreach($text_value as $text_key => $text_val)
                                                {
                                                    $data_text['text_' . $no] = $text_val;
                                                    $no++;
                                                }

                                                $data_value->text         = $data_text;
                                                $data_value->button->text = $button['text'];
                                                $data_value->button->href = $button['href'];
                                                if($request->hasFile('image'))
                                                {
                                                    $ext      = $image->getClientOriginalExtension();
                                                    $fileName = 'image_' . time() . rand() . '.' . $ext;
                                                    $request->file('image')->storeAs('uploads/custom_landing_page_image', $fileName);
                                                    $data_value->image = $fileName;
                                                }
                                            }
                                            $system_inner_data[] = $data_value;
                                        }

                                        $sys_value->data = $system_inner_data;
                                        $system_data[]   = $sys_value;
                                    }
                                    else
                                    {
                                        $system_data[] = $sys_value;
                                    }
                                    $data['system'] = $system_data;
                                }
                            }
                            else if($content_type == "new_tab_content")
                            {
                                $system_inner_data = [];
                                foreach($value as $key => $sys_value)
                                {

                                    if($sys_value->id == $system_element_id)
                                    {
                                        $no        = 1;
                                        $data_text = [];
                                        foreach($text_value as $text_key => $text_val)
                                        {
                                            $data_text['text_' . $no] = $text_val;
                                            $no++;
                                        }
                                        $data_value['data_id']        = count($sys_value->data) + 1;
                                        $data_value['text']           = $data_text;
                                        $data_value['button']['text'] = $button['text'];
                                        $data_value['button']['href'] = $button['href'];
                                        if($request->hasFile('image'))
                                        {
                                            $ext      = $image->getClientOriginalExtension();
                                            $fileName = 'image_' . time() . rand() . '.' . $ext;
                                            $request->file('image')->storeAs('uploads/custom_landing_page_image', $fileName);
                                            $data_value['image'] = $fileName;
                                        }
                                        /*$system_inner_data[] = $data_value;*/
                                        $sys_value->data[] = $data_value;
                                    }
                                    $system_inner_data[] = $sys_value;
                                }
                                $data['system'] = $system_inner_data;
                            }
                            else if($content_type == "remove_element")
                            {
                                foreach($value as $key => $sys_value)
                                {
                                    if($sys_value->id == $system_element_id)
                                    {

                                    }
                                    else
                                    {
                                        $system_data[] = $sys_value;
                                    }
                                    $data['system'] = $system_data;
                                }
                            }
                            else if($content_type == "remove_element_data")
                            {
                                $system_data = [];
                                foreach($value as $key => $sys_value)
                                {

                                    $system_inner_data = [];
                                    if($sys_value->id == $system_element_id)
                                    {

                                        foreach($sys_value->data as $data_key => $data_value)
                                        {
                                            if($data_value->data_id == $system_page_id)
                                            {

                                            }
                                            else
                                            {
                                                $system_inner_data[] = $data_value;
                                            }
                                        }

                                        $sys_value->data = $system_inner_data;
                                        $system_data[]   = $sys_value;
                                    }
                                    else
                                    {
                                        $system_data[] = $sys_value;
                                    }
                                    $data['system'] = $system_data;
                                }
                            }
                            else
                            {
                                $data['system'] = $value;
                            }
                        }
                        else if($key == "testimonials")
                        {
                            $testinomial_data = [];
                            if($content_type == "update_section")
                            {
                                foreach($value as $key => $test_value)
                                {
                                    if($system_element_id == $test_value->id)
                                    {
                                        $no        = 1;
                                        $data_text = [];
                                        foreach($text_value as $text_key => $text_val)
                                        {
                                            $data_text['text_' . $no] = $text_val;
                                            $no++;
                                        }
                                        $data_value['text'] = $data_text;
                                        if($request->hasFile('image'))
                                        {
                                            $ext      = $image->getClientOriginalExtension();
                                            $fileName = 'image_' . time() . rand() . '.' . $ext;
                                            $request->file('image')->storeAs('uploads/custom_landing_page_image', $fileName);
                                            $data_value['image'] = $fileName;
                                        }
                                        else
                                        {
                                            $data_value['image'] = $test_value->image;
                                        }
                                        $data_value['id']       = $test_value->id;
                                        $data['testimonials'][] = $data_value;
                                    }
                                    else
                                    {
                                        $data['testimonials'][] = $test_value;
                                    }
                                }
                            }
                            else if($content_type == "new_section")
                            {
                                $no               = 1;
                                $data_text        = [];
                                $data_value['id'] = count($value) + 1;
                                foreach($text_value as $text_key => $text_val)
                                {
                                    $data_text['text_' . $no] = $text_val;
                                    $no++;
                                }
                                $data_value['text'] = $data_text;
                                if($request->hasFile('image'))
                                {
                                    $ext      = $image->getClientOriginalExtension();
                                    $fileName = 'image_' . time() . rand() . '.' . $ext;
                                    $request->file('image')->storeAs('uploads/custom_landing_page_image', $fileName);
                                    $data_value['image'] = $fileName;
                                }
                                else
                                {
                                    $data_value['image'] = "default-thumbnail.jpg";
                                }
                                $value[]              = $data_value;
                                $data['testimonials'] = $value;
                            }
                            else if($content_type == "remove_element")
                            {
                                foreach($value as $key => $test_value)
                                {
                                    if($test_value->id == $system_element_id)
                                    {

                                    }
                                    else
                                    {
                                        $data['testimonials'][] = $test_value;
                                    }
                                }
                            }
                            else
                            {
                                $data['testimonials'] = $value;
                            }
                        }
                        else if($key == "footer")
                        {
                            $footer_data = [];

                            if(is_null($menu_name))
                            {
                                $data['footer'] = $value;
                            }
                            else
                            {
                                foreach($value as $key => $json_val)
                                {
                                    if($key == "logo")
                                    {
                                        if($request->hasFile('logo'))
                                        {
                                            $ext      = $logo->getClientOriginalExtension();
                                            $fileName = 'logo_' . time() . rand() . '.' . $ext;
                                            $request->file('logo')->storeAs('uploads/custom_landing_page_image', $fileName);
                                            $json_val->logo = $fileName;
                                        }
                                        if(!is_null($text_value))
                                        {
                                            $json_val->text = $text_value;
                                        }
                                        $data['footer']['logo'] = $json_val;
                                    }
                                    if($key == "footer_menu")
                                    {
                                        if(!is_null($menu_name['footer_menu']))
                                        {
                                            $test_value = $menu_name['footer_menu'];
                                            $inner      = [];
                                            foreach($test_value as $key => $val)
                                            {
                                                $inner_data         = [];
                                                $inner_data['id']   = $key;
                                                $inner_data['menu'] = $val['menu'];
                                                $inner_data1        = [];
                                                foreach($val['data'] as $key => $val1)
                                                {
                                                    $inner_data1['menu_name'] = $val1['text'];
                                                    $inner_data1['menu_href'] = $val1['href'];
                                                    $inner_data['data'][]     = $inner_data1;
                                                }
                                                $inner[] = $inner_data;
                                            }
                                            $data['footer']['footer_menu'] = $inner;
                                        }
                                        else
                                        {
                                            $data['footer']['footer_menu'] = $json_val;
                                        }
                                    }
                                    if($key == "bottom_menu")
                                    {
                                        if(!is_null($menu_name['bottom_menu']))
                                        {
                                            $test_value         = $menu_name['bottom_menu'];
                                            $inner_data         = [];
                                            $inner_data['id']   = $key;
                                            $inner_data['text'] = $test_value['text'];
                                            $inner_data1        = [];
                                            foreach($test_value['data'] as $key => $val)
                                            {
                                                $inner_data1['menu_name'] = $val['text'];
                                                $inner_data1['menu_href'] = $val['href'];
                                                $inner_data['data'][]     = $inner_data1;
                                            }
                                            $data['footer']['bottom_menu'] = $inner_data;
                                        }
                                        else
                                        {
                                            $data['footer']['bottom_menu'] = $json_val;
                                        }
                                    }

                                    if($key == "contact_app")
                                    {
                                        if(!is_null($menu_name['contact_app']))
                                        {
                                            $test_value         = $menu_name['contact_app'];
                                            $inner_data         = [];
                                            $inner_data['menu'] = $test_value['menu'];
                                            $inner_data1        = [];

                                            foreach($test_value['data'] as $key => $val)
                                            {
                                                //print_r($val['image']);die;
                                                foreach($json_val[0] as $json_key => $json_data)
                                                {
                                                    if($json_key == "data")
                                                    {
                                                        foreach($json_data as $contact_key => $contact_data)
                                                        {
                                                            if($val['id'] == $contact_data->id)
                                                            {
                                                                if(!empty($val['image']))
                                                                {
                                                                    $ext      = $val['image']->getClientOriginalExtension();
                                                                    $fileName = 'contact_app_' . time() . $contact_key . rand() . '.' . $ext;
                                                                    $val['image']->storeAs('uploads/custom_landing_page_image', $fileName);
                                                                    $contact_data->image = $fileName;
                                                                }
                                                                if(!empty($val['href']))
                                                                {
                                                                    $contact_data->image_href = $val['href'];
                                                                }
                                                                $json_data = $contact_data;
                                                            }
                                                        }
                                                        $inner_data1[] = $json_data;
                                                    }
                                                }
                                            }
                                            $inner_data['data']              = $inner_data1;
                                            $data['footer']['contact_app'][] = $inner_data;
                                        }
                                        else
                                        {
                                            $data['footer']['contact_app'][] = $json_val;
                                        }
                                    }
                                }
                            }
                        }
                    }


                    $content = json_encode($data);
                }


                $Landing_page_section = LandingPageSection::findOrfail($get_section->id);


                $Landing_page_section->content = $content;

                $Landing_page_section->save();


                return $get_section;
            }
            else
            {
                return "error";
            }
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function removeSection($id)
    {
        if(\Auth::user()->type == 'company')
        {
            $Landing_page_section     = LandingPageSection::findOrfail($id);
            $get_alredy_exist_section = LandingPageSection::where(['section_type' => $Landing_page_section->section_type])->whereNotIn('id', [$id])->get();
            if(count($get_alredy_exist_section) > 0)
            {
                $Landing_page_section->delete();
            }
            else
            {
                $Landing_page_section->content = '';
                $Landing_page_section->save();
            }
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function setOrder(Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $element_array = $request->element_array;
            $order         = 1;
            if(count($element_array) > 0)
            {
                foreach($element_array as $key => $value)
                {
                    $Landing_page_section                = LandingPageSection::findOrfail($value);
                    $Landing_page_section->section_order = $order;
                    $Landing_page_section->save();
                    $order++;
                }
            }

            return 0;
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function copySection(Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $id = $request->id;

            $get_section = LandingPageSection::where(['id' => $id])->first();

            if(!is_null($get_section))
            {
                $Landing_page_section                          = new LandingPageSection();
                $Landing_page_section->section_name            = $get_section->section_name;
                $Landing_page_section->section_order           = $get_section->section_order;
                $Landing_page_section->default_content         = $get_section->default_content;
                $Landing_page_section->section_name            = $get_section->section_name;
                $Landing_page_section->content                 = $get_section->content;
                $Landing_page_section->section_demo_image      = $get_section->section_demo_image;
                $Landing_page_section->section_blade_file_name = $get_section->section_blade_file_name;
                $Landing_page_section->section_type            = $get_section->section_type;
                $Landing_page_section->save();

                return 1;
            }
            else
            {
                return "error";
            }
        }

        return redirect()->back()->with('error', 'Permission denied.');
    }

    public function show(Request $request, $id)
    {

        $section_name = $request->section_name;
        $section_type = $request->section_type;


        $get_content = LandingPageSection::where(['id' => $id])->first();

        if(!is_null($get_content))
        {
            $data['id']           = $get_content->id;
            $data['section_name'] = $get_content->section_name;
            $data['section_type'] = $get_content->section_type;
            if($get_content->content == "" || $get_content->content == null)
            {
                $data['content'] = $get_content->default_content;
            }
            else
            {
                $data['content'] = $get_content->content;
            }

            return json_encode($data);
        }
        else
        {
            return "error";
        }
    }
}
