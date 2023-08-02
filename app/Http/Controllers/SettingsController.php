<?php

namespace App\Http\Controllers;

use App\Models\IpRestrict;
use App\Mail\EmailTest;
use App\Mail\TestMail;
use App\Models\Settings;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Artisan;
use App\Models\EmailTemplate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\ExperienceCertificate;
use App\Models\NOC;
use App\Models\Job;
use File;



class SettingsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->offerlangs) {
            $offerlang = $request->offerlangs;
        } else {
            $offerlang = "en";
        }
        if ($request->joininglangs) {
            $joininglang = $request->joininglangs;
        } else {
            $joininglang = "en";
        }
        if ($request->explangs) {
            $explang = $request->explangs;
        } else {
            $explang = "en";
        }
        if ($request->noclangs) {
            $noclang = $request->noclangs;
        } else {
            $noclang = "en";
        }
        $user = \Auth::user();
        if (\Auth::user()->type == 'company') {
            $timezones = config('timezones');

            $settings = Utility::settings();
            $EmailTemplates = EmailTemplate::all();
            $ips = IpRestrict::where('created_by', \Auth::user()->creatorId())->get();
            //offer letter
            $Offerletter = GenerateOfferLetter::all();
            $currOfferletterLang = GenerateOfferLetter::where('created_by',  \Auth::user()->id)->where('lang', $offerlang)->first();


            //joining letter
            $Joiningletter = JoiningLetter::all();
            $currjoiningletterLang = JoiningLetter::where('created_by',  \Auth::user()->id)->where('lang', $joininglang)->first();

            //Experience Certificate
            $experience_certificate = ExperienceCertificate::all();
            $curr_exp_cetificate_Lang = ExperienceCertificate::where('created_by',  \Auth::user()->id)->where('lang', $explang)->first();

            //NOC
            $noc_certificate = NOC::all();
            $currnocLang = NOC::where('created_by',  \Auth::user()->id)->where('lang', $noclang)->first();



            return view('setting.company_settings', compact('settings', 'timezones', 'ips', 'EmailTemplates', 'currOfferletterLang', 'Offerletter', 'offerlang', 'Joiningletter', 'currjoiningletterLang', 'joininglang', 'experience_certificate', 'curr_exp_cetificate_Lang', 'explang', 'noc_certificate', 'currnocLang', 'noclang'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function saveBusinessSettings(Request $request)
    {

        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin') {

            $user = \Auth::user();
            if ($request->company_logo) {


                $request->validate(
                    [
                        'company_logo' => 'image|mimes:png|max:20480',
                    ]
                );

                $logoName     = 'dark_logo.png';
                $dir = 'uploads/logo/';
                $validation = [
                    'mimes:' . 'png',
                    'max:' . '20480',
                ];
                $path = Utility::upload_file($request, 'company_logo', $logoName, $dir, $validation);
                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }


                $company_logo = !empty($request->company_logo) ? $logoName : 'logo-dark.png';


                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $logoName,
                        'company_logo',
                        \Auth::user()->creatorId(),
                    ]
                );
            }


            if ($request->company_logo_light) {

                $request->validate(
                    [
                        'company_logo_light' => 'image|mimes:png|max:20480',
                    ]
                );
                $logoName = 'light_logo.png';

                $dir = 'uploads/logo/';
                $validation = [
                    'mimes:' . 'png',
                    'max:' . '20480',
                ];
                $path = Utility::upload_file($request, 'company_logo_light', $logoName, $dir, $validation);
                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }

                $company_logo_light = !empty($request->company_logo_light) ? $logoName : 'logo-light.png';


                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $logoName,
                        'company_logo_light',
                        \Auth::user()->creatorId(),
                    ]
                );
            }

            if ($request->company_favicon) {

                $request->validate(
                    [
                        'company_favicon' => 'image|mimes:png|max:20480',
                    ]
                );
                $favicon =  'favicon.png';


                $dir = 'uploads/logo/';
                $validation = [
                    'mimes:' . 'png',
                    'max:' . '20480',
                ];
                $path = Utility::upload_file($request, 'company_favicon', $favicon, $dir, $validation);
                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }

                $company_favicon = !empty($request->company_favicon) ? $favicon : 'favicon.png';

                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $favicon,
                        'company_favicon',
                        \Auth::user()->creatorId(),
                    ]
                );
            }


            $arrEnv = [
                'SITE_RTL' => !isset($request->SITE_RTL) ? 'off' : 'on',

            ];
            Utility::setEnvironmentValue($arrEnv);
            if (!empty($request->title_text) || !empty($request->metakeyword) || !empty($request->metadesc || !empty($request->footer_text) || !empty($request->default_language) || !empty($request->display_landing_page) || !empty($request->SITE_RTL) || !empty($request->gdpr_cookie) || !empty($request->cookie_text) || !empty($request->theme_color) || !empty($request->is_sidebar_transperent))) {
                $post = $request->all();
                if (!isset($request->display_landing_page)) {
                    $post['display_landing_page'] = 'off';
                }
                if (!isset($request->gdpr_cookie)) {
                    $post['gdpr_cookie'] = 'off';
                }
                if (!isset($request->disable_signup_button)) {
                    $post['disable_signup_button'] = 'off';
                }
                if (!isset($request->dark_mode)) {
                    $post['dark_mode'] = 'off';
                }
                if (!isset($request->is_sidebar_transperent)) {
                    $post['is_sidebar_transperent'] = 'off';
                }


                unset($post['_token'], $post['company_logo'], $post['company_small_logo'], $post['company_logo_light'], $post['company_favicon']);

                $settings = Utility::settings();
                // dd($settings);
                foreach ($post as $key => $data) {
                    if (in_array($key, array_keys($settings)) && !empty($data)) {
                        \DB::insert(
                            'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                            [
                                $data,
                                $key,
                                \Auth::user()->creatorId(),
                            ]
                        );
                    }
                }
            }

            return redirect()->back()->with('success', 'Setting successfully updated.');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }


    public function saveEmailSettings(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $request->validate(
                [
                    'mail_driver' => 'required|string|max:255',
                    'mail_host' => 'required|string|max:255',
                    'mail_port' => 'required|string|max:255',
                    'mail_username' => 'required|string|max:255',
                    'mail_password' => 'required|string|max:255',
                    'mail_encryption' => 'required|string|max:255',
                    'mail_from_address' => 'required|string|max:255',
                    'mail_from_name' => 'required|string|max:255',
                ]
            );

            $arrEnv = [
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_NAME' => $request->mail_from_name,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            ];
            Utility::setEnvironmentValue($arrEnv);
            Artisan::call('config:cache');
            Artisan::call('config:clear');
            return redirect()->back()->with('success', __('Setting successfully updated.'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }


    public function savePaymentSettings(Request $request)
    {

        if (\Auth::user()->type == 'company') {
            $request->validate(
                [
                    'currency' => 'required|string|max:255',
                    'currency_symbol' => 'required|string|max:255',
                ]
            );

            if (isset($request->enable_stripe) && $request->enable_stripe == 'on') {
                $request->validate(
                    [
                        'stripe_key' => 'required|string|max:255',
                        'stripe_secret' => 'required|string|max:255',
                    ]
                );
            } elseif (isset($request->enable_paypal) && $request->enable_paypal == 'on') {
                $request->validate(
                    [
                        'paypal_mode' => 'required|string',
                        'paypal_client_id' => 'required|string',
                        'paypal_secret_key' => 'required|string',
                    ]
                );
            }


            $arrEnv = [
                'CURRENCY_SYMBOL' => $request->currency_symbol,
                'CURRENCY' => $request->currency,
                'ENABLE_STRIPE' => $request->enable_stripe ?? 'off',
                'STRIPE_KEY' => $request->stripe_key,
                'STRIPE_SECRET' => $request->stripe_secret,
                'ENABLE_PAYPAL' => $request->enable_paypal ?? 'off',
                'PAYPAL_MODE' => $request->paypal_mode,
                'PAYPAL_CLIENT_ID' => $request->paypal_client_id,
                'PAYPAL_SECRET_KEY' => $request->paypal_secret_key,

            ];
            Utility::setEnvironmentValue($arrEnv);

            Artisan::call('config:cache');
            Artisan::call('config:clear');

            return redirect()->back()->with('success', __('Payment successfully updated.'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }


    public function companyIndex()
    {
        if (\Auth::user()->type == 'company') {
            $settings = Utility::settings();

            return view('settings.company_settings', compact('settings'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function saveCompanySettings(Request $request)
    {

        if (\Auth::user()->type == 'company') {
            $user = \Auth::user();
            $request->validate(
                [
                    'company_name' => 'required|string|max:255',
                    'company_email' => 'required',
                    'company_email_from_name' => 'required|string',
                    'company_address' => 'required',
                    'company_city' => 'required',
                    'company_state' => 'required',
                    'company_zipcode' => 'required',
                    'company_country' => 'required',
                    'company_telephone' => 'required',
                    'timezone' => 'required',
                ]
            );
            $post = $request->all();
            if (!isset($request->ip_restrict)) {
                $post['ip_restrict'] = 'off';
            }
            unset($post['_token']);

            $settings = Utility::settings();
            foreach ($post as $key => $data) {
                if (in_array($key, array_keys($settings)) && !empty($data)) {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        [
                            $data,
                            $key,
                            \Auth::user()->creatorId(),
                        ]
                    );
                }
            }

            $arrEnv = [
                'TIMEZONE' => $request->timezone,
            ];

            Utility::setEnvironmentValue($arrEnv);

            return redirect()->back()->with('success', __('Setting successfully updated.'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function saveSystemSettings(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $user = \Auth::user();
            $request->validate(
                [
                    'site_currency' => 'required',
                ]
            );
            $post = $request->all();
            unset($post['_token']);

            $settings = Utility::settings();
            foreach ($post as $key => $data) {
                if (in_array($key, array_keys($settings)) && !empty($data)) {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        [
                            $data,
                            $key,
                            \Auth::user()->creatorId(),
                            date('Y-m-d H:i:s'),
                            date('Y-m-d H:i:s'),
                        ]
                    );
                }
            }

            return redirect()->back()->with('success', __('Setting successfully updated.'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function updateEmailStatus($name)
    {
        if (\Auth::user()->type == 'company') {
            $emailNotification = \DB::table('settings')->where('name', '=', $name)->where('created_by', \Auth::user()->creatorId())->first();
            if (empty($emailNotification)) {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        0,
                        $name,
                        \Auth::user()->creatorId(),
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                    ]
                );
            } else {
                if ($emailNotification->value == 1) {
                    $affected = \DB::table('settings')->where('name', $name)->update(['value' => 0]);
                } else {
                    $affected = \DB::table('settings')->where('name', $name)->update(['value' => 1]);
                }
            }
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function savePusherSettings(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $user = \Auth::user();

            $request->validate(
                [
                    'pusher_app_id' => 'required',
                    'pusher_app_key' => 'required',
                    'pusher_app_secret' => 'required',
                    'pusher_app_cluster' => 'required',
                ]
            );

            $arrEnvStripe = [
                'PUSHER_APP_ID' => $request->pusher_app_id,
                'PUSHER_APP_KEY' => $request->pusher_app_key,
                'PUSHER_APP_SECRET' => $request->pusher_app_secret,
                'PUSHER_APP_CLUSTER' => $request->pusher_app_cluster,
            ];

            $envStripe = Utility::setEnvironmentValue($arrEnvStripe);

            if ($envStripe) {
                Artisan::call('config:cache');
                Artisan::call('config:clear');

                return redirect()->back()->with('success', __('Pusher successfully updated.'));
            } else {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function testMail(Request $request)
    {
        // dd($request->all());
        $user = \Auth::user();
        // if($user->can('manage-setting'))
        // {
        $data                      = [];
        $data['mail_driver']       = $request->mail_driver;
        $data['mail_host']         = $request->mail_host;
        $data['mail_port']         = $request->mail_port;
        $data['mail_username']     = $request->mail_username;
        $data['mail_password']     = $request->mail_password;
        $data['mail_encryption']   = $request->mail_encryption;
        $data['mail_from_address'] = $request->mail_from_address;
        $data['mail_from_name']    = $request->mail_from_name;

        return view('setting.test_mail', compact('data'));
        // return view('setting.test_mail');
    }

    // public function testSendMail(Request $request)
    // {
    //     $validator = \Validator::make($request->all(), ['email' => 'required|email']);
    //     if ($validator->fails()) {
    //         $messages = $validator->getMessageBag();

    //         return redirect()->back()->with('error', $messages->first());
    //     }

    //     try {
    //         Mail::to($request->email)->send(new TestMail());
    //     } catch (\Exception $e) {
    //         $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
    //     }

    //     return redirect()->back()->with('success', __('Email send Successfully.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
    // }

    public function testSendMail(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'mail_driver' => 'required',
                'mail_host' => 'required',
                'mail_port' => 'required',
                'mail_username' => 'required',
                'mail_password' => 'required',
                'mail_from_address' => 'required',
                'mail_from_name' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json(
                [
                    'is_success' => false,
                    'message' => $messages->first(),
                ]
            );
        }

        try {
            config(
                [
                    'mail.driver' => $request->mail_driver,
                    'mail.host' => $request->mail_host,
                    'mail.port' => $request->mail_port,
                    'mail.encryption' => $request->mail_encryption,
                    'mail.username' => $request->mail_username,
                    'mail.password' => $request->mail_password,
                    'mail.from.address' => $request->mail_from_address,
                    'mail.from.name' => $request->mail_from_name,
                ]
            );
            Mail::to($request->email)->send(new TestMail());
        } catch (\Exception $e) {
            return response()->json(
                [
                    'is_success' => false,
                    'message' => $e->getMessage(),
                ]
            );
        }

        return response()->json(
            [

                'is_success' => true,
                'message' => __('Email send Successfully'),
            ]
        );
    }
    public function createIp()
    {
        return view('restrict_ip.create');
    }

    public function storeIp(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'ip' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $ip             = new IpRestrict();
            $ip->ip         = $request->ip;
            $ip->created_by = \Auth::user()->creatorId();
            $ip->save();

            return redirect()->back()->with('success', __('IP successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function zoomSetting(request $request)
    {

        if (\Auth::user()->type == 'company') {
            if (!empty($request->zoom_apikey) || !empty($request->zoom_secret_key)) {
                $post = $request->all();


                $settings = Utility::settings();
                foreach ($post as $key => $data) {
                    if (in_array($key, array_keys($settings)) && !empty($data)) {
                        \DB::insert(
                            'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                            [
                                $data,
                                $key,
                                \Auth::user()->creatorId(),
                            ]
                        );
                    }
                }
            }
        }
        return redirect()->back()->with('success', __('Zoom key succesfully added .'));
    }

    public function recaptchaSettingStore(Request $request)
    {
        //return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));

        $user = \Auth::user();
        $rules = [];

        if ($request->recaptcha_module == 'yes') {
            $rules['google_recaptcha_key'] = 'required|string|max:50';
            $rules['google_recaptcha_secret'] = 'required|string|max:50';
        }

        $validator = \Validator::make(
            $request->all(),
            $rules
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $arrEnv = [
            'RECAPTCHA_MODULE' => $request->recaptcha_module ?? 'no',
            'NOCAPTCHA_SITEKEY' => $request->google_recaptcha_key,
            'NOCAPTCHA_SECRET' => $request->google_recaptcha_secret,
        ];

        if (Utility::setEnvironmentValue($arrEnv)) {
            return redirect()->back()->with('success', __('Recaptcha Settings updated successfully'));
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

    public function editIp($id)
    {
        $ip = IpRestrict::find($id);

        return view('restrict_ip.edit', compact('ip'));
    }

    public function updateIp(Request $request, $id)
    {
        if (\Auth::user()->type == 'company') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'ip' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $ip     = IpRestrict::find($id);
            $ip->ip = $request->ip;
            $ip->save();

            return redirect()->back()->with('success', __('IP successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroyIp($id)
    {
        if (\Auth::user()->type == 'company') {
            $ip = IpRestrict::find($id);
            $ip->delete();

            return redirect()->back()->with('success', __('IP successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function slack(Request $request)
    {
        $post = [];
        $post['slack_webhook'] = $request->input('slack_webhook');
        $post['monthly_payslip_notification'] = $request->has('monthly_payslip_notification') ? $request->input('monthly_payslip_notification') : 0;
        $post['award_notificaation'] = $request->has('award_notificaation') ? $request->input('award_notificaation') : 0;
        $post['Announcement_notification'] = $request->has('Announcement_notification') ? $request->input('Announcement_notification') : 0;
        $post['Holiday_notification'] = $request->has('Holiday_notification') ? $request->input('Holiday_notification') : 0;
        $post['ticket_notification'] = $request->has('ticket_notification') ? $request->input('ticket_notification') : 0;
        $post['event_notification'] = $request->has('event_notification') ? $request->input('event_notification') : 0;
        $post['meeting_notification'] = $request->has('meeting_notification') ? $request->input('meeting_notification') : 0;
        $post['company_policy_notification'] = $request->has('company_policy_notification') ? $request->input('company_policy_notification') : 0;



        if (isset($post) && !empty($post) && count($post) > 0) {
            $created_at = $updated_at = date('Y-m-d H:i:s');

            foreach ($post as $key => $data) {
                \DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                    [
                        $data,
                        $key,
                        Auth::user()->id,
                        $created_at,
                        $updated_at,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', __('Settings updated successfully.'));
    }

    public function telegram(Request $request)
    {
        $post = [];
        $post['telegram_accestoken'] = $request->input('telegram_accestoken');
        $post['telegram_chatid'] = $request->input('telegram_chatid');
        $post['telegram_monthly_payslip_notification'] = $request->has('telegram_monthly_payslip_notification') ? $request->input('telegram_monthly_payslip_notification') : 0;
        $post['telegram_award_notification'] = $request->has('telegram_award_notification') ? $request->input('telegram_award_notification') : 0;
        $post['telegram_Announcement_notification'] = $request->has('telegram_Announcement_notification') ? $request->input('telegram_Announcement_notification') : 0;
        $post['telegram_Holiday_notification'] = $request->has('telegram_Holiday_notification') ? $request->input('telegram_Holiday_notification') : 0;
        $post['telegram_ticket_notification'] = $request->has('telegram_ticket_notification') ? $request->input('telegram_ticket_notification') : 0;
        $post['telegram_event_notification'] = $request->has('telegram_event_notification') ? $request->input('telegram_event_notification') : 0;
        $post['telegram_meeting_notification'] = $request->has('telegram_meeting_notification') ? $request->input('telegram_meeting_notification') : 0;
        $post['telegram_company_policy_notification'] = $request->has('telegram_company_policy_notification') ? $request->input('telegram_company_policy_notification') : 0;



        if (isset($post) && !empty($post) && count($post) > 0) {
            $created_at = $updated_at = date('Y-m-d H:i:s');

            foreach ($post as $key => $data) {
                \DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                    [
                        $data,
                        $key,
                        Auth::user()->id,
                        $created_at,
                        $updated_at,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', __('Settings updated successfully.'));
    }

    public function twilio(Request $request)
    {


        $post = [];
        $post['twilio_sid'] = $request->input('twilio_sid');
        $post['twilio_token'] = $request->input('twilio_token');
        $post['twilio_from'] = $request->input('twilio_from');
        $post['twilio_payslip_notification'] = $request->has('twilio_payslip_notification') ? $request->input('twilio_payslip_notification') : 0;
        $post['twilio_leave_approve_notification'] = $request->has('twilio_leave_approve_notification') ? $request->input('twilio_leave_approve_notification') : 0;
        $post['twilio_award_notification'] = $request->has('twilio_award_notification') ? $request->input('twilio_award_notification') : 0;
        $post['twilio_trip_notification'] = $request->has('twilio_trip_notification') ? $request->input('twilio_trip_notification') : 0;
        $post['twilio_announcement_notification'] = $request->has('twilio_announcement_notification') ? $request->input('twilio_announcement_notification') : 0;
        $post['twilio_ticket_notification'] = $request->has('twilio_ticket_notification') ? $request->input('twilio_ticket_notification') : 0;
        $post['twilio_event_notification'] = $request->has('twilio_event_notification') ? $request->input('twilio_event_notification') : 0;

        if (isset($post) && !empty($post) && count($post) > 0) {
            $created_at = $updated_at = date('Y-m-d H:i:s');

            foreach ($post as $key => $data) {
                DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                    [
                        $data,
                        $key,
                        Auth::user()->id,
                        $created_at,
                        $updated_at,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', __('Settings updated successfully.'));
    }
    public function offerletterupdate($lang, Request $request)
    {

        $user = GenerateOfferLetter::updateOrCreate(['lang' =>   $lang, 'created_by' =>  \Auth::user()->id], ['content' => $request->content]);

        return redirect()->back()->with('success', __('Offer Letter successfully saved.'));
    }
    public function joiningletterupdate($lang, Request $request)
    {

        $user = JoiningLetter::updateOrCreate(['lang' =>   $lang, 'created_by' =>  \Auth::user()->id], ['content' => $request->content]);

        return redirect()->back()->with('success', __('Joing Letter successfully saved.'));
    }
    public function experienceCertificateupdate($lang, Request $request)
    {
        //   dd($request->all());
        $user = ExperienceCertificate::updateOrCreate(['lang' =>   $lang, 'created_by' =>  \Auth::user()->id], ['content' => $request->content]);

        return redirect()->back()->with('success', __('Experience Certificate successfully saved.'));
    }
    public function NOCupdate($lang, Request $request)
    {
        //   dd($request->all());
        $user = NOC::updateOrCreate(['lang' =>   $lang, 'created_by' =>  \Auth::user()->id], ['content' => $request->content]);

        return redirect()->back()->with('success', __('NOC successfully saved.'));
    }

    public function storageSettingStore(Request $request)
    {

        if (isset($request->storage_setting) && $request->storage_setting == 'local') {

            $request->validate(
                [

                    'local_storage_validation' => 'required',
                    'local_storage_max_upload_size' => 'required',
                ]
            );

            $post['storage_setting'] = $request->storage_setting;
            $local_storage_validation = implode(',', $request->local_storage_validation);
            $post['local_storage_validation'] = $local_storage_validation;
            $post['local_storage_max_upload_size'] = $request->local_storage_max_upload_size;
        }

        if (isset($request->storage_setting) && $request->storage_setting == 's3') {
            $request->validate(
                [
                    's3_key'                  => 'required',
                    's3_secret'               => 'required',
                    's3_region'               => 'required',
                    's3_bucket'               => 'required',
                    's3_url'                  => 'required',
                    's3_endpoint'             => 'required',
                    's3_max_upload_size'      => 'required',
                    's3_storage_validation'   => 'required',
                ]
            );
            $post['storage_setting']            = $request->storage_setting;
            $post['s3_key']                     = $request->s3_key;
            $post['s3_secret']                  = $request->s3_secret;
            $post['s3_region']                  = $request->s3_region;
            $post['s3_bucket']                  = $request->s3_bucket;
            $post['s3_url']                     = $request->s3_url;
            $post['s3_endpoint']                = $request->s3_endpoint;
            $post['s3_max_upload_size']         = $request->s3_max_upload_size;
            $s3_storage_validation              = implode(',', $request->s3_storage_validation);
            $post['s3_storage_validation']      = $s3_storage_validation;
        }

        if (isset($request->storage_setting) && $request->storage_setting == 'wasabi') {
            $request->validate(
                [
                    'wasabi_key'                    => 'required',
                    'wasabi_secret'                 => 'required',
                    'wasabi_region'                 => 'required',
                    'wasabi_bucket'                 => 'required',
                    'wasabi_url'                    => 'required',
                    'wasabi_root'                   => 'required',
                    'wasabi_max_upload_size'        => 'required',
                    'wasabi_storage_validation'     => 'required',
                ]
            );
            $post['storage_setting']            = $request->storage_setting;
            $post['wasabi_key']                 = $request->wasabi_key;
            $post['wasabi_secret']              = $request->wasabi_secret;
            $post['wasabi_region']              = $request->wasabi_region;
            $post['wasabi_bucket']              = $request->wasabi_bucket;
            $post['wasabi_url']                 = $request->wasabi_url;
            $post['wasabi_root']                = $request->wasabi_root;
            $post['wasabi_max_upload_size']     = $request->wasabi_max_upload_size;
            $wasabi_storage_validation          = implode(',', $request->wasabi_storage_validation);
            $post['wasabi_storage_validation']  = $wasabi_storage_validation;
        }

        foreach ($post as $key => $data) {

            $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }

        return redirect()->back()->with('success', 'Storage setting successfully updated.');
    }

    public function saveGoogleCalenderSettings(Request $request)
    {
        if (isset($request->is_enabled) && $request->is_enabled == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    // 'google_calender_id' => 'required',
                    
                    // 'google_calender_json_file' => 'required',
                    ]
                );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $post['is_enabled'] = $request->is_enabled;
        } else {
            $post['is_enabled'] = 'off';
        }
        
        if ($request->google_calender_json_file) {
            // $dir       = storage_path() . '/app/google-calendar';
            $dir       = storage_path() . '/' . md5(time());
            // dd($dir);
            // dd($dir);
            if (!is_dir($dir)) {
                File::makeDirectory($dir, $mode = 0777, true, true);
            }
            $file_name = $request->google_calender_json_file->getClientOriginalName();
            // $file_path =  md5(time()) . "." . $request->google_calender_json_file->getClientOriginalExtension();
            $file_path =  md5(time()) . "/" . md5(time()) . "." . $request->google_calender_json_file->getClientOriginalExtension();

            $file = $request->file('google_calender_json_file');
            $file->move($dir, $file_path);
            $post['google_calender_json_file']            = $file_path;
        }
        if ($request->google_clender_id) {
            $post['google_clender_id']            = $request->google_clender_id;
            foreach ($post as $key => $data) {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $data,
                        $key,
                        \Auth::user()->id,
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', 'Storage setting successfully updated.');
    }
}
