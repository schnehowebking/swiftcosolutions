<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $settings;

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'password',
        'type',
        'avatar',
        'lang',
        'created_by',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * 'plan',
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function defaultEmail()
    {
        // Email Template
        $emailTemplate = [
            'New User',
            'New Employee',
            'New Payroll',
            'New Ticket',
            'New Award',
            'Employee Transfer',
            'Employee Resignation',
            'Employee Trip',
            'Employee Promotion',
            'Employee Complaints',
            'Employee Warning',
            'Employee Termination',
            'Leave Status',
            'contract',
        ];

        foreach($emailTemplate as $eTemp)
        {

            EmailTemplate::create(
                [
                    'name' => $eTemp,
                    
                    'slug' => strtolower(str_replace(' ', '_', $eTemp)),
                    'created_by' => 1,
                ]
            );

        }

        $defaultTemplate = [
            'new_user' => [
                'subject' => 'New User',
                'lang' => [
                    'ar' => '<p>مرحبا,</p>
                    <p>مرحبا بك في { app_name }.</p>
                    <p>.. أنت الآن مستعمل</p>
                    <p>البريد الالكتروني : { mail } كلمة السرية : { password }</p>
                    <p>{ app_url }</p>
                    <p>شكرا</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Hej,</p>
                    <p>velkommen til { app_name }.</p>
                    <p>Du er nu bruger ..</p>
                    <p>E-mail: { email }</p>
                    <p>kodeord: { password }</p>
                    <p>{ app_url }</p>
                    <p>Tak.</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Hallo,</p>
                    <p>Willkommen bei {app_name}.</p>
                    <p>Sie sind jetzt Benutzer.</p>
                    <p><strong>E-Mail: {email} </strong></p>
                    <p><strong>Kennwort: {password}</strong></p>
                    <p>{app_url}</p>
                    <p>Danke,</p>
                    <p>{app_name}</p>',
                    'en' => '<p>Hello,&nbsp;<br />Welcome to {app_name}.</p>
                    <p><strong>You are now user..</strong></p>
                    <p><strong>Email </strong>: {email}<br /><strong>Password</strong> : {password}</p>
                    <p>{app_url}</p>
                    <p>Thanks,<br />{app_name}</p>',
                    'es' => '<p>Hola,</p>
                    <p>Bienvenido a {app_name}.</p>
                    <p>Ahora es usuario ..</p>
                    <p><strong>Correo electr&oacute;nico: {email}</strong></p>
                    <p><strong> Contrase&ntilde;a: {password}</strong></p>
                    <p>{app_url}</p>
                    <p>Gracias,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Bonjour,</p>
                    <p>Bienvenue dans { app_name }.</p>
                    <p>Vous &ecirc;tes maintenant utilisateur.</p>
                    <p><strong>E-mail: { email } </strong></p>
                    <p><strong>Mot de passe: { password }</strong></p>
                    <p>{ adresse_url }</p>
                    <p>Merci,</p>
                    <p>{ nom_app }</p>',
                    'it' => '<p>Ciao,</p>
                    <p>Benvenuti in {app_name}.</p>
                    <p>Ora sei utente ..</p>
                    <p><strong>Email: {email} </strong></p>
                    <p><strong>Password: {password}</strong></p>
                    <p>{app_url}</p>
                    <p>Grazie,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>こんにちは、</p>
                    <p>{app_name}へようこそ。</p>
                    <p>これで、ユーザーは</p>
                    <p><strong>E メール : {email}</strong></p>
                    <p><strong> パスワード : {password}</strong></p>
                    <p>{app_url}</p>
                    <p>ありがとう。</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Hallo,</p>
                    <p>Welkom bij { app_name }.</p>
                    <p>U bent nu gebruiker ..</p>
                    <p><strong>E-mail: { email }</strong></p>
                    <p><strong> Wachtwoord: { password }</strong></p>
                    <p>{ app_url }</p>
                    <p>Bedankt.</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Witaj,</p>
                    <p>Witamy w aplikacji {app_name }.</p>
                    <p>Jesteś teraz użytkownikiem ..</p>
                    <p><strong>E-mail</strong>: {email }</p>
                    <p><strong>Hasło</strong>: {password }</p>
                    <p>{app_url }</p>
                    <p>Dziękuję,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Здравствуйте,</p>
                    <p>Добро пожаловать в { app_name }.</p>
                    <p>Вы теперь пользователь ..</p>
                    <p><strong>Адрес электронной почты</strong>: { email }</p>
                    <p><strong> Пароль</strong>: { password }</p>
                    <p>{ app_url }</p>
                    <p>Спасибо.</p>
                    <p>{ app_name&nbsp;}</p>',
                    'pt' => '<p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Ol&aacute;, </span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Bem-vindo a {app_name}.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Voc&ecirc; agora &eacute; usu&aacute;rio ..</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;"><strong>E-mail</strong>: {email}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;"><strong> Senha</strong>: {senha}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{app_url}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Obrigado,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{app_name}</span></p>',
                
                ],
            ],
            'new_employee' => [
                'subject' => 'New Employee',
                'lang' => [
                    'ar' => '<p>مرحبا { employe_name } ،</p>
                    <p>مرحبا بك في { app_name }.</p>
                    <p>أنت الآن موظف</p>
                    <p>البريد الالكتروني : { employe_email }</p>
                    <p>كلمة السرية : { employe_password }</p>
                    <p>{ app_url }</p>
                    <p>شكرا</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Hej { employee_name },</p>
                    <p>velkommen til { app_name }.</p>
                    <p>Du er nu ansat ...</p>
                    <p>E-mail: { employee_email }</p>
                    <p>Kodeord: { employee_kodeord }</p>
                    <p>{ app_url }</p>
                    <p>Tak.</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Hello {employee_name},</p>
                    <p>Willkommen bei {app_name}.</p>
                    <p>Sie sind jetzt Mitarbeiter.</p>
                    <p>E-Mail: {employee_email}</p>
                    <p>Kennwort: {employee_password}</p>
                    <p>{app_url}</p>
                    <p>Danke,</p>
                    <p>{app_name}</p>',
                    'en' => '<p>Hello {employee_name},&nbsp;<br />Welcome to {app_name}.</p>
                    <p>You are now Employee..</p>
                    <p><strong>Email </strong>: {employee_email}</p>
                    <p><strong>Password</strong> : {employee_password}</p>
                    <p>{app_url}</p>
                    <p>Thanks,<br />{app_name}</p>',
                    'es' => '<p style="line-height: 28px;">Hello {employee_name},</p>
                    <p style="line-height: 28px;">Bienvenido a {app_name}.</p>
                    <p style="line-height: 28px;">Ahora es Empleado.</p>
                    <p style="line-height: 28px;">Correo electr&oacute;nico: {employee_email}</p>
                    <p style="line-height: 28px;">Contrase&ntilde;a: {employee_password}</p>
                    <p style="line-height: 28px;">{app_url}</p>
                    <p style="line-height: 28px;">Gracias,</p>
                    <p style="line-height: 28px;">{app_name}</p>',
                    'fr' => '<p style="line-height: 28px;">Hello { employee_name },</p>
                    <p style="line-height: 28px;">Bienvenue dans { app_name }.</p>
                    <p style="line-height: 28px;">Vous &ecirc;tes maintenant Employ&eacute; ..</p>
                    <p style="line-height: 28px;">Adresse &eacute;lectronique: { employee_email }</p>
                    <p style="line-height: 28px;">Mot de passe: { employee_password }</p>
                    <p style="line-height: 28px;">{ adresse_url }</p>
                    <p style="line-height: 28px;">Merci,</p>
                    <p style="line-height: 28px;">{ nom_app }</p>',
                    'it' => '<p style="line-height: 28px;">Hello {employee_name},</p>
                    <p style="line-height: 28px;">Benvenuti in {app_name}.</p>
                    <p style="line-height: 28px;">Ora sei Dipendente ..</p>
                    <p style="line-height: 28px;">Email: {employee_email}</p>
                    <p style="line-height: 28px;">Password: {employee_password}</p>
                    <p style="line-height: 28px;">{app_url}</p>
                    <p style="line-height: 28px;">Grazie,</p>
                    <p style="line-height: 28px;">{app_name}</p>',
                    'ja' => '<p>{ employee_name} にようこそ、</p>
                    <p>{app_name}へようこそ。</p>
                    <p>今は従業員です。</p>
                    <p>E メール : {employee_email}</p>
                    <p>パスワード : {employee_password}</p>
                    <p>{app_url}</p>
                    <p>ありがとう。</p>
                    <p>{app_name}</p>',
                    'nl' => '<p style="line-height: 28px;">Hallo { employee_name },</p>
                    <p style="line-height: 28px;">Welkom bij { app_name }.</p>
                    <p style="line-height: 28px;">U bent nu werknemer ..</p>
                    <p style="line-height: 28px;">E-mail: { employee_email }</p>
                    <p style="line-height: 28px;">Wachtwoord: { employee_password }</p>
                    <p style="line-height: 28px;">{ app_url }</p>
                    <p style="line-height: 28px;">Bedankt.</p>
                    <p style="line-height: 28px;">{ app_name }</p>',
                    'pl' => '<p style="line-height: 28px;">Witaj {employee_name },</p>
                    <p style="line-height: 28px;">Witamy w aplikacji {app_name }.</p>
                    <p style="line-height: 28px;">Jesteś teraz Pracownik ..</p>
                    <p style="line-height: 28px;">E-mail: {employee_email }</p>
                    <p style="line-height: 28px;">Hasło: {employee_password }</p>
                    <p style="line-height: 28px;">{app_url }</p>
                    <p style="line-height: 28px;">Dziękuję,</p>
                    <p style="line-height: 28px;">{app_name }</p>',
                    'ru' => '<p style="line-height: 28px;">Здравствуйте, { employee_name },</p>
                    <p style="line-height: 28px;">Добро пожаловать в { app_name }.</p>
                    <p style="line-height: 28px;">Вы теперь-сотрудник ...</p>
                    <p style="line-height: 28px;">Электронная почта: { employee_email }</p>
                    <p style="line-height: 28px;">Пароль: { employee_password }</p>
                    <p style="line-height: 28px;">{ app_url }</p>
                    <p style="line-height: 28px;">Спасибо.</p>
                    <p style="line-height: 28px;">{ имя_программы }</p> ',
                    'pt' => '<p>Ol&aacute; {employee_name},</p>
                    <p>Bem-vindo a {app_name}.</p>
                    <p>Voc&ecirc; &eacute; agora Funcion&aacute;rio ..</p>
                    <p>E-mail: {employee_email}</p>
                    <p>Senha: {employee_password}</p>
                    <p>{app_url}</p>
                    <p>Obrigado,</p>
                    <p>{app_name}</p>',
                ],
            ],
            'new_payroll' => [
                'subject' => 'New Payroll',
                'lang' => [
                    'ar' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Subject :-إدارة الموارد البشرية / الشركة المعنية بإرسال المدفوعات عن طريق البريد الإلكتروني في وقت تأكيد الدفع.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">مرحبا { name } ،</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">أتمنى أن يجدك هذا البريد الإلكتروني جيدا برجاء الرجوع الى الدفع المتصل الى { salary_month&nbsp;}.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">اضغط ببساطة على الاختيار بأسفل</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">كشوف المرتبات</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">شكرا لك</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Regards,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">إدارة الموارد البشرية ،</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{ app_name }</span></p>',
                    'da' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Om: HR-departementet / Kompagniet til at sende l&oslash;nsedler via e-mail p&aring; tidspunktet for bekr&aelig;ftelsen af l&oslash;nsedlerne</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Hej { name },</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">H&aring;ber denne e-mail finder dig godt! Se vedh&aelig;ftet payseddel for { salary_month }.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">klik bare p&aring; knappen nedenfor</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">L&oslash;nseddel</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Tak.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Med venlig hilsen</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">HR-afdelingen,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{ app_name }</span></p>',
                    'de' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Betrifft: -Personalabteilung/Firma, um Payslips per E-Mail zum Zeitpunkt der Best&auml;tigung des Auszahlungsscheins zu senden</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Hi {name},</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Hoffe, diese E-Mail findet dich gut! Bitte sehen Sie den angeh&auml;ngten payslip f&uuml;r {salary_month}.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Klicken Sie einfach auf den Button unten</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Payslip</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Danke.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Betrachtet,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Personalabteilung,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{app_name}</span></p>',
                    'en' => '<p><strong>Subjec</strong>t:-HR department/Company to send payslips by email at time of confirmation of payslip</p>
                    <p>Hi {name},</p>
                    <p>Hope this email ﬁnds you well! Please see attached payslip for {salary_month}.</p>
                    <p style="text-align: center;" align="center"><strong>simply click on the button below </strong></p>
                    <p style="text-align: center;" align="center"><span style="font-size: 18pt;"><a style="background: #6676ef; color: #ffffff; font-family: "Open Sans", Helvetica, Arial, sans-serif; font-weight: normal; line-height: 120%; margin: 0px; text-decoration: none; text-transform: none;" href="{url}" target="_blank" rel="noopener"> <strong style="color: white; font-weight: bold; text: white;">Payslip</strong> </a></span></p>
                    <p style="text-align: left;" align="center">Feel free to reach out if you have any questions.</p>
                    <p>Thank you</p>
                    <p><strong>Regards,</strong></p>
                    <p><strong>HR Department,</strong></p>
                    <p><span style="color: #000000; font-family: "Open Sans", sans-serif; font-size: 14px; background-color: #ffffff;">{<strong>app_name</strong>}</span></p>',
                    'es' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Asunto: -Departamento de RRHH/Empresa para enviar n&oacute;minas por correo electr&oacute;nico en el momento de la confirmaci&oacute;n del pago</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Hi {name},</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">&iexcl;Espero que este email le encuentre bien! Consulte la ficha de pago adjunta para {salary_month}.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">simplemente haga clic en el bot&oacute;n de abajo</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Payslip</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">&iexcl;Gracias!</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Considerando,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Departamento de Recursos Humanos,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{app_name}</span></p>',
                    'fr' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Objet: -Ressources humaines / Entreprise pour envoyer des feuillets de paie par courriel au moment de la confirmation du paiement</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Salut { name },</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Jesp&egrave;re que ce courriel vous trouve bien ! Veuillez consulter le bordereau de paie ci-joint pour { salary_month }.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Il suffit de cliquer sur le bouton ci-dessous</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Feuillet de paiement</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Je vous remercie</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Regards,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">D&eacute;partement des RH,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{ app_name }</span></p>',
                    'it' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Oggetto: - Dipartimento HR / Societ&agrave; per inviare busta paga via email al momento della conferma della busta paga</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Ciao {name},</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Spero che questa email ti trovi bene! Si prega di consultare la busta paga per {salary_month}.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">semplicemente clicca sul pulsante sottostante</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Busta paga</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Sentiti libero di raggiungere se hai domande.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Grazie</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Riguardo,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Dipartimento HR,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{app_name}</span></p>',
                    'ja' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">件名:-HR 部門/企業は、給与明細書の確認時に電子メールで支払いを送信します。</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">こんにちは {name}、</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">この E メールでよくご確認ください。 {salary_month}の添付された payslip を参照してください。</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">下のボタンをクリックするだけで</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">給与明細書</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">質問がある場合は、自由に連絡してください。</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">ありがとう</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">よろしく</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">HR 部門</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{app_name}</span></p>',
                    'nl' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Betreft: -HR-afdeling/Bedrijf om te betalen payslips per e-mail op het moment van bevestiging van de payslip</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Hallo { name },</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Hoop dat deze e-mail je goed vindt! Zie bijgevoegde payslip voor { salary_month }.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">gewoon klikken op de knop hieronder</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Loonstrook</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Voel je vrij om uit te reiken als je vragen hebt.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Dank u wel</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Betreft:</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">HR-afdeling,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{ app_name }</span></p>',
                    'pl' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Temat:-Dział HR/Firma do wysyłania payslip&oacute;w drogą mailową w czasie potwierdzania payslipa</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Witaj {name },</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Mam nadzieję, że ta wiadomość znajdzie Cię dobrze! Patrz załączony payslip dla {salary_month }.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">po prostu kliknij na przycisk poniżej</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Payslip</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Czuj się swobodnie, jeśli masz jakieś pytania.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Dziękujemy</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">W odniesieniu do</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Dział HR,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{app_name }</span></p>',
                    'ru' => '<p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Тема: -HR отдел/Компания для отправки паузу по электронной почте во время подтверждения паузли</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Привет { name },</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Надеюсь, это электронное письмо найдет вас хорошо! См. вложенный раздел для { salary_month }.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">просто нажмите на кнопку внизу</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Паушлип</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Не стеснитесь, если у вас есть вопросы.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Спасибо.</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">С уважением,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">Отдел кадров,</span></p>
                    <p style="line-height: 28px; font-family: Nunito,;"><span style="font-family: sans-serif;">{ app_name }</span></p>',
                    'pt' => '<p>Assunto:-Departamento de RH / Empresa para enviar payslips por e-mail no momento da confirma&ccedil;&atilde;o do payslip</p>
                    <p>Oi {name},</p>
                    <p>Espero que este e-mail encontre voc&ecirc; bem! Por favor, consulte o payslip anexado por {salary_month}.</p>
                    <p>basta clicar no bot&atilde;o abaixo</p>
                    <p>Payslip</p>
                    <p>Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</p>
                    <p>Obrigado</p>
                    <p>Considera,</p>
                    <p>Departamento de RH,</p>
                    <p>{app_name}</p>',
                ],
            ],
            'new_ticket' => [
                'subject' => 'New Ticket',
                'lang' => [
                    'ar' => '<p>Subject : -HR ادارة / شركة لارسال ticket ل ـ { ticket_title }</p>
                    <p>مرحبا { ticket_name }</p>
                    <p>آمل أن يقوم هذا البريد الالكتروني بايجادك جيدا ! ، كود التذكرة الخاص بك هو { ticket_code }.</p>
                    <p>{ ticket_description } ،</p>
                    <p>إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</p>
                    <p>شكرا لك</p>
                    <p>Regards,</p>
                    <p>إدارة الموارد البشرية ،</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Emne:-HR-afdeling / Kompagni til at sende ticket for { ticket_title }</p>
                    <p>Hej { ticket_name },</p>
                    <p>H&aring;ber denne e-mail finder dig godt, din ticket-kode er { ticket_code }.</p>
                    <p>{ ticket_description },</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betreff: -Personalabteilung/Firma zum Senden von Ticket f&uuml;r {ticket_title}</p>
                    <p>Hi {ticket_name},</p>
                    <p>Hoffen Sie, diese E-Mail findet Sie gut!, Ihr Ticketcode ist {ticket_code}.</p>
                    <p>{ticket_description},</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p ><b>Subject:-HR department/Company to send ticket for {ticket_title}</b></p>
                    <p ><b>Hi {ticket_name},</b></p>
                    <p >Hope this email ﬁnds you well! , Your ticket code is {ticket_code}. </p></br>
                    {ticket_description},
                    <p >Feel free to reach out if you have any questions.</p></br>
                    <p><b>Thank you</b></p>
                    <p><b>Regards,</b></p>
                    <p><b>HR Department,</b></p>
                    <p><b>{app_name}</b></p>
                    ',
                    'es' => '<p>Asunto: -Departamento de RR.HH./Empresa para enviar el ticket de {ticket_title}</p>
                    <p>Hi {ticket_name},</p>
                    <p>&iexcl;Espero que este correo electr&oacute;nico te encuentre bien!, Tu c&oacute;digo de entrada es {ticket_code}.</p>
                    <p>{ticket_description},</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -HR department / Company to send ticket for { ticket_title }</p>
                    <p>Hi { ticket_name },</p>
                    <p>Hope this email vous trouve bien !, Votre code de ticket est { ticket_code }.</p>
                    <p>{ ticket_description },</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare ticket per {ticket_title}</p>
                    <p>Ciao {ticket_name},</p>
                    <p>Spero che questa email ti trovi bene!, Il tuo codice del biglietto &egrave; {ticket_code}.</p>
                    <p>{ticket_description},</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>件名:-HR 部門/企業は、 {ticket_title} のチケットを送信します</p>
                    <p>こんにちは {ticket_name}</p>
                    <p>この E メールが適切に検出されることを希望しています。チケット・コードは {ticket_code}です。</p>
                    <p>{ticket_description }</p>
                    <p>質問がある場合は、自由に連絡してください。</p>
                    <p>ありがとう</p>
                    <p>よろしく</p>
                    <p>HR 部門</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf voor het verzenden van ticket voor { ticket_title }</p>
                    <p>Hallo { ticket_name },</p>
                    <p>Hoop dat deze e-mail u goed vindt!, Uw ticket code is { ticket_code }.</p>
                    <p>{ ticket_description},</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat:-Dział HR/Firma do wysyłki biletu dla {ticket_title }</p>
                    <p>Witaj {ticket_name },</p>
                    <p>Mam nadzieję, że ta wiadomość e-mail znajduje się dobrze!, Tw&oacute;j kod zgłoszenia to {ticket_code }.</p>
                    <p>{ticket_description },</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания для отправки билета для { ticket_title }</p>
                    <p>Hi { ticket_name },</p>
                    <p>Надеюсь, что это письмо найдет вас хорошо!, Ваш код паспорта-{ ticket_code }.</p>
                    <p>{ ticket_description },</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p>Assunto:-Departamento de RH / Empresa para enviar ingresso para {ticket_title}</p>
                    <p>Oi {ticket_name},</p>
                    <p>Espero que este e-mail te encontre bem!, Seu c&oacute;digo de bilhete &eacute; {ticket_code}.</p>
                    <p>{ticket_description},</p>
                    <p>Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</p>
                    <p>Obrigado</p>
                    <p>Considera,</p>
                    <p>Departamento de RH,</p>
                    <p>{app_name}</p>',
                ],
            ],
            'new_award' => [
                'subject' => 'New Award',
                'lang' => [
                    'ar' => '<p>Subject :-إدارة الموارد البشرية / الشركة المعنية بإرسال خطاب تحكيم للاعتراف بموظف</p>
                    <p>مرحبا { award_name },</p>
                    <p>ويسرني كثيرا أن أرشحها { award_name }</p>
                    <p>وإنني مقتنع بأن (هي / هي) هي أفضل موظفة للحصول على الجائزة. وقد أدركت أنها شخصية موجهة نحو تحقيق الأهداف ، وتتسم بالكفاءة والفعالية في التقيد بالمواعيد. إنها دائما على استعداد لمشاركة معرفتها بالتفاصيل</p>
                    <p>وبالإضافة إلى ذلك ، قامت (هي / هي) أحيانا بحل النزاعات والحالات الصعبة خلال ساعات العمل. (هي / هي) حصلت على بعض الجوائز من المنظمة غير الحكومية داخل البلد ؛ وكان ذلك بسبب المشاركة في أنشطة خيرية لمساعدة المحتاجين.</p>
                    <p>وأعتقد أن هذه الصفات والصفات يجب أن تكون موضع تقدير. ولذلك ، فإن (هي / هي) تستحق أن تمنحها الجائزة بالتالي.</p>
                    <p>إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</p>
                    <p>شكرا لك</p>
                    <p>Regards,</p>
                    <p>إدارة الموارد البشرية ،</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Om: HR-afdelingen / Kompagniet for at sende prisuddeling for at kunne genkende en medarbejder</p>
                    <p>Hej { award_name },</p>
                    <p>Jeg er meget glad for at nominere {award_name&nbsp;}</p>
                    <p>Jeg er tilfreds med, at (hun) er den bedste medarbejder for prisen. Jeg har indset, at hun er en m&aring;lbevidst person, effektiv og meget punktlig. Hun er altid klar til at dele sin viden om detaljer.</p>
                    <p>Desuden har (he/she) lejlighedsvist l&oslash;st konflikter og vanskelige situationer inden for arbejdstiden. (/hun) har modtaget nogle priser fra den ikkestatslige organisation i landet. Dette skyldes, at der skal v&aelig;re en del i velg&oslash;renhedsaktiviteter for at hj&aelig;lpe de tr&aelig;ngende.</p>
                    <p>Jeg mener, at disse kvaliteter og egenskaber skal v&aelig;rds&aelig;tte. Derfor fortjener denne pris, at hun nominerer hende.</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betrifft: -Personalabteilung/Firma zum Versenden von Pr&auml;mienschreiben, um einen Mitarbeiter zu erkennen</p>
                    <p>Hi {award_name},</p>
                    <p>Ich freue mich sehr, {award_name} zu nominieren.</p>
                    <p>Ich bin zufrieden, dass (he/she) der beste Mitarbeiter f&uuml;r die Auszeichnung ist. Ich habe erkannt, dass sie eine gottorientierte Person ist, effizient und sehr p&uuml;nktlich. Sie ist immer bereit, ihr Wissen &uuml;ber Details zu teilen.</p>
                    <p>Dar&uuml;ber hinaus hat (he/she) gelegentlich Konflikte und schwierige Situationen innerhalb der Arbeitszeiten gel&ouml;st. (he/she) hat einige Auszeichnungen von der Nichtregierungsorganisation innerhalb des Landes erhalten; dies war wegen der Teilnahme an Wohlt&auml;tigkeitsaktivit&auml;ten, um den Bed&uuml;rftigen zu helfen.</p>
                    <p>Ich glaube, diese Eigenschaften und Eigenschaften m&uuml;ssen gew&uuml;rdigt werden. Daher verdient (he/she) die Auszeichnung, die sie deshalb nominiert.</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p ><b>Subject:-HR department/Company to send award letter to recognize an employee</b></p>
                    <p ><b>Hi {award_name},</b></p>
                    <p >I am much pleased to nominate {award_name}  </p>
                    <p >I am satisfied that (he/she) is the best employee for the award. I have realized that she is a goal-oriented person, efficient and very punctual. She is always ready to share her knowledge of details.</p>
                    <p>Additionally, (he/she) has occasionally solved conflicts and difficult situations within working hours. (he/she) has received some awards from the non-governmental organization within the country; this was because of taking part in charity activities to help the needy.</p>
                    <p>I believe these qualities and characteristics need to be appreciated. Therefore, (he/she) deserves the award hence nominating her.</p>
                    <p>Feel free to reach out if you have any questions.</p>
                    <p><b>Thank you</b></p>
                    <p><b>Regards,</b></p>
                    <p><b>HR Department,</b></p>
                    <p><b>{app_name}</b></p>',
                    'es' => '<p>Asunto: -Departamento de RRHH/Empresa para enviar carta de premios para reconocer a un empleado</p>
                    <p>Hi {award_name},</p>
                    <p>Estoy muy satisfecho de nominar {award_name}</p>
                    <p>Estoy satisfecho de que (ella) sea el mejor empleado para el premio. Me he dado cuenta de que es una persona orientada al objetivo, eficiente y muy puntual. Ella siempre est&aacute; lista para compartir su conocimiento de los detalles.</p>
                    <p>Adicionalmente, (he/ella) ocasionalmente ha resuelto conflictos y situaciones dif&iacute;ciles dentro de las horas de trabajo. (h/ella) ha recibido algunos premios de la organizaci&oacute;n no gubernamental dentro del pa&iacute;s; esto fue debido a participar en actividades de caridad para ayudar a los necesitados.</p>
                    <p>Creo que estas cualidades y caracter&iacute;sticas deben ser apreciadas. Por lo tanto, (h/ella) merece el premio por lo tanto nominarla.</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -Minist&egrave;re des RH / Soci&eacute;t&eacute; denvoi dune lettre dattribution pour reconna&icirc;tre un employ&eacute;</p>
                    <p>Hi { award_name },</p>
                    <p>Je suis tr&egrave;s heureux de nommer { award_name }</p>
                    <p>Je suis convaincu que (he/elle) est le meilleur employ&eacute; pour ce prix. Jai r&eacute;alis&eacute; quelle est une personne orient&eacute;e vers lobjectif, efficace et tr&egrave;s ponctuelle. Elle est toujours pr&ecirc;te &agrave; partager sa connaissance des d&eacute;tails.</p>
                    <p>De plus, (he/elle) a parfois r&eacute;solu des conflits et des situations difficiles dans les heures de travail. (he/elle) a re&ccedil;u des prix de lorganisation non gouvernementale &agrave; lint&eacute;rieur du pays, parce quelle a particip&eacute; &agrave; des activit&eacute;s de bienfaisance pour aider les n&eacute;cessiteux.</p>
                    <p>Je crois que ces qualit&eacute;s et ces caract&eacute;ristiques doivent &ecirc;tre appr&eacute;ci&eacute;es. Par cons&eacute;quent, (he/elle) m&eacute;rite le prix donc nomin&eacute;.</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di premiazione per riconoscere un dipendente</p>
                    <p>Ciao {award_name},</p>
                    <p>Sono molto lieto di nominare {award_name}</p>
                    <p>Sono soddisfatto che (he/lei) sia il miglior dipendente per il premio. Ho capito che &egrave; una persona orientata al goal-oriented, efficiente e molto puntuale. &Egrave; sempre pronta a condividere la sua conoscenza dei dettagli.</p>
                    <p>Inoltre, (he/lei) ha occasionalmente risolto conflitti e situazioni difficili allinterno delle ore di lavoro. (he/lei) ha ricevuto alcuni premi dallorganizzazione non governativa allinterno del paese; questo perch&eacute; di prendere parte alle attivit&agrave; di beneficenza per aiutare i bisognosi.</p>
                    <p>Credo che queste qualit&agrave; e caratteristiche debbano essere apprezzate. Pertanto, (he/lei) merita il premio da qui la nomina.</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>件名: 従業員を認識するための表彰書を送信するための、人事部門/ 会社</p>
                    <p>やあ {award_name }</p>
                    <p>{award_name }をノミネートしたいと考えています。</p>
                    <p>私は ( 彼女が ) 賞のための最高の従業員だと満足している。 私は彼女が、自分が目標指向の人間であり、効率的で、非常に時間厳守であることに気付きました。 彼女はいつも詳細についての知識を共有する準備ができている。</p>
                    <p>また、時には労働時間内に紛争や困難な状況を解決することがある。 ( 彼女は ) 国内の非政府組織からいくつかの賞を受賞している。このことは、慈善活動に参加して、貧窮者を助けるためのものだった。</p>
                    <p>これらの特性と特徴を評価する必要があると思います。 そのため、 ( 相続人は ) 賞に値するので彼女を指名することになる。</p>
                    <p>質問がある場合は、自由に連絡してください。</p>
                    <p>ありがとう</p>
                    <p>よろしく</p>
                    <p>HR 部門</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf om een gunningsbrief te sturen om een werknemer te herkennen</p>
                    <p>Hallo { award_name },</p>
                    <p>Ik ben erg blij om { award_name } te nomineren</p>
                    <p>Ik ben tevreden dat (he/zij) de beste werknemer voor de prijs is. Ik heb me gerealiseerd dat ze een doelgericht persoon is, effici&euml;nt en punctueel. Ze is altijd klaar om haar kennis van details te delen.</p>
                    <p>Daarnaast heeft (he/she) af en toe conflicten en moeilijke situaties binnen de werkuren opgelost. (he/zij) heeft een aantal prijzen ontvangen van de niet-gouvernementele organisatie binnen het land; dit was vanwege het deelnemen aan liefdadigheidsactiviteiten om de behoeftigen te helpen.</p>
                    <p>Ik ben van mening dat deze kwaliteiten en eigenschappen moeten worden gewaardeerd. Daarom, (he/she) verdient de award dus nomineren haar.</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat:-Dział HR/Firma do wysyłania list&oacute;w wyr&oacute;żnienia do rozpoznania pracownika</p>
                    <p>Witaj {award_name },</p>
                    <p>Jestem bardzo zadowolony z nominacji {award_name }</p>
                    <p>Jestem zadowolony, że (he/she) jest najlepszym pracownikiem do nagrody. Zdałem sobie sprawę, że jest osobą zorientowaną na goły, sprawną i bardzo punktualną. Zawsze jest gotowa podzielić się swoją wiedzą na temat szczeg&oacute;ł&oacute;w.</p>
                    <p>Dodatkowo, (he/she) od czasu do czasu rozwiązuje konflikty i trudne sytuacje w godzinach pracy. (he/she) otrzymała kilka nagr&oacute;d od organizacji pozarządowej w obrębie kraju; to z powodu wzięcia udziału w akcji charytatywnych, aby pom&oacute;c potrzebującym.</p>
                    <p>Uważam, że te cechy i cechy muszą być docenione. Dlatego też, (he/she) zasługuje na nagrodę, stąd nominowanie jej.</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания отправить награда письмо о признании сотрудника</p>
                    <p>Здравствуйте, { award_name },</p>
                    <p>Мне очень приятно номинировать { award_name }</p>
                    <p>Я удовлетворена тем, что (х/она) является лучшим работником премии. Я понял, что она ориентированная на цель человек, эффективная и очень пунктуальная. Она всегда готова поделиться своими знаниями о деталях.</p>
                    <p>Кроме того, время от времени решались конфликты и сложные ситуации в рабочее время. (она) получила некоторые награды от неправительственной организации в стране; это было связано с тем, что они приняли участие в благотворительной деятельности, чтобы помочь нуждающимся.</p>
                    <p>Я считаю, что эти качества и характеристики заслуживают высокой оценки. Таким образом, она заслуживает того, чтобы наградить ее таким образом.</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Assunto:-Departamento de RH / Empresa para enviar carta de premia&ccedil;&atilde;o para reconhecer um funcion&aacute;rio</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Oi {award_name},</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Estou muito satisfeito em nomear {award_name}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Estou satisfeito que (he/she) &eacute; o melhor funcion&aacute;rio para o pr&ecirc;mio. Eu percebi que ela &eacute; uma pessoa orientada a goal, eficiente e muito pontual. Ela est&aacute; sempre pronta para compartilhar seu conhecimento de detalhes.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Adicionalmente, (he/she) tem, ocasionalmente, resolvido conflitos e situa&ccedil;&otilde;es dif&iacute;ceis dentro do hor&aacute;rio de trabalho. (he/she) recebeu alguns pr&ecirc;mios da organiza&ccedil;&atilde;o n&atilde;o governamental dentro do pa&iacute;s; isso foi por ter participado de atividades de caridade para ajudar os necessitados.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Eu acredito que essas qualidades e caracter&iacute;sticas precisam ser apreciadas. Por isso, (he/she) merece o pr&ecirc;mio da&iacute; nomeando-a.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Obrigado</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Considera,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Departamento de RH,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{app_name}</span></p>',
                ],
            ],
            
            'employee_transfer' => [
                'subject' => 'Employee Transfer',
                'lang' => [
                    'ar' => '<p>Subject : -HR ادارة / شركة لارسال خطاب نقل الى موظف من مكان الى آخر.</p>
                    <p>عزيزي { transfer_name },</p>
                    <p>وفقا لتوجيهات الادارة ، يتم نقل الخدمات الخاصة بك w.e.f. { transfer_date }.</p>
                    <p>مكان الادخال الجديد الخاص بك هو { transfer_department } قسم من فرع { transfer_branch } وتاريخ التحويل { transfer_date }.</p>
                    <p>{ transfer_description }.</p>
                    <p>إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</p>
                    <p>شكرا لك</p>
                    <p>Regards,</p>
                    <p>إدارة الموارد البشرية ،</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Emne:-HR-afdelingen / kompagniet om at sende overf&oslash;rsels brev til en medarbejder fra den ene lokalitet til den anden.</p>
                    <p>K&aelig;re { transfer_name },</p>
                    <p>Som Styring af direktiver overf&oslash;res dine serviceydelser w.e.f. { transfer_date }.</p>
                    <p>Dit nye sted for postering er { transfer_departement } afdeling af { transfer_branch } gren og dato for overf&oslash;rsel { transfer_date }.</p>
                    <p>{ transfer_description }.</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betreff: -Personalabteilung/Unternehmen, um einen &Uuml;berweisungsschreiben an einen Mitarbeiter von einem Standort an einen anderen zu senden.</p>
                    <p>Sehr geehrter {transfer_name},</p>
                    <p>Wie pro Management-Direktiven werden Ihre Dienste &uuml;ber w.e.f. {transfer_date} &uuml;bertragen.</p>
                    <p>Ihr neuer Ort der Entsendung ist {transfer_department} Abteilung von {transfer_branch} Niederlassung und Datum der &Uuml;bertragung {transfer_date}.</p>
                    <p>{transfer_description}.</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p ><b>Subject:-HR department/Company to send transfer letter to be issued to an employee from one location to another.</b></p>
                    <p ><b>Dear {transfer_name},</b></p>
                    <p >As per Management directives, your services are being transferred w.e.f.{transfer_date}. </p>
                    <p >Your new place of posting is {transfer_department} department of {transfer_branch} branch and date of transfer {transfer_date}. </p>
                    {transfer_description}.
                    <p>Feel free to reach out if you have any questions.</p>
                    <p><b>Thank you</b></p>
                    <p><b>Regards,</b></p>
                    <p><b>HR Department,</b></p>
                    <p><b>{app_name}</b></p>',
                    'es' => '<p>Asunto: -Departamento de RR.HH./Empresa para enviar carta de transferencia a un empleado de un lugar a otro.</p>
                    <p>Estimado {transfer_name},</p>
                    <p>Seg&uacute;n las directivas de gesti&oacute;n, los servicios se transfieren w.e.f. {transfer_date}.</p>
                    <p>El nuevo lugar de publicaci&oacute;n es el departamento {transfer_department} de la rama {transfer_branch} y la fecha de transferencia {transfer_date}.</p>
                    <p>{transfer_description}.</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -Minist&egrave;re des RH / Soci&eacute;t&eacute; denvoi dune lettre de transfert &agrave; un employ&eacute; dun endroit &agrave; un autre.</p>
                    <p>Cher { transfer_name },</p>
                    <p>Selon les directives de gestion, vos services sont transf&eacute;r&eacute;s dans w.e.f. { transfer_date }.</p>
                    <p>Votre nouveau lieu daffectation est le d&eacute;partement { transfer_department } de la branche { transfer_branch } et la date de transfert { transfer_date }.</p>
                    <p>{ description_transfert }.</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di trasferimento da rilasciare a un dipendente da una localit&agrave; allaltra.</p>
                    <p>Caro {transfer_name},</p>
                    <p>Come per le direttive di Management, i tuoi servizi vengono trasferiti w.e.f. {transfer_date}.</p>
                    <p>Il tuo nuovo luogo di distacco &egrave; {transfer_department} dipartimento di {transfer_branch} ramo e data di trasferimento {transfer_date}.</p>
                    <p>{transfer_description}.</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di trasferimento da rilasciare a un dipendente da una localit&agrave; allaltra.</p>
                    <p>Caro {transfer_name},</p>
                    <p>Come per le direttive di Management, i tuoi servizi vengono trasferiti w.e.f. {transfer_date}.</p>
                    <p>Il tuo nuovo luogo di distacco &egrave; {transfer_department} dipartimento di {transfer_branch} ramo e data di trasferimento {transfer_date}.</p>
                    <p>{transfer_description}.</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf voor verzending van overdrachtsbrief aan een werknemer van de ene plaats naar de andere.</p>
                    <p>Geachte { transfer_name },</p>
                    <p>Als per beheerinstructie worden uw services overgebracht w.e.f. { transfer_date }.</p>
                    <p>Uw nieuwe plaats van post is { transfer_department } van de afdeling { transfer_branch } en datum van overdracht { transfer_date }.</p>
                    <p>{ transfer_description }.</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat:-Dział HR/Firma do wysyłania listu przelewowego, kt&oacute;ry ma być wydany pracownikowi z jednego miejsca do drugiego.</p>
                    <p>Droga {transfer_name },</p>
                    <p>Zgodnie z dyrektywami zarządzania, Twoje usługi są przesyłane w.e.f. {transfer_date }.</p>
                    <p>Twoje nowe miejsce delegowania to {transfer_department } dział {transfer_branch } gałąź i data transferu {transfer_date }.</p>
                    <p>{transfer_description }.</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания для отправки трансферного письма сотруднику из одного места в другое.</p>
                    <p>Уважаемый { transfer_name },</p>
                    <p>В соответствии с директивами управления ваши службы передаются .ef. { transfer_date }.</p>
                    <p>Новое место разноски: { transfer_department} подразделение { transfer_branch } и дата передачи { transfer_date }.</p>
                    <p>{ transfer_description }.</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Assunto:-Departamento de RH / Empresa para enviar carta de transfer&ecirc;ncia para ser emitida para um funcion&aacute;rio de um local para outro.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Querido {transfer_name},</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Conforme diretivas de Gerenciamento, seus servi&ccedil;os est&atilde;o sendo transferidos w.e.f. {transfer_date}.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">O seu novo local de postagem &eacute; {transfer_departamento} departamento de {transfer_branch} ramo e data de transfer&ecirc;ncia {transfer_date}.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{transfer_description}.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Obrigado</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Considera,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Departamento de RH,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{app_name}</span></p>',
                ],
            ],
            
            'employee_resignation' => [
                'subject' => 'Employee Resignation',
                'lang' => [
                    'ar' => '<p>Subject :-قسم الموارد البشرية / الشركة لإرسال خطاب استقالته.</p>
                    <p>عزيزي { assign_user } ،</p>
                    <p>إنه لمن دواعي الأسف الشديد أن أعترف رسميا باستلام إشعار استقالتك في { notice_date } الى { resignation_date } هو اليوم الأخير لعملك.</p>
                    <p>لقد كان من دواعي سروري العمل معكم ، وبالنيابة عن الفريق ، أود أن أتمنى لكم أفضل جدا في جميع مساعيكم في المستقبل. ومن خلال هذه الرسالة ، يرجى العثور على حزمة معلومات تتضمن معلومات مفصلة عن عملية الاستقالة.</p>
                    <p>شكرا لكم مرة أخرى على موقفكم الإيجابي والعمل الجاد كل هذه السنوات.</p>
                    <p>إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</p>
                    <p>شكرا لك</p>
                    <p>Regards,</p>
                    <p>إدارة الموارد البشرية ،</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Om: HR-afdelingen / Kompagniet, for at sende en opsigelse.</p>
                    <p>K&aelig;re { assign_user },</p>
                    <p>Det er med stor beklagelse, at jeg formelt anerkender modtagelsen af din opsigelsesmeddelelse p&aring; { notice_date } til { resignation_date } er din sidste arbejdsdag</p>
                    <p>Det har v&aelig;ret en forn&oslash;jelse at arbejde sammen med Dem, og p&aring; vegne af teamet vil jeg &oslash;nske Dem det bedste i alle Deres fremtidige bestr&aelig;belser. Med dette brev kan du finde en informationspakke med detaljerede oplysninger om tilbagetr&aelig;delsesprocessen.</p>
                    <p>Endnu en gang tak for Deres positive holdning og h&aring;rde arbejde i alle disse &aring;r.</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betreff: -Personalabteilung/Firma, um R&uuml;ckmeldungsschreiben zu senden.</p>
                    <p>Sehr geehrter {assign_user},</p>
                    <p>Es ist mit gro&szlig;em Bedauern, dass ich den Eingang Ihrer R&uuml;cktrittshinweis auf {notice_date} an {resignation_date} offiziell best&auml;tige, ist Ihr letzter Arbeitstag.</p>
                    <p>Es war eine Freude, mit Ihnen zu arbeiten, und im Namen des Teams m&ouml;chte ich Ihnen w&uuml;nschen, dass Sie in allen Ihren zuk&uuml;nftigen Bem&uuml;hungen am besten sind. In diesem Brief finden Sie ein Informationspaket mit detaillierten Informationen zum R&uuml;cktrittsprozess.</p>
                    <p>Vielen Dank noch einmal f&uuml;r Ihre positive Einstellung und harte Arbeit all die Jahre.</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p ><b>Subject:-HR department/Company to send resignation letter .</b></p>
                    <p ><b>Dear {assign_user},</b></p>
                    <p >It is with great regret that I formally acknowledge receipt of your resignation notice on {notice_date} to {resignation_date} is your final day of work. </p>
                    <p >It has been a pleasure working with you, and on behalf of the team, I would like to wish you the very best in all your future endeavors. Included with this letter, please find an information packet with detailed information on the resignation process. </p>
                    <p>Thank you again for your positive attitude and hard work all these years.</p>
                    <p>Feel free to reach out if you have any questions.</p>
                    <p>Thank you</p>
                    <p><b>Regards,</b></p>
                    <p><b>HR Department,</b></p>
                    <p><b>{app_name}</b></p>',
                    'es' => '<p>Asunto: -Departamento de RRHH/Empresa para enviar carta de renuncia.</p>
                    <p>Estimado {assign_user},</p>
                    <p>Es con gran pesar que recibo formalmente la recepci&oacute;n de su aviso de renuncia en {notice_date} a {resignation_date} es su &uacute;ltimo d&iacute;a de trabajo.</p>
                    <p>Ha sido un placer trabajar con usted, y en nombre del equipo, me gustar&iacute;a desearle lo mejor en todos sus esfuerzos futuros. Incluido con esta carta, por favor encuentre un paquete de informaci&oacute;n con informaci&oacute;n detallada sobre el proceso de renuncia.</p>
                    <p>Gracias de nuevo por su actitud positiva y trabajo duro todos estos a&ntilde;os.</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -D&eacute;partement RH / Soci&eacute;t&eacute; denvoi dune lettre de d&eacute;mission.</p>
                    <p>Cher { assign_user },</p>
                    <p>Cest avec grand regret que je reconnais officiellement la r&eacute;ception de votre avis de d&eacute;mission sur { notice_date } &agrave; { resignation_date } est votre dernier jour de travail.</p>
                    <p>Cest un plaisir de travailler avec vous, et au nom de l&eacute;quipe, jaimerais vous souhaiter le meilleur dans toutes vos activit&eacute;s futures. Inclus avec cette lettre, veuillez trouver un paquet dinformation contenant des informations d&eacute;taill&eacute;es sur le processus de d&eacute;mission.</p>
                    <p>Je vous remercie encore de votre attitude positive et de votre travail acharne durant toutes ces ann&eacute;es.</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di dimissioni.</p>
                    <p>Caro {assign_user},</p>
                    <p>&Egrave; con grande dispiacere che riconosca formalmente la ricezione del tuo avviso di dimissioni su {notice_date} a {resignation_date} &egrave; la tua giornata di lavoro finale.</p>
                    <p>&Egrave; stato un piacere lavorare con voi, e a nome della squadra, vorrei augurarvi il massimo in tutti i vostri futuri sforzi. Incluso con questa lettera, si prega di trovare un pacchetto informativo con informazioni dettagliate sul processo di dimissioni.</p>
                    <p>Grazie ancora per il vostro atteggiamento positivo e duro lavoro in tutti questi anni.</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>件名:-HR 部門/企業は辞表を送信します。</p>
                    <p>{assign_user} の認証を解除します。</p>
                    <p>{ notice_date} に対するあなたの辞任通知を { resignation_date} に正式に受理することを正式に確認することは、非常に残念です。</p>
                    <p>あなたと一緒に仕事をしていて、チームのために、あなたの将来の努力において、あなたのことを最高のものにしたいと思っています。 このレターには、辞任プロセスに関する詳細な情報が記載されている情報パケットをご覧ください。</p>
                    <p>これらの長年の前向きな姿勢と努力を重ねて感謝します。</p>
                    <p>質問がある場合は、自由に連絡してください。</p>
                    <p>ありがとう</p>
                    <p>よろしく</p>
                    <p>HR 部門</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf om ontslagbrief te sturen.</p>
                    <p>Geachte { assign_user },</p>
                    <p>Het is met grote spijt dat ik de ontvangst van uw ontslagbrief op { notice_date } tot { resignation_date } formeel de ontvangst van uw laatste dag van het werk bevestigt.</p>
                    <p>Het was een genoegen om met u samen te werken, en namens het team zou ik u het allerbeste willen wensen in al uw toekomstige inspanningen. Vermeld bij deze brief een informatiepakket met gedetailleerde informatie over het ontslagproces.</p>
                    <p>Nogmaals bedankt voor uw positieve houding en hard werken al die jaren.</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat: -Dział HR/Firma do wysyłania listu rezygnacyjnego.</p>
                    <p>Drogi użytkownika {assign_user },</p>
                    <p>Z wielkim żalem, że oficjalnie potwierdzam otrzymanie powiadomienia o rezygnacji w dniu {notice_date } to {resignation_date } to tw&oacute;j ostatni dzień pracy.</p>
                    <p>Z przyjemnością wsp&oacute;łpracujemy z Tobą, a w imieniu zespołu chciałbym życzyć Wam wszystkiego najlepszego we wszystkich swoich przyszłych przedsięwzięciu. Dołączone do tego listu prosimy o znalezienie pakietu informacyjnego ze szczeg&oacute;łowymi informacjami na temat procesu dymisji.</p>
                    <p>Jeszcze raz dziękuję za pozytywne nastawienie i ciężką pracę przez te wszystkie lata.</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания отправить письмо об отставке.</p>
                    <p>Уважаемый пользователь { assign_user },</p>
                    <p>С большим сожалением я официально подтверждаю получение вашего уведомления об отставке { notice_date } в { resignation_date }-это ваш последний день работы.</p>
                    <p>С Вами было приятно работать, и от имени команды я хотел бы по# желать вам самого лучшего во всех ваших будущих начинаниях. В этом письме Вы можете найти информационный пакет с подробной информацией об отставке.</p>
                    <p>Еще раз спасибо за ваше позитивное отношение и трудолюбие все эти годы.</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Assunto:-Departamento de RH / Empresa para enviar carta de demiss&atilde;o.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Querido {assign_user},</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">&Eacute; com grande pesar que reconhe&ccedil;o formalmente o recebimento do seu aviso de demiss&atilde;o em {notice_date} a {resignation_date} &eacute; o seu dia final de trabalho.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Foi um prazer trabalhar com voc&ecirc;, e em nome da equipe, gostaria de desej&aacute;-lo o melhor em todos os seus futuros empreendimentos. Inclu&iacute;dos com esta carta, por favor, encontre um pacote de informa&ccedil;&otilde;es com informa&ccedil;&otilde;es detalhadas sobre o processo de demiss&atilde;o.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Obrigado novamente por sua atitude positiva e trabalho duro todos esses anos.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Obrigado</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Considera,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Departamento de RH,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{app_name}</span></p>',
                ],
            ],


            
            'employee_trip' => [
                'subject' => 'Employee Trip',
                'lang' => [
                    'ar' => '<p>Subject : -HR ادارة / شركة لارسال رسالة رحلة.</p>
                    <p>عزيزي { employee_trip_name },</p>
                    <p>قمة الصباح إليك ! أكتب إلى مكتب إدارتكم بطلب متواضع للسفر من أجل زيارة إلى الخارج عن قصد.</p>
                    <p>وسيكون هذا المنتدى هو المنتدى الرئيسي لأعمال المناخ في العام ، وقد كان محظوظا بما فيه الكفاية لكي يرشح لتمثيل شركتنا والمنطقة خلال الحلقة الدراسية.</p>
                    <p>إن عضويتي التي دامت ثلاث سنوات كجزء من المجموعة والمساهمات التي قدمتها إلى الشركة ، ونتيجة لذلك ، كانت مفيدة من الناحية التكافلية. وفي هذا الصدد ، فإنني أطلب منكم بصفتي الرئيس المباشر لي أن يسمح لي بالحضور.</p>
                    <p>مزيد من التفاصيل عن الرحلة :&nbsp;</p>
                    <p>مدة الرحلة : { start_date } الى { end_date }</p>
                    <p>الغرض من الزيارة : { purpose_of_visit }</p>
                    <p>مكان الزيارة : { place_of_visit }</p>
                    <p>الوصف : { trip_description }</p>
                    <p>إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</p>
                    <p>شكرا لك</p>
                    <p>Regards,</p>
                    <p>إدارة الموارد البشرية ،</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Om: HR-afdelingen / Kompagniet, der skal sende udflugten.</p>
                    <p>K&aelig;re { employee_trip_name },</p>
                    <p>Godmorgen til dig! Jeg skriver til dit kontor med en ydmyg anmodning om at rejse for en { purpose_of_visit } i udlandet.</p>
                    <p>Det ville v&aelig;re &aring;rets f&oslash;rende klimaforum, og det ville v&aelig;re heldigt nok at blive nomineret til at repr&aelig;sentere vores virksomhed og regionen under seminaret.</p>
                    <p>Mit tre&aring;rige medlemskab som en del af den gruppe og de bidrag, jeg har givet til virksomheden, har som f&oslash;lge heraf v&aelig;ret symbiotisk fordelagtigt. I den henseende anmoder jeg om, at De som min n&aelig;rmeste overordnede giver mig lov til at deltage.</p>
                    <p>Flere oplysninger om turen:</p>
                    <p>Trip Duration: { start_date } til { end_date }</p>
                    <p>Form&aring;let med Bes&oslash;g: { purpose_of_visit }</p>
                    <p>Plads af bes&oslash;g: { place_of_visit }</p>
                    <p>Beskrivelse: { trip_description }</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betreff: -Personalabteilung/Firma, um Reisebrief zu schicken.</p>
                    <p>Sehr geehrter {employee_trip_name},</p>
                    <p>Top of the morning to you! Ich schreibe an Ihre Dienststelle mit dem&uuml;tiger Bitte um eine Reise nach einem {purpose_of_visit} im Ausland.</p>
                    <p>Es w&auml;re das f&uuml;hrende Klima-Business-Forum des Jahres und hatte das Gl&uuml;ck, nominiert zu werden, um unser Unternehmen und die Region w&auml;hrend des Seminars zu vertreten.</p>
                    <p>Meine dreij&auml;hrige Mitgliedschaft als Teil der Gruppe und die Beitr&auml;ge, die ich an das Unternehmen gemacht habe, sind dadurch symbiotisch vorteilhaft gewesen. In diesem Zusammenhang ersuche ich Sie als meinen unmittelbaren Vorgesetzten, mir zu gestatten, zu besuchen.</p>
                    <p>Mehr Details zu Reise:</p>
                    <p>Dauer der Fahrt: {start_date} bis {end_date}</p>
                    <p>Zweck des Besuchs: {purpose_of_visit}</p>
                    <p>Ort des Besuchs: {place_of_visit}</p>
                    <p>Beschreibung: {trip_description}</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p><strong>Subject:-HR department/Company to send trip letter .</strong></p>
                    <p><strong>Dear {employee_trip_name},</strong></p>
                    <p>Top of the morning to you! I am writing to your department office with a humble request to travel for a {purpose_of_visit} abroad.</p>
                    <p>It would be the leading climate business forum of the year and have been lucky enough to be nominated to represent our company and the region during the seminar.</p>
                    <p>My three-year membership as part of the group and contributions I have made to the company, as a result, have been symbiotically beneficial. In that regard, I am requesting you as my immediate superior to permit me to attend.</p>
                    <p>More detail about trip:{start_date} to {end_date}</p>
                    <p>Trip Duration:{start_date} to {end_date}</p>
                    <p>Purpose of Visit:{purpose_of_visit}</p>
                    <p>Place of Visit:{place_of_visit}</p>
                    <p>Description:{trip_description}</p>
                    <p>Feel free to reach out if you have any questions.</p>
                    <p>Thank you</p>
                    <p><strong>Regards,</strong></p>
                    <p><strong>HR Department,</strong></p>
                    <p><strong>{app_name}</strong></p>',
                    'es' => '<p>Asunto: -Departamento de RRHH/Empresa para enviar carta de viaje.</p>
                    <p>Estimado {employee_trip_name},</p>
                    <p>&iexcl;Top de la ma&ntilde;ana para ti! Estoy escribiendo a su oficina del departamento con una humilde petici&oacute;n de viajar para un {purpose_of_visit} en el extranjero.</p>
                    <p>Ser&iacute;a el principal foro de negocios clim&aacute;ticos del a&ntilde;o y han tenido la suerte de ser nominados para representar a nuestra compa&ntilde;&iacute;a y a la regi&oacute;n durante el seminario.</p>
                    <p>Mi membres&iacute;a de tres a&ntilde;os como parte del grupo y las contribuciones que he hecho a la compa&ntilde;&iacute;a, como resultado, han sido simb&oacute;ticamente beneficiosos. En ese sentido, le estoy solicitando como mi superior inmediato que me permita asistir.</p>
                    <p>M&aacute;s detalles sobre el viaje:&nbsp;</p>
                    <p>Duraci&oacute;n del viaje: {start_date} a {end_date}</p>
                    <p>Finalidad de la visita: {purpose_of_visit}</p>
                    <p>Lugar de visita: {place_of_visit}</p>
                    <p>Descripci&oacute;n: {trip_description}</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -Service des RH / Compagnie pour envoyer une lettre de voyage.</p>
                    <p>Cher { employee_trip_name },</p>
                    <p>Top of the morning to you ! J&eacute;crai au bureau de votre minist&egrave;re avec une humble demande de voyage pour une {purpose_of_visit } &agrave; l&eacute;tranger.</p>
                    <p>Il sagit du principal forum sur le climat de lann&eacute;e et a eu la chance d&ecirc;tre d&eacute;sign&eacute; pour repr&eacute;senter notre entreprise et la r&eacute;gion au cours du s&eacute;minaire.</p>
                    <p>Mon adh&eacute;sion de trois ans au groupe et les contributions que jai faites &agrave; lentreprise, en cons&eacute;quence, ont &eacute;t&eacute; b&eacute;n&eacute;fiques sur le plan symbiotique. &Agrave; cet &eacute;gard, je vous demande d&ecirc;tre mon sup&eacute;rieur imm&eacute;diat pour me permettre dy assister.</p>
                    <p>Plus de d&eacute;tails sur le voyage:</p>
                    <p>Dur&eacute;e du voyage: { start_date } &agrave; { end_date }</p>
                    <p>Objet de la visite: { purpose_of_visit}</p>
                    <p>Lieu de visite: { place_of_visit }</p>
                    <p>Description: { trip_description }</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di viaggio.</p>
                    <p>Caro {employee_trip_name},</p>
                    <p>In cima al mattino a te! Scrivo al tuo ufficio dipartimento con umile richiesta di viaggio per un {purpose_of_visit} allestero.</p>
                    <p>Sarebbe il forum aziendale sul clima leader dellanno e sono stati abbastanza fortunati da essere nominati per rappresentare la nostra azienda e la regione durante il seminario.</p>
                    <p>La mia adesione triennale come parte del gruppo e i contributi che ho apportato allazienda, di conseguenza, sono stati simbioticamente vantaggiosi. A tal proposito, vi chiedo come mio immediato superiore per consentirmi di partecipare.</p>
                    <p>Pi&ugrave; dettagli sul viaggio:</p>
                    <p>Trip Duration: {start_date} a {end_date}</p>
                    <p>Finalit&agrave; di Visita: {purpose_of_visit}</p>
                    <p>Luogo di Visita: {place_of_visit}</p>
                    <p>Descrizione: {trip_description}</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>件名:-HR 部門/会社は出張レターを送信します。</p>
                    <p>{ employee_trip_name} に出庫します。</p>
                    <p>朝のトップだ ! 海外で {purpose_of_visit} をお願いしたいという謙虚な要求をもって、私はあなたの部署に手紙を書いています。</p>
                    <p>これは、今年の主要な気候ビジネス・フォーラムとなり、セミナーの開催中に当社と地域を代表する候補になるほど幸運にも恵まれています。</p>
                    <p>私が会社に対して行った 3 年間のメンバーシップは、その結果として、共生的に有益なものでした。 その点では、私は、私が出席することを許可することを、私の即座の上司として</p>
                    <p>トリップについての詳細 :</p>
                    <p>トリップ期間:{start_date} を {end_date} に設定します</p>
                    <p>アクセスの目的 :{purpose_of_visit}</p>
                    <p>訪問の場所 :{place_of_visit}</p>
                    <p>説明:{trip_description}</p>
                    <p>質問がある場合は、自由に連絡してください。</p>
                    <p>ありがとう</p>
                    <p>よろしく</p>
                    <p>HR 部門</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf om reisbrief te sturen.</p>
                    <p>Geachte { employee_trip_name },</p>
                    <p>Top van de ochtend aan u! Ik schrijf uw afdelingsbureau met een bescheiden verzoek om een { purpose_of_visit } in het buitenland te bezoeken.</p>
                    <p>Het zou het toonaangevende klimaatforum van het jaar zijn en hebben het geluk gehad om genomineerd te worden om ons bedrijf en de regio te vertegenwoordigen tijdens het seminar.</p>
                    <p>Mijn driejarige lidmaatschap als onderdeel van de groep en bijdragen die ik heb geleverd aan het bedrijf, als gevolg daarvan, zijn symbiotisch gunstig geweest. Wat dat betreft, verzoek ik u als mijn directe chef mij in staat te stellen aanwezig te zijn.</p>
                    <p>Meer details over reis:</p>
                    <p>Duur van reis: { start_date } tot { end_date }</p>
                    <p>Doel van bezoek: { purpose_of_visit }</p>
                    <p>Plaats van bezoek: { place_of_visit }</p>
                    <p>Beschrijving: { trip_description }</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u we</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat:-Dział HR/Firma do wysyłania listu podr&oacute;ży.</p>
                    <p>Szanowny {employee_trip_name },</p>
                    <p>Od samego rana do Ciebie! Piszę do twojego biura, z pokornym prośbą o wyjazd na {purpose_of_visit&nbsp;} za granicą.</p>
                    <p>Byłoby to wiodącym forum biznesowym w tym roku i miało szczęście być nominowane do reprezentowania naszej firmy i regionu podczas seminarium.</p>
                    <p>Moje trzyletnie członkostwo w grupie i składkach, kt&oacute;re uczyniłem w firmie, w rezultacie, były symbiotycznie korzystne. W tym względzie, zwracam się do pana o m&oacute;j bezpośredni przełożony, kt&oacute;ry pozwoli mi na udział w tej sprawie.</p>
                    <p>Więcej szczeg&oacute;ł&oacute;w na temat wyjazdu:</p>
                    <p>Czas trwania rejsu: {start_date } do {end_date }</p>
                    <p>Cel wizyty: {purpose_of_visit }</p>
                    <p>Miejsce wizyty: {place_of_visit }</p>
                    <p>Opis: {trip_description }</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания для отправки письма на поездку.</p>
                    <p>Уважаемый { employee_trip_name },</p>
                    <p>С утра до тебя! Я пишу в ваш отдел с смиренным запросом на поездку за границу.</p>
                    <p>Это был бы ведущий климатический бизнес-форум года и по везло, что в ходе семинара он будет представлять нашу компанию и регион.</p>
                    <p>Мое трехлетнее членство в составе группы и взносы, которые я внес в компанию, в результате, были симбиотически выгодны. В этой связи я прошу вас как моего непосредственного начальника разрешить мне присутствовать.</p>
                    <p>Подробнее о поездке:</p>
                    <p>Длительность поездки: { start_date } в { end_date }</p>
                    <p>Цель посещения: { purpose_of_visit }</p>
                    <p>Место посещения: { place_of_visit }</p>
                    <p>Описание: { trip_description }</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Assunto:-Departamento de RH / Empresa para enviar carta de viagem.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Querido {employee_trip_name},</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Topo da manh&atilde; para voc&ecirc;! Estou escrevendo para o seu departamento de departamento com um humilde pedido para viajar por um {purpose_of_visit} no exterior.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Seria o principal f&oacute;rum de neg&oacute;cios clim&aacute;tico do ano e teve a sorte de ser indicado para representar nossa empresa e a regi&atilde;o durante o semin&aacute;rio.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">A minha filia&ccedil;&atilde;o de tr&ecirc;s anos como parte do grupo e contribui&ccedil;&otilde;es que fiz &agrave; empresa, como resultado, foram simbioticamente ben&eacute;fico. A esse respeito, solicito que voc&ecirc; seja meu superior imediato para me permitir comparecer.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Mais detalhes sobre viagem:</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Trip Dura&ccedil;&atilde;o: {start_date} a {end_date}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Objetivo da Visita: {purpose_of_visit}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Local de Visita: {place_of_visit}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Descri&ccedil;&atilde;o: {trip_description}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Obrigado</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Considera,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Departamento de RH,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{app_name}</span></p>',
                ],
            ],
            'employee_promotion' => [
                'subject' => 'Employee Promotion',
                'lang' => [
                    'ar' => '<p>Subject : -HR القسم / الشركة لارسال رسالة تهنئة الى العمل للتهنئة بالعمل.</p>
                    <p>عزيزي { employee_promotion_name },</p>
                    <p>تهاني على ترقيتك الى { promotion_designation } { promotion_title } الفعال { promotion_date }.</p>
                    <p>وسنواصل توقع تحقيق الاتساق وتحقيق نتائج عظيمة منكم في دوركم الجديد. ونأمل أن تكون قدوة للموظفين الآخرين في المنظمة.</p>
                    <p>ونتمنى لكم التوفيق في أداءكم في المستقبل ، وتهانينا !</p>
                    <p>ومرة أخرى ، تهانئي على الموقف الجديد.</p>
                    <p>إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</p>
                    <p>شكرا لك</p>
                    <p>Regards,</p>
                    <p>إدارة الموارد البشرية ،</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Om: HR-afdelingen / Virksomheden om at sende en lyk&oslash;nskning til jobfremst&oslash;d.</p>
                    <p>K&aelig;re { employee_promotion_name },</p>
                    <p>Tillykke med din forfremmelse til { promotion_designation } { promotion_title } effektiv { promotion_date }.</p>
                    <p>Vi vil fortsat forvente konsekvens og store resultater fra Dem i Deres nye rolle. Vi h&aring;ber, at De vil foreg&aring; med et godt eksempel for de &oslash;vrige ansatte i organisationen.</p>
                    <p>Vi &oslash;nsker Dem held og lykke med Deres fremtidige optr&aelig;den, og tillykke!</p>
                    <p>Endnu en gang tillykke med den nye holdning.</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betrifft: -Personalabteilung/Unternehmen, um einen Gl&uuml;ckwunschschreiben zu senden.</p>
                    <p>Sehr geehrter {employee_promotion_name},</p>
                    <p>Herzlichen Gl&uuml;ckwunsch zu Ihrer Werbeaktion an {promotion_designation} {promotion_title} wirksam {promotion_date}.</p>
                    <p>Wir werden von Ihnen in Ihrer neuen Rolle weiterhin Konsistenz und gro&szlig;e Ergebnisse erwarten. Wir hoffen, dass Sie ein Beispiel f&uuml;r die anderen Mitarbeiter der Organisation setzen werden.</p>
                    <p>Wir w&uuml;nschen Ihnen viel Gl&uuml;ck f&uuml;r Ihre zuk&uuml;nftige Leistung, und gratulieren!</p>
                    <p>Nochmals herzlichen Gl&uuml;ckwunsch zu der neuen Position.</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p>&nbsp;</p>
                    <p><strong>Subject:-HR department/Company to send job promotion congratulation letter.</strong></p>
                    <p><strong>Dear {employee_promotion_name},</strong></p>
                    <p>Congratulations on your promotion to {promotion_designation} {promotion_title} effective {promotion_date}.</p>
                    <p>We shall continue to expect consistency and great results from you in your new role. We hope that you will set an example for the other employees of the organization.</p>
                    <p>We wish you luck for your future performance, and congratulations!.</p>
                    <p>Again, congratulations on the new position.</p>
                    <p>&nbsp;</p>
                    <p>Feel free to reach out if you have any questions.</p>
                    <p>Thank you</p>
                    <p><strong>Regards,</strong></p>
                    <p><strong>HR Department,</strong></p>
                    <p><strong>{app_name}</strong></p>',
                    'es' => '<p>Asunto: -Departamento de RRHH/Empresa para enviar carta de felicitaci&oacute;n de promoci&oacute;n de empleo.</p>
                    <p>Estimado {employee_promotion_name},</p>
                    <p>Felicidades por su promoci&oacute;n a {promotion_designation} {promotion_title} efectiva {promotion_date}.</p>
                    <p>Seguiremos esperando la coherencia y los grandes resultados de ustedes en su nuevo papel. Esperamos que usted ponga un ejemplo para los otros empleados de la organizaci&oacute;n.</p>
                    <p>Le deseamos suerte para su futuro rendimiento, y felicitaciones!.</p>
                    <p>Una vez m&aacute;s, felicidades por la nueva posici&oacute;n.</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -D&eacute;partement RH / Soci&eacute;t&eacute; denvoi dune lettre de f&eacute;licitations pour la promotion de lemploi.</p>
                    <p>Cher { employee_promotion_name },</p>
                    <p>F&eacute;licitations pour votre promotion &agrave; { promotion_d&eacute;signation } { promotion_title } effective { promotion_date }.</p>
                    <p>Nous continuerons &agrave; vous attendre &agrave; une coh&eacute;rence et &agrave; de grands r&eacute;sultats de votre part dans votre nouveau r&ocirc;le. Nous esp&eacute;rons que vous trouverez un exemple pour les autres employ&eacute;s de lorganisation.</p>
                    <p>Nous vous souhaitons bonne chance pour vos performances futures et f&eacute;licitations !</p>
                    <p>Encore une fois, f&eacute;licitations pour le nouveau poste.</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare la lettera di congratulazioni alla promozione del lavoro.</p>
                    <p>Caro {employee_promotion_name},</p>
                    <p>Complimenti per la tua promozione a {promotion_designation} {promotion_title} efficace {promotion_date}.</p>
                    <p>Continueremo ad aspettarci coerenza e grandi risultati da te nel tuo nuovo ruolo. Ci auguriamo di impostare un esempio per gli altri dipendenti dellorganizzazione.</p>
                    <p>Ti auguriamo fortuna per le tue prestazioni future, e complimenti!.</p>
                    <p>Ancora, complimenti per la nuova posizione.</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>件名:-HR 部門/企業は、求人広告の祝賀状を送信します。</p>
                    <p>{ employee_promotion_name} に出庫します。</p>
                    <p>{promotion_designation } { promotion_title} {promotion_date} 販促に対するお祝いのお祝いがあります。</p>
                    <p>今後とも、お客様の新しい役割において一貫性と大きな成果を期待します。 組織の他の従業員の例を設定したいと考えています。</p>
                    <p>あなたの未来のパフォーマンスをお祈りします。おめでとうございます。</p>
                    <p>また、新しい地位について祝意を表する。</p>
                    <p>質問がある場合は、自由に連絡してください。</p>
                    <p>ありがとう</p>
                    <p>よろしく</p>
                    <p>HR 部門</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf voor het versturen van de aanbevelingsbrief voor taakpromotie.</p>
                    <p>Geachte { employee_promotion_name },</p>
                    <p>Gefeliciteerd met uw promotie voor { promotion_designation } { promotion_title } effective { promotion_date }.</p>
                    <p>Wij zullen de consistentie en de grote resultaten van u in uw nieuwe rol blijven verwachten. Wij hopen dat u een voorbeeld zult stellen voor de andere medewerkers van de organisatie.</p>
                    <p>Wij wensen u geluk voor uw toekomstige prestaties, en gefeliciteerd!.</p>
                    <p>Nogmaals, gefeliciteerd met de nieuwe positie.</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat: -Dział kadr/Firma w celu wysłania listu gratulacyjnego dla promocji zatrudnienia.</p>
                    <p>Szanowny {employee_promotion_name },</p>
                    <p>Gratulacje dla awansowania do {promotion_designation } {promotion_title } efektywnej {promotion_date }.</p>
                    <p>W dalszym ciągu oczekujemy konsekwencji i wspaniałych wynik&oacute;w w Twojej nowej roli. Mamy nadzieję, że postawicie na przykład dla pozostałych pracownik&oacute;w organizacji.</p>
                    <p>Życzymy powodzenia dla przyszłych wynik&oacute;w, gratulujemy!.</p>
                    <p>Jeszcze raz gratulacje na nowej pozycji.</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания для отправки письма с поздравлением.</p>
                    <p>Уважаемый { employee_promotion_name },</p>
                    <p>Поздравляем вас с продвижением в { promotion_designation } { promotion_title } эффективная { promotion_date }.</p>
                    <p>Мы будем и впредь ожидать от вас соответствия и больших результатов в вашей новой роли. Мы надеемся, что вы станете примером для других сотрудников организации.</p>
                    <p>Желаем вам удачи и поздравлений!</p>
                    <p>Еще раз поздравляю с новой позицией.</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p style="font-size: 14.4px;">Assunto:-Departamento de RH / Empresa para enviar carta de felicita&ccedil;&atilde;o de promo&ccedil;&atilde;o de emprego.</p>
                    <p style="font-size: 14.4px;">Querido {employee_promotion_name},</p>
                    <p style="font-size: 14.4px;">Parab&eacute;ns pela sua promo&ccedil;&atilde;o para {promotion_designation} {promotion_title} efetivo {promotion_date}.</p>
                    <p style="font-size: 14.4px;">Continuaremos a esperar consist&ecirc;ncia e grandes resultados a partir de voc&ecirc; em seu novo papel. Esperamos que voc&ecirc; defina um exemplo para os demais funcion&aacute;rios da organiza&ccedil;&atilde;o.</p>
                    <p style="font-size: 14.4px;">Desejamos sorte para o seu desempenho futuro, e parab&eacute;ns!.</p>
                    <p style="font-size: 14.4px;">Novamente, parab&eacute;ns pela nova posi&ccedil;&atilde;o.</p>
                    <p style="font-size: 14.4px;">Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</p>
                    <p style="font-size: 14.4px;">Obrigado</p>
                    <p style="font-size: 14.4px;">Considera,</p>
                    <p style="font-size: 14.4px;">Departamento de RH,</p>
                    <p style="font-size: 14.4px;">{app_name}</p>',
                ],
            ],
            'employee_complaints' => [
                'subject' => 'Employee Complaints',
                'lang' => [
                    'ar' => '<p>Subject :-قسم الموارد البشرية / الشركة لإرسال رسالة شكوى.</p>
                    <p>عزيزي { employee_complaints_name },</p>
                    <p>وأود أن أبلغ عن صراعا بينكم وبين الشخص الآخر. فقد وقعت عدة حوادث خلال الأيام القليلة الماضية ، وأشعر أن الوقت قد حان لتقديم شكوى رسمية ضده / لها.</p>
                    <p>إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</p>
                    <p>شكرا لك</p>
                    <p>Regards,</p>
                    <p>إدارة الموارد البشرية ،</p>
                    <p>{ app_name }</p>',
                    'da' => '<p>Om: HR-departementet / Kompagniet for at sende klager.</p>
                    <p>K&aelig;re { employee_complaints_name },</p>
                    <p>Jeg vil gerne anmelde en konflikt mellem Dem og den anden person, og der er sket flere episoder i de seneste dage, og jeg mener, at det er p&aring; tide at anmelde en formel klage over for ham.</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betrifft: -Personalabteilung/Unternehmen zum Senden von Beschwerden.</p>
                    <p>Sehr geehrter {employee_complaints_name},</p>
                    <p>Ich m&ouml;chte einen Konflikt zwischen Ihnen und der anderen Person melden. Es hat in den letzten Tagen mehrere Zwischenf&auml;lle gegeben, und ich glaube, es ist an der Zeit, eine formelle Beschwerde gegen ihn zu erstatten.</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p><strong>Subject:-HR department/Company to send complaints letter.</strong></p>
                    <p><strong>Dear {employee_complaints_name},</strong></p>
                    <p>I would like to report a conflict between you and the other person.There have been several incidents over the last few days, and I feel that it is time to report a formal complaint against him/her.</p>
                    <p>&nbsp;</p>
                    <p>Feel free to reach out if you have any questions.</p>
                    <p>Thank you</p>
                    <p><strong>Regards,</strong></p>
                    <p><strong>HR Department,</strong></p>
                    <p><strong>{app_name}</strong></p>',
                    'es' => '<p>Asunto: -Departamento de RRHH/Empresa para enviar carta de quejas.</p>
                    <p>Estimado {employee_complaints_name},</p>
                    <p>Me gustar&iacute;a informar de un conflicto entre usted y la otra persona. Ha habido varios incidentes en los &uacute;ltimos d&iacute;as, y creo que es hora de denunciar una queja formal contra &eacute;l.</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -Service des ressources humaines / Compagnie pour envoyer une lettre de plainte.</p>
                    <p>Cher { employee_complaints_name },</p>
                    <p>Je voudrais signaler un conflit entre vous et lautre personne. Il y a eu plusieurs incidents au cours des derniers jours, et je pense quil est temps de signaler une plainte officielle contre lui.</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di reclamo.</p>
                    <p>Caro {employee_complaints_name},</p>
                    <p>Vorrei segnalare un conflitto tra lei e laltra persona Ci sono stati diversi incidenti negli ultimi giorni, e sento che &egrave; il momento di denunciare una denuncia formale contro di lui.</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>件名:-HR 部門/会社は、クレーム・レターを送信します。</p>
                    <p>{ employee_complaints_name} の Dear&nbsp;</p>
                    <p>あなたと他の人との間の葛藤を報告したいと思いますこの数日間でいくつかの事件が発生しています彼女に対する正式な申し立てをする時だと感じています</p>
                    <p>質問がある場合は、自由に連絡してください。</p>
                    <p>ありがとう</p>
                    <p>よろしく</p>
                    <p>HR 部門</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf voor het verzenden van klachtenbrief.</p>
                    <p>Geachte { employee_complaints_name},</p>
                    <p>Ik zou een conflict willen melden tussen u en de andere persoon. Er zijn de afgelopen dagen verschillende incidenten geweest en ik denk dat het tijd is om een formele klacht tegen hem/haar in te dienen.</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat:-Dział HR/Firma do wysyłania listu reklamowego.</p>
                    <p>Szanowna {employee_complaints_name },</p>
                    <p>Chciałbym zgłosić konflikt między tobą a drugą osobą. W ciągu ostatnich kilku dni było kilka incydent&oacute;w i czuję, że nadszedł czas, aby zgłosić oficjalną skargę przeciwko niej.</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания отправить письмо с жалобами.</p>
                    <p>Уважаемый { employee_complaints_name }</p>
                    <p>Я хотел бы сообщить о конфликте между вами и другим человеком. За последние несколько дней произошло несколько инцидентов, и я считаю, что пришло время сообщить о своей официальной жалобе.</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p>Assunto:-Departamento de RH / Empresa para enviar carta de reclama&ccedil;&otilde;es.</p>
                    <p>Querido {employee_complaints_name},</p>
                    <p>Eu gostaria de relatar um conflito entre voc&ecirc; e a outra pessoa. Houve v&aacute;rios incidentes ao longo dos &uacute;ltimos dias, e eu sinto que &eacute; hora de relatar uma den&uacute;ncia formal contra him/her.</p>
                    <p>Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</p>
                    <p>Obrigado</p>
                    <p>Considera,</p>
                    <p>Departamento de RH,</p>
                    <p>{app_name}</p>',
                ],
            ],
            'employee_warning' => [
                'subject' => 'Employee Warning',
                'lang' => [
                    'ar' => '<p style="text-align: left;"><span style="font-size: 12pt;"><span style="color: #222222;"><span style="white-space: pre-wrap;">Subject : -HR ادارة / شركة لارسال رسالة تحذير. عزيزي { employe_warning_name }, { warning_subject } { warning_description } إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة. شكرا لك Regards, إدارة الموارد البشرية ، { app_name }</span></span></span></p>',
                    'da' => '<p>Om: HR-afdelingen / kompagniet for at sende advarselsbrev.</p>
                    <p>K&aelig;re { employee_warning_name },</p>
                    <p>{ warning_subject }</p>
                    <p>{ warning_description }</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betreff: -Personalabteilung/Unternehmen zum Senden von Warnschreiben.</p>
                    <p>Sehr geehrter {employee_warning_name},</p>
                    <p>{warning_subject}</p>
                    <p>{warning_description}</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p><strong>Subject:-HR department/Company to send warning letter.</strong></p>
                    <p><strong>Dear {employee_warning_name},</strong></p>
                    <p>{warning_subject}</p>
                    <p>{warning_description}</p>
                    <p>Feel free to reach out if you have any questions.</p>
                    <p>Thank you</p>
                    <p><strong>Regards,</strong></p>
                    <p><strong>HR Department,</strong></p>
                    <p><strong>{app_name}</strong></p>',
                    'es' => '<p>Asunto: -Departamento de RR.HH./Empresa para enviar carta de advertencia.</p>
                    <p>Estimado {employee_warning_name},</p>
                    <p>{warning_subject}</p>
                    <p>{warning_description}</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -HR department / Company to send warning letter.</p>
                    <p>Cher { employee_warning_name },</p>
                    <p>{ warning_subject }</p>
                    <p>{ warning_description }</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di avvertimento.</p>
                    <p>Caro {employee_warning_name},</p>
                    <p>{warning_subject}</p>
                    <p>{warning_description}</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p><span style="font-size: 12pt;"><span style="color: #222222;"><span style="white-space: pre-wrap;">件名:-HR 部門/企業は警告レターを送信します。 { employee_warning_name} を出庫します。 {warning_subject} {warning_description} 質問がある場合は、自由に連絡してください。 ありがとう よろしく HR 部門 {app_name}</span></span></span></p>',
                    'nl' => '<p>Betreft: -HR-afdeling/bedrijf om een waarschuwingsbrief te sturen.</p>
                    <p>Geachte { employee_warning_name },</p>
                    <p>{ warning_subject }</p>
                    <p>{ warning_description }</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat: -Dział HR/Firma do wysyłania listu ostrzegawczego.</p>
                    <p>Szanowny {employee_warning_name },</p>
                    <p>{warning_subject }</p>
                    <p>{warning_description }</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания для отправки предупреждающего письма.</p>
                    <p>Уважаемый { employee_warning_name },</p>
                    <p>{ warning_subject }</p>
                    <p>{ warning_description }</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Assunto:-Departamento de RH / Empresa para enviar carta de advert&ecirc;ncia.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Querido {employee_warning_name},</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{warning_subject}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{warning_description}</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Obrigado</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Considera,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">Departamento de RH,</span></p>
                    <p style="font-size: 14.4px;"><span style="font-size: 14.4px;">{app_name}</span></p>',
                ],
            ],
            'employee_termination' => [
                'subject' => 'Employee Termination',
                'lang' => [
                    'ar' => '<p style="text-align: left;"><span style="font-size: 12pt;"><span style="color: #222222;"><span style="white-space: pre-wrap;"><span style="font-size: 12pt; white-space: pre-wrap;">Subject :-ادارة / شركة HR لارسال رسالة انهاء. عزيزي { </span><span style="white-space: pre-wrap;">employee_termination_name</span><span style="font-size: 12pt; white-space: pre-wrap;"> } ، هذه الرسالة مكتوبة لإعلامك بأن عملك مع شركتنا قد تم إنهاؤه مزيد من التفاصيل عن الانهاء : تاريخ الاشعار : { </span><span style="white-space: pre-wrap;">notice_date</span><span style="font-size: 12pt; white-space: pre-wrap;"> } تاريخ الانهاء : { </span><span style="white-space: pre-wrap;">termination_date</span><span style="font-size: 12pt; white-space: pre-wrap;"> } نوع الانهاء : { termination_type } إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة. شكرا لك Regards, إدارة الموارد البشرية ، { app_name }</span></span></span></span></p>',
                    'da' => '<p>Emne:-HR-afdelingen / Virksomheden om at sende afslutningstskrivelse.</p>
                    <p>K&aelig;re { employee_termination_name },</p>
                    <p>Dette brev er skrevet for at meddele dig, at dit arbejde med vores virksomhed er afsluttet.</p>
                    <p>Flere oplysninger om oph&aelig;velse:</p>
                    <p>Adviseringsdato: { notifice_date }</p>
                    <p>Opsigelsesdato: { termination_date }</p>
                    <p>Opsigelsestype: { termination_type }</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betreff: -Personalabteilung/Firma zum Versenden von K&uuml;ndigungsschreiben.</p>
                    <p>Sehr geehrter {employee_termination_name},</p>
                    <p>Dieser Brief wird Ihnen schriftlich mitgeteilt, dass Ihre Besch&auml;ftigung mit unserem Unternehmen beendet ist.</p>
                    <p>Weitere Details zur K&uuml;ndigung:</p>
                    <p>K&uuml;ndigungsdatum: {notice_date}</p>
                    <p>Beendigungsdatum: {termination_date}</p>
                    <p>Abbruchstyp: {termination_type}</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p><strong>Subject:-HR department/Company to send termination letter.</strong></p>
                    <p><strong>Dear {employee_termination_name},</strong></p>
                    <p>This letter is written to notify you that your employment with our company is terminated.</p>
                    <p>More detail about termination:</p>
                    <p>Notice Date :{notice_date}</p>
                    <p>Termination Date:{termination_date}</p>
                    <p>Termination Type:{termination_type}</p>
                    <p>&nbsp;</p>
                    <p>Feel free to reach out if you have any questions.</p>
                    <p>Thank you</p>
                    <p><strong>Regards,</strong></p>
                    <p><strong>HR Department,</strong></p>
                    <p><strong>{app_name}</strong></p>',
                    'es' => '<p>Asunto: -Departamento de RRHH/Empresa para enviar carta de rescisi&oacute;n.</p>
                    <p>Estimado {employee_termination_name},</p>
                    <p>Esta carta est&aacute; escrita para notificarle que su empleo con nuestra empresa ha terminado.</p>
                    <p>M&aacute;s detalles sobre la terminaci&oacute;n:</p>
                    <p>Fecha de aviso: {notice_date}</p>
                    <p>Fecha de terminaci&oacute;n: {termination_date}</p>
                    <p>Tipo de terminaci&oacute;n: {termination_type}</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -HR department / Company to send termination letter.</p>
                    <p>Cher { employee_termination_name },</p>
                    <p>Cette lettre est r&eacute;dig&eacute;e pour vous aviser que votre emploi aupr&egrave;s de notre entreprise prend fin.</p>
                    <p>Plus de d&eacute;tails sur larr&ecirc;t:</p>
                    <p>Date de lavis: { notice_date }</p>
                    <p>Date de fin: { termination_date}</p>
                    <p>Type de terminaison: { termination_type }</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di terminazione.</p>
                    <p>Caro {employee_termination_name},</p>
                    <p>Questa lettera &egrave; scritta per comunicarti che la tua occupazione con la nostra azienda &egrave; terminata.</p>
                    <p>Pi&ugrave; dettagli sulla cessazione:</p>
                    <p>Data avviso: {notice_data}</p>
                    <p>Data di chiusura: {termination_date}</p>
                    <p>Tipo di terminazione: {termination_type}</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>件名:-HR 部門/企業は終了文字を送信します。</p>
                    <p>{ employee_termination_name} を終了します。</p>
                    <p>この手紙は、当社の雇用が終了していることをあなたに通知するために書かれています。</p>
                    <p>終了についての詳細 :</p>
                    <p>通知日 :{notice_date}</p>
                    <p>終了日:{termination_date}</p>
                    <p>終了タイプ:{termination_type}</p>
                    <p>質問がある場合は、自由に連絡してください。</p>
                    <p>ありがとう</p>
                    <p>よろしく</p>
                    <p>HR 部門</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf voor verzending van afgiftebrief.</p>
                    <p>Geachte { employee_termination_name },</p>
                    <p>Deze brief is geschreven om u te melden dat uw werk met ons bedrijf wordt be&euml;indigd.</p>
                    <p>Meer details over be&euml;indiging:</p>
                    <p>Datum kennisgeving: { notice_date }</p>
                    <p>Be&euml;indigingsdatum: { termination_date }</p>
                    <p>Be&euml;indigingstype: { termination_type }</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat: -Dział kadr/Firma do wysyłania listu zakańczego.</p>
                    <p>Droga {employee_termination_name },</p>
                    <p>Ten list jest napisany, aby poinformować Cię, że Twoje zatrudnienie z naszą firmą zostaje zakończone.</p>
                    <p>Więcej szczeg&oacute;ł&oacute;w na temat zakończenia pracy:</p>
                    <p>Data ogłoszenia: {notice_date }</p>
                    <p>Data zakończenia: {termination_date }</p>
                    <p>Typ zakończenia: {termination_type }</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания отправить письмо о прекращении.</p>
                    <p>Уважаемый { employee_termination_name },</p>
                    <p>Это письмо написано, чтобы уведомить вас о том, что ваше трудоустройство с нашей компанией прекратилось.</p>
                    <p>Более подробная информация о завершении:</p>
                    <p>Дата уведомления: { notice_date }</p>
                    <p>Дата завершения: { termination_date }</p>
                    <p>Тип завершения: { termination_type }</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p style="font-size: 14.4px;">Assunto:-Departamento de RH / Empresa para enviar carta de rescis&atilde;o.</p>
                    <p style="font-size: 14.4px;">Querido {employee_termination_name},</p>
                    <p style="font-size: 14.4px;">Esta carta &eacute; escrita para notific&aacute;-lo de que seu emprego com a nossa empresa est&aacute; finalizado.</p>
                    <p style="font-size: 14.4px;">Mais detalhes sobre a finaliza&ccedil;&atilde;o:</p>
                    <p style="font-size: 14.4px;">Data de Aviso: {notice_date}</p>
                    <p style="font-size: 14.4px;">Data de Finaliza&ccedil;&atilde;o: {termination_date}</p>
                    <p style="font-size: 14.4px;">Tipo de Rescis&atilde;o: {termination_type}</p>
                    <p style="font-size: 14.4px;">Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</p>
                    <p style="font-size: 14.4px;">Obrigado</p>
                    <p style="font-size: 14.4px;">Considera,</p>
                    <p style="font-size: 14.4px;">Departamento de RH,</p>
                    <p style="font-size: 14.4px;">{app_name}</p>',
                ],
            ],
            'leave_status' => [
                'subject' => 'Leave Statu',
                'lang' => [
                    'ar' => '<p style="text-align: left;">Subject : -HR ادارة / شركة لارسال رسالة الموافقة الى { leave_status } اجازة أو ترك.</p>
                    <p style="text-align: left;">عزيزي { leave_status_name } ،</p>
                    <p style="text-align: left;">لدي { leave_status } طلب الخروج الخاص بك الى { leave_reason } من { leave_start_date } الى { leave_end_date }.</p>
                    <p style="text-align: left;">{ total_leave_days } أيام لدي { leave_status } طلب الخروج الخاص بك ل ـ { leave_reason }.</p>
                    <p style="text-align: left;">ونحن نطلب منكم أن تكملوا كل أعمالكم المعلقة أو أي قضية مهمة أخرى حتى لا تواجه الشركة أي خسارة أو مشكلة أثناء غيابكم. نحن نقدر لك مصداقيتك لإبلاغنا بوقت كاف مقدما</p>
                    <p style="text-align: left;">إشعر بالحرية للوصول إلى الخارج إذا عندك أي أسئلة.</p>
                    <p style="text-align: left;">شكرا لك</p>
                    <p style="text-align: left;">Regards,</p>
                    <p style="text-align: left;">إدارة الموارد البشرية ،</p>
                    <p style="text-align: left;">{ app_name }</p>',
                    'da' => '<p>Emne:-HR-afdelingen / Kompagniet for at sende godkendelsesbrev til { leave_status } en ferie eller orlov.</p>
                    <p>K&aelig;re { leave_status_name },</p>
                    <p>Jeg har { leave_status } din orlov-anmodning for { leave_reason } fra { leave_start_date } til { leave_end_date }.</p>
                    <p>{ total_leave_days } dage Jeg har { leave_status } din anmodning om { leave_reason } for { leave_reason }.</p>
                    <p>Vi beder dig om at f&aelig;rdigg&oslash;re alt dit udest&aring;ende arbejde eller andet vigtigt sp&oslash;rgsm&aring;l, s&aring; virksomheden ikke st&aring;r over for nogen tab eller problemer under dit frav&aelig;r. Vi s&aelig;tter pris p&aring; din bet&aelig;nksomhed at informere os godt p&aring; forh&aring;nd</p>
                    <p>Du er velkommen til at r&aelig;kke ud, hvis du har nogen sp&oslash;rgsm&aring;l.</p>
                    <p>Tak.</p>
                    <p>Med venlig hilsen</p>
                    <p>HR-afdelingen,</p>
                    <p>{ app_name }</p>',
                    'de' => '<p>Betreff: -Personalabteilung/Firma, um den Genehmigungsschreiben an {leave_status} einen Urlaub oder Urlaub zu schicken.</p>
                    <p>Sehr geehrter {leave_status_name},</p>
                    <p>Ich habe {leave_status} Ihre Urlaubsanforderung f&uuml;r {leave_reason} von {leave_start_date} bis {leave_end_date}.</p>
                    <p>{total_leave_days} Tage Ich habe {leave_status} Ihre Urlaubs-Anfrage f&uuml;r {leave_reason}.</p>
                    <p>Wir bitten Sie, Ihre gesamte anstehende Arbeit oder ein anderes wichtiges Thema abzuschlie&szlig;en, so dass das Unternehmen w&auml;hrend Ihrer Abwesenheit keinen Verlust oder kein Problem zu Gesicht bekommen hat. Wir sch&auml;tzen Ihre Nachdenklichkeit, um uns im Vorfeld gut zu informieren</p>
                    <p>F&uuml;hlen Sie sich frei, wenn Sie Fragen haben.</p>
                    <p>Danke.</p>
                    <p>Betrachtet,</p>
                    <p>Personalabteilung,</p>
                    <p>{app_name}</p>',
                    'en' => '<p><strong>Subject:-HR department/Company to send approval letter to {leave_status} a vacation or leave.</strong></p>
                    <p><strong>Dear {leave_status_name},</strong></p>
                    <p>I have {leave_status} your leave request for {leave_reason} from {leave_start_date} to {leave_end_date}.</p>
                    <p>{total_leave_days} days I have {leave_status}&nbsp; your leave request for {leave_reason}.</p>
                    <p>We request you to complete all your pending work or any other important issue so that the company does not face any loss or problem during your absence. We appreciate your thoughtfulness to inform us well in advance</p>
                    <p>&nbsp;</p>
                    <p>Feel free to reach out if you have any questions.</p>
                    <p>Thank you</p>
                    <p><strong>Regards,</strong></p>
                    <p><strong>HR Department,</strong></p>
                    <p><strong>{app_name}</strong></p>',
                    'es' => '<p>Asunto: -Departamento de RR.HH./Empresa para enviar la carta de aprobaci&oacute;n a {leave_status} unas vacaciones o permisos.</p>
                    <p>Estimado {leave_status_name},</p>
                    <p>Tengo {leave_status} la solicitud de licencia para {leave_reason} de {leave_start_date} a {leave_end_date}.</p>
                    <p>{total_leave_days} d&iacute;as tengo {leave_status} la solicitud de licencia para {leave_reason}.</p>
                    <p>Le solicitamos que complete todos sus trabajos pendientes o cualquier otro asunto importante para que la empresa no se enfrente a ninguna p&eacute;rdida o problema durante su ausencia. Agradecemos su atenci&oacute;n para informarnos con mucha antelaci&oacute;n</p>
                    <p>Si&eacute;ntase libre de llegar si usted tiene alguna pregunta.</p>
                    <p>&iexcl;Gracias!</p>
                    <p>Considerando,</p>
                    <p>Departamento de Recursos Humanos,</p>
                    <p>{app_name}</p>',
                    'fr' => '<p>Objet: -HR department / Company to send approval letter to { leave_status } a vacances or leave.</p>
                    <p>Cher { leave_status_name },</p>
                    <p>Jai { leave_statut } votre demande de cong&eacute; pour { leave_reason } de { leave_start_date } &agrave; { leave_date_fin }.</p>
                    <p>{ total_leave_days } jours I have { leave_status } your leave request for { leave_reason }.</p>
                    <p>Nous vous demandons de remplir tous vos travaux en cours ou toute autre question importante afin que lentreprise ne soit pas confront&eacute;e &agrave; une perte ou &agrave; un probl&egrave;me pendant votre absence. Nous appr&eacute;cions votre attention pour nous informer longtemps &agrave; lavance</p>
                    <p>Nh&eacute;sitez pas &agrave; nous contacter si vous avez des questions.</p>
                    <p>Je vous remercie</p>
                    <p>Regards,</p>
                    <p>D&eacute;partement des RH,</p>
                    <p>{ app_name }</p>',
                    'it' => '<p>Oggetto: - Dipartimento HR / Societ&agrave; per inviare lettera di approvazione a {leave_status} una vacanza o un congedo.</p>
                    <p>Caro {leave_status_name},</p>
                    <p>Ho {leave_status} la tua richiesta di permesso per {leave_reason} da {leave_start_date} a {leave_end_date}.</p>
                    <p>{total_leave_days} giorni I ho {leave_status} la tua richiesta di permesso per {leave_reason}.</p>
                    <p>Ti richiediamo di completare tutte le tue lavorazioni in sospeso o qualsiasi altra questione importante in modo che lazienda non faccia alcuna perdita o problema durante la tua assenza. Apprezziamo la vostra premura per informarci bene in anticipo</p>
                    <p>Sentiti libero di raggiungere se hai domande.</p>
                    <p>Grazie</p>
                    <p>Riguardo,</p>
                    <p>Dipartimento HR,</p>
                    <p>{app_name}</p>',
                    'ja' => '<p>件名: 承認レターを { leave_status} に送信するには、 -HR 部門/会社が休暇または休暇を入力します。</p>
                    <p>{leave_status_name} を終了します。</p>
                    <p>{ leave_reason } の { leave_start_date} から {leave_end_date}までの { leave_status} の終了要求を { leave_status} しています。</p>
                    <p>{total_leave_days} 日に { leave_reason}{ leave_status} に対するあなたの休暇要求があります。</p>
                    <p>お客様は、お客様の不在中に損失や問題が発生しないように、保留中のすべての作業またはその他の重要な問題を完了するよう要求します。 私たちは、前もってお知らせすることに感謝しています。</p>
                    <p>質問がある場合は、自由に連絡してください。</p>
                    <p>ありがとう</p>
                    <p>よろしく</p>
                    <p>HR 部門</p>
                    <p>{app_name}</p>',
                    'nl' => '<p>Betreft: -HR-afdeling/Bedrijf voor het verzenden van een goedkeuringsbrief aan { leave_status } een vakantie of verlof.</p>
                    <p>Geachte { leave_status_name },</p>
                    <p>Ik heb { leave_status } uw verzoek om verlof voor { leave_reason } van { leave_start_date } tot { leave_end_date }.</p>
                    <p>{ total_leave_days } dagen Ik heb { leave_status } uw verzoek om verlof voor { leave_reason }.</p>
                    <p>Wij vragen u om al uw lopende werk of een andere belangrijke kwestie, zodat het bedrijf geen verlies of probleem tijdens uw afwezigheid geconfronteerd. We waarderen uw bedachtzaamheid om ons van tevoren goed te informeren.</p>
                    <p>Voel je vrij om uit te reiken als je vragen hebt.</p>
                    <p>Dank u wel</p>
                    <p>Betreft:</p>
                    <p>HR-afdeling,</p>
                    <p>{ app_name }</p>',
                    'pl' => '<p>Temat: -Dział kadr/Firma wysyłająca list zatwierdzający do {leave_status } wakacji lub urlop&oacute;w.</p>
                    <p>Drogi {leave_status_name },</p>
                    <p>Mam {leave_status } żądanie pozostania dla {leave_reason } od {leave_start_date } do {leave_end_date }.</p>
                    <p>{total_leave_days } dni Mam {leave_status } Twoje żądanie opuszczenia dla {leave_reason }.</p>
                    <p>Prosimy o wypełnienie wszystkich oczekujących prac lub innych ważnych kwestii, tak aby firma nie borykała się z żadną stratą lub problemem w czasie Twojej nieobecności. Doceniamy Twoją przemyślność, aby poinformować nas dobrze z wyprzedzeniem</p>
                    <p>Czuj się swobodnie, jeśli masz jakieś pytania.</p>
                    <p>Dziękujemy</p>
                    <p>W odniesieniu do</p>
                    <p>Dział HR,</p>
                    <p>{app_name }</p>',
                    'ru' => '<p>Тема: -HR отдел/Компания отправить письмо с утверждением на { leave_status } отпуск или отпуск.</p>
                    <p>Уважаемый { leave_status_name },</p>
                    <p>У меня { leave_status } ваш запрос на отпуск для { leave_reason } из { leave_start_date } в { leave_end_date }.</p>
                    <p>{ total_leave_days } дней { leave_status } ваш запрос на отпуск для { leave_reason }.</p>
                    <p>Мы просим вас завершить все ваши ожидающие работы или любой другой важный вопрос, чтобы компания не сталкивалась с потерей или проблемой во время вашего отсутствия. Мы ценим вашу задумчивость, чтобы заблаговременно информировать нас о</p>
                    <p>Не стеснитесь, если у вас есть вопросы.</p>
                    <p>Спасибо.</p>
                    <p>С уважением,</p>
                    <p>Отдел кадров,</p>
                    <p>{ app_name }</p>',
                    'pt' => '<p style="font-size: 14.4px;">Assunto:-Departamento de RH / Empresa para enviar carta de aprova&ccedil;&atilde;o para {leave_status} f&eacute;rias ou licen&ccedil;a.</p>
                    <p style="font-size: 14.4px;">Querido {leave_status_name},</p>
                    <p style="font-size: 14.4px;">Eu tenho {leave_status} sua solicita&ccedil;&atilde;o de licen&ccedil;a para {leave_reason} de {leave_start_date} para {leave_end_date}.</p>
                    <p style="font-size: 14.4px;">{total_leave_days} dias eu tenho {leave_status} o seu pedido de licen&ccedil;a para {leave_reason}.</p>
                    <p style="font-size: 14.4px;">Solicitamos que voc&ecirc; complete todo o seu trabalho pendente ou qualquer outra quest&atilde;o importante para que a empresa n&atilde;o enfrente qualquer perda ou problema durante a sua aus&ecirc;ncia. Agradecemos a sua atenciosidade para nos informar com bastante anteced&ecirc;ncia</p>
                    <p style="font-size: 14.4px;">Sinta-se &agrave; vontade para alcan&ccedil;ar fora se voc&ecirc; tiver alguma d&uacute;vida.</p>
                    <p style="font-size: 14.4px;">Obrigado</p>
                    <p style="font-size: 14.4px;">Considera,</p>
                    <p style="font-size: 14.4px;">Departamento de RH,</p>
                    <p style="font-size: 14.4px;">{app_name}</p>',
                ],
            ],
            'contract' => [
                'subject' => 'Contract',
                'lang' => [
                    'ar' => '<p><span style="font-family: sans-serif;"><strong>مرحبا </strong>{ contract_employee } </span></p>
                    <p><span style="font-family: sans-serif;"><strong><strong>العقد :</strong> </strong>{ contract_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>تاريخ البدء</strong>: { contract_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>تاريخ الانتهاء</strong>: { contract_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">اتطلع للسمع منك. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Regards Regards ، </span></strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'da' => '<p><span style="font-family: sans-serif;"><strong>Hej </strong>{ contract_employee } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Aftaleemne:</strong> { contract_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart-dato</strong>: { contract_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Slutdato</strong>: { contract_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">Ser frem til at høre fra dig. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kærlig hilsen </span></strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'de' => '<p><span style="font-family: sans-serif;"><strong><strong> </strong></strong>{contract_employee} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Vertragssubjekt:</strong> {contract_subject} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>tart-Datum</strong>: {contract_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>: </strong>{contract_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Freuen Sie sich auf die von Ihnen zu h&ouml;renden Informationen. </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">-Regards, </span></span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'en' => '<p><span style="font-family: sans-serif;"><strong>Hi </strong>{contract_employee} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Contract Subject:</strong> {contract_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: {contract_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>End Date</strong>: {contract_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Looking forward to hear from you. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kind Regards, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'es' => '<p><span style="font-family: sans-serif;"><strong><strong>Hi </strong></strong>{contract_employee} </span></p>
                    <p><span style="font-family: sans-serif;"><strong><strong>de contrato:</strong> </strong>{contract_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">S</span></span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: {contract_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Fecha de finalizaci&oacute;n</strong>: {contract_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Con ganas de escuchar de usted. </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">Regards de tipo, </span></span></strong></p>
                    <p><span style="font-family: sans-serif;">{contract_name}</span></p>',
                    'fr' => '<p><span style="font-family: sans-serif;"><strong><strong> </strong></strong>{ contract_employee } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Objet du contrat:</strong> { contract_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>Date de d&eacute;but</strong>: { contract_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Date de fin</strong>: { contract_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">Vous avez h&acirc;te de vous entendre. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kind Regards </span> </strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'it' => '<p><span style="font-family: sans-serif;"><strong>Ciao </strong>{contract_employee} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Oggetto Contratto:</strong> {contract_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>Data tarte</strong>: {contract_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Data di fine</strong>: {contract_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Non vedo lora di sentire da te. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kind indipendentemente, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'ja' => '<p><span style="font-family: sans-serif;"><span style="font-family: sans-serif;"><strong>ハイ </strong>{contract_employee} </span></span></p>
                    <p><span style="font-family: sans-serif;"><strong>契約件名:</strong> {契約対象} </span></p>
                    <p><strong><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: </span></strong><span style="font-family: sans-serif;">{contract_start_date}</span><span style="font-family: sans-serif;"> </span></p>
                    <p><span style="font-family: sans-serif;"><strong>終了日</strong>: {contract_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">お客様から連絡をお待ちしています。 </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">クインド・レード </span></span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'nl' => '<p><span style="font-family: sans-serif;"><strong>Hi </strong>{ contract_employee } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Contractonderwerp:</strong> { contract_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: { contract_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Einddatum</strong>: { contract_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">Ik kijk ernaar uit om van u te horen. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Soort Regards, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'pl' => '<p><span style="font-family: sans-serif;"><strong>Hi </strong>{contract_employee}</span></p>
                    <p><span style="font-family: sans-serif;"><strong>Temat umowy:</strong> {contract_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">S</span></span></strong><span style="font-family: sans-serif;"><strong>data tartu</strong>: {contract_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Data zakończenia</strong>: {contract_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Nie można się doczekać, aby usłyszeć od użytkownika. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Regaty typu, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'ru' => '<p><span style="font-family: sans-serif;"><strong>Привет </strong>{ contract_employee } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Тема договора:</strong> { contract_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>дата запуска</strong>: { contract_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Дата окончания</strong>: { contract_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">С нетерпением ожидаю услышать от вас. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Карты вида, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'pt' => '<p><span style="font-family: sans-serif;"><strong>Oi </strong>{contract_employee} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Assunto do Contrato:</strong> {contract_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: {contract_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Data de término</strong>: {contract_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Olhando para a frente para ouvir de você. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kind Considerar, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                ],
            ],
        ];

        $email = EmailTemplate::all();

        foreach($email as $e)
        {

            foreach($defaultTemplate[$e->slug]['lang'] as $lang => $content)
            {
                EmailTemplateLang::create(
                    [
                        'parent_id' => $e->id,
                        'lang' => $lang,
                        'subject' => $defaultTemplate[$e->slug]['subject'],
                        'content' => $content,
                    ]
                );
            }
        }
    }
    public function currentLanguage()
    {
        return $this->lang;
    }

    public function creatorId()
    {

        if($this->type == 'company' || $this->type == 'super admin')
        {
            return $this->id;
        }
        else
        {
            return $this->created_by;
        }
    }


    public function employeeIdFormat($number)
    {
        $settings = Utility::settings();

        return $settings["employee_prefix"] . sprintf("%05d", $number);
    }

    public function getBranch($branch_id)
    {
        $branch = Branch::where('id', '=', $branch_id)->first();

        return $branch;
    }

    public function getLeaveType($leave_type)
    {
        $leavetype = LeaveType::where('id', '=', $leave_type)->first();

        return $leavetype;
    }

    public function getEmployee($employee)
    {
        $employee = Employee::where('id', '=', $employee)->first();

        return $employee;
    }

    public function getDepartment($department_id)
    {
        $department = Department::where('id', '=', $department_id)->first();

        return $department;
    }

    public function getDesignation($designation_id)
    {
        $designation = Designation::where('id', '=', $designation_id)->first();

        return $designation;
    }

    public function getUser($user)
    {
        $user = User::where('id', '=', $user)->first();

        return $user;
    }

    public function userEmployee()
    {

        $userEmployee = User::select('id')->where('created_by', '=', Auth::user()->creatorId())->where('type', '=', 'employee')->get();

        return $userEmployee;
    }

    public function getUSerEmployee($id)
    {
        $employee = Employee::where('user_id', '=', $id)->first();

        return $employee;
    }

    public function priceFormat($price)
    {
        $settings = Utility::settings();

        return (($settings['site_currency_symbol_position'] == "pre") ? $settings['site_currency_symbol'] : '') . number_format($price, 2) . (($settings['site_currency_symbol_position'] == "post") ? $settings['site_currency_symbol'] : '');
    }

    public function currencySymbol()
    {
        $settings = Utility::settings();

        return $settings['site_currency_symbol'];
    }

    public function dateFormat($date)
    {
        $settings = Utility::settings();

        return date($settings['site_date_format'], strtotime($date));
    }

    public function timeFormat($time)
    {
        $settings = Utility::settings();

        return date($settings['site_time_format'], strtotime($time));
    }

    public function getPlan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan');
    }

    public function assignPlan($planID)
    {
        $plan = Plan::find($planID);
        if($plan)
        {
            $this->plan = $plan->id;
            if($plan->duration == 'month')
            {
                $this->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            }
            elseif($plan->duration == 'year')
            {
                $this->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            }
            else
            {
                $this->plan_expire_date = null;
            }
            $this->save();

            $users     = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'super admin')->where('type', '!=', 'company')->where('type', '!=', 'employee')->get();
            $employees = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', 'employee')->get();

            if($plan->max_users == -1)
            {
                foreach($users as $user)
                {
                    $user->is_active = 1;
                    $user->save();
                }
            }
            else
            {
                $userCount = 0;
                foreach($users as $user)
                {
                    $userCount++;
                    if($userCount <= $plan->max_users)
                    {
                        $user->is_active = 1;
                        $user->save();
                    }
                    else
                    {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }

            if($plan->max_employees == -1)
            {
                foreach($employees as $employee)
                {
                    $employee->is_active = 1;
                    $employee->save();
                }
            }
            else
            {

                $employeeCount = 0;
                foreach($employees as $employee)
                {
                    $employeeCount++;
                    if($employeeCount <= $plan->max_employees)
                    {
                        $employee->is_active = 1;
                        $employee->save();
                    }
                    else
                    {
                        $employee->is_active = 0;
                        $employee->save();
                    }
                }
            }

            return ['is_success' => true];
        }
        else
        {
            return [
                'is_success' => false,
                'error' => 'Plan is deleted.',
            ];
        }
    }

    public function countUsers()
    {
        return User::where('type', '!=', 'super admin')->where('type', '!=', 'company')->where('type', '!=', 'employee')->where('created_by', '=', $this->creatorId())->count();
    }

    public function countEmployees()
    {
        return Employee::where('created_by', '=', $this->creatorId())->count();
    }

    public function countCompany()
    {
        return User::where('type', '=', 'company')->where('created_by', '=', $this->creatorId())->count();
    }

    public function countOrder()
    {
        return Order::count();
    }

    public function countplan()
    {
        return Plan::count();
    }
    
    public function contractNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["contract_prefix"] . sprintf("%05d", $number);
    }
    
    public function countPaidCompany()
    {
        return User::where('type', '=', 'company')->whereNotIn(
            'plan', [
                      0,
                      1,
                  ]
        )->where('created_by', '=', \Auth::user()->id)->count();
    }

    public function planPrice()
    {
        $user = \Auth::user();
        if($user->type == 'super admin')
        {
            $userId = $user->id;
        }
        else
        {
            $userId = $user->created_by;
        }

        return \DB::table('settings')->where('created_by', '=', $userId)->get()->pluck('value', 'name');

    }

    public function currentPlan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan');
    }


    public function unread()
    {
        return Message::where('from', '=', $this->id)->where('is_read', '=', 0)->count();
    }

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'user_id', 'id');
    }
    public static function userDefaultData()
    {
        
        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();
        foreach($allEmail as $email)
        {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => 1,
                    'is_active' => 1,
                ]
            );
        }
    }

    public function userDefaultDataRegister($user_id)
    {

        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();
        foreach($allEmail as $email)
        {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => $user_id,
                    'is_active' => 1,
                ]
            );
        }
    }
    
}