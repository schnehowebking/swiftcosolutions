<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NOC extends Model
{
    protected $table = 'noc_certificates';
    protected $fillable = [
        'id',
        'lang',
        'content',
        'created_by',
    ];



    public static function replaceVariable($content, $obj)
    {
        $arrVariable = [
            '{date}',
            '{employee_name}',
            '{designation}',
            '{app_name}',
      
        ];
        $arrValue    = [
            'date' => '-',
            'employee_name' => '-',
            'designation' => '-',
            'app_name' => '-',
        ];

        foreach($obj as $key => $val)
        {
            $arrValue[$key] = $val;
        }
        $settings = Utility::settings();
       
        //   dd(env('APP_NAME'));
        $arrValue['app_name']     = env('APP_NAME');
       
       
        return str_replace($arrVariable, array_values($arrValue), $content);
    }
    public static function defaultNocCertificate()
    {
       

        $defaultTemplate = [
              
            'ar' => '<h3 style="text-align: center;">شهادة عدم ممانعة</h3>
            
            
            
            <p>التاريخ: {date}</p>
            
            
            
            <p>إلى من يهمه الأمر</p>
            
            
            
            <p>هذه الشهادة مخصصة للمطالبة بشهادة عدم ممانعة (NoC) للسيدة / السيد {employee_name} إذا انضمت إلى أي مؤسسة أخرى وقدمت خدماتها / خدماتها. يتم إبلاغه لأنه قام بتصفية جميع أرصدته واستلام أمانه من شركة {app_name}.</p>
            
            
            
            <p>نتمنى لها / لها التوفيق في المستقبل.</p>
            
            
            
            <p>بإخلاص،</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>التوقيع</p>
            
            <p>{app_name}</p>',

            
            'da' => '<h3 style="text-align: center;">Ingen indsigelsesattest</h3>
            
            
            
            <p>Dato: {date}</p>
            
            
            
            <p>Til hvem det m&aring;tte vedr&oslash;re</p>
            
            
            
            <p>Dette certifikat er for at g&oslash;re krav p&aring; et No Objection Certificate (NoC) for Ms. / Mr. {employee_name}, hvis hun/han tilslutter sig og leverer sine tjenester til enhver anden organisation. Det informeres, da hun/han har udlignet alle sine saldi og modtaget sin sikkerhed fra {app_name}-virksomheden.</p>
            
            
            
            <p>Vi &oslash;nsker hende/ham held og lykke i fremtiden.</p>
            
            
            
            <p>Med venlig hilsen</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Underskrift</p>
            
            <p>{app_name}</p>',
            'de' => '<h3 style="text-align: center;">Kein Einwand-Zertifikat</h3>
            
            
            
            <p>Datum {date}</p>
            
            
            
            <p>Wen auch immer es betrifft</p>
            
            
            
            <p>Dieses Zertifikat soll ein Unbedenklichkeitszertifikat (NoC) f&uuml;r Frau / Herrn {employee_name} beanspruchen, wenn sie/er einer anderen Organisation beitritt und ihre/seine Dienste anbietet. Sie wird informiert, da sie/er alle ihre/seine Guthaben ausgeglichen und ihre/seine Sicherheit von der Firma {app_name} erhalten hat.</p>
            
            
            
            <p>Wir w&uuml;nschen ihr/ihm viel Gl&uuml;ck f&uuml;r die Zukunft.</p>
            
            
            
            <p>Aufrichtig,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Unterschrift</p>
            
            <p>{app_name}</p>',
            'en' => '<p style="text-align: center;"><span style="font-size: 18pt;"><strong>No Objection Certificate</strong></span></p>
            
            <p>Date: {date}</p>
            
            <p>To Whomsoever It May Concern</p>
            
            <p>This certificate is to claim a No Objection Certificate (NoC) for Ms. / Mr. {employee_name} if she/he joins and provides her/his services to any other organization. It is informed as she/he has cleared all her/his balances and received her/his security from {app_name} Company.</p>
            
            <p>We wish her/him good luck in the future.</p>
            
            <p>Sincerely,</p>
            <p>{employee_name}</p>
            <p>{designation}</p>
            <p>Signature</p>
            <p>{app_name}</p>',
            'es' => '<h3 style="text-align: center;">Certificado de conformidad</h3>
            
            
            
            <p>Fecha: {date}</p>
            
            
            
            <p>A quien corresponda</p>
            
            
            
            <p>Este certificado es para reclamar un Certificado de No Objeci&oacute;n (NoC) para la Sra. / Sr. {employee_name} si ella / &eacute;l se une y brinda sus servicios a cualquier otra organizaci&oacute;n. Se informa que &eacute;l/ella ha liquidado todos sus saldos y recibido su seguridad de {app_name} Company.</p>
            
            
            
            <p>Le deseamos buena suerte en el futuro.</p>
            
            
            
            <p>Sinceramente,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Firma</p>
            
            <p>{app_name}</p>',
            'fr' => '<h3 style="text-align: center;">Aucun certificat dopposition</h3>
            
            
            <p>Date : {date}</p>
            
            
            <p>&Agrave; toute personne concern&eacute;e</p>
            
            
            <p>Ce certificat sert &agrave; r&eacute;clamer un certificat de non-objection (NoC) pour Mme / M. {employee_name} sil rejoint et fournit ses services &agrave; toute autre organisation. Il est inform&eacute; quil a sold&eacute; tous ses soldes et re&ccedil;u sa garantie de la part de la soci&eacute;t&eacute; {app_name}.</p>
            
            
            <p>Nous lui souhaitons bonne chance pour lavenir.</p>
            
            
            <p>Sinc&egrave;rement,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Signature</p>
            
            <p>{app_name}</p>',
            'id' => '<h3 style="text-align: center;">Sertifikat Tidak Keberatan</h3>
            
            
            
            <p>Tanggal: {date}</p>
            
            
            
            <p>Kepada Siapa Pun Yang Memprihatinkan</p>
            
            
            
            <p>Sertifikat ini untuk mengklaim No Objection Certificate (NoC) untuk Ibu / Bapak {employee_name} jika dia bergabung dan memberikan layanannya ke organisasi lain mana pun. Diberitahukan karena dia telah melunasi semua saldonya dan menerima jaminannya dari Perusahaan {app_name}.</p>
            
            
            
            <p>Kami berharap dia sukses di masa depan.</p>
            
            
            
            <p>Sungguh-sungguh,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Tanda tangan</p>
            
            <p>{app_name}</p>',
            'it' => '<h3 style="text-align: center;">Certificato di nulla osta</h3>
            
            
            
            <p>Data: {date}</p>
            
            
            
            <p>A chi pu&ograve; interessare</p>
            
            
            
            <p>Questo certificato serve a richiedere un certificato di non obiezione (NoC) per la signora / il signor {employee_name} se si unisce e fornisce i suoi servizi a qualsiasi altra organizzazione. Viene informato in quanto ha liquidato tutti i suoi saldi e ricevuto la sua sicurezza dalla societ&agrave; {app_name}.</p>
            
            
            
            <p>Le auguriamo buona fortuna per il futuro.</p>
            
            
            
            <p>Cordiali saluti,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Firma</p>
            
            <p>{app_name}</p>',
            'ja' => '<h3 style="text-align: center;">異議なし証明書</h3>
            
            
            
            <p>日付: {date}</p>
            
            
            
            <p>関係者各位</p>
            
            
            
            <p>この証明書は、Ms. / Mr. {employee_name} が他の組織に参加してサービスを提供する場合に、異議なし証明書 (NoC) を請求するためのものです。彼女/彼/彼がすべての残高を清算し、{app_name} 会社から彼女/彼のセキュリティを受け取ったことが通知されます。</p>
            
            
            
            <p>彼女/彼の今後の幸運を祈っています。</p>
            
            
            
            <p>心から、</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>サイン</p>
            
            <p>{app_name}</p>',
            'nl' => '<h3 style="text-align: center;">Geen bezwaarcertificaat</h3>
            
            
            
            <p>Datum: {date}</p>
            
            
            
            <p>Aan wie het ook aangaat</p>
            
            
            
            <p>Dit certificaat is bedoeld om aanspraak te maken op een Geen Bezwaarcertificaat (NoC) voor mevrouw/dhr. {employee_name} als zij/hij lid wordt en haar/zijn diensten verleent aan een andere organisatie. Het wordt ge&iuml;nformeerd als zij/hij al haar/zijn saldos heeft gewist en haar/zijn zekerheid heeft ontvangen van {app_name} Company.</p>
            
            
            
            <p>We wensen haar/hem veel succes in de toekomst.</p>
            
            
            
            <p>Eerlijk,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Handtekening</p>
            
            <p>{app_name}</p>',
            'pl' => '<h3 style="text-align: center;">Certyfikat braku sprzeciwu</h3>
            
            
            
            <p>Data: {date}</p>
            
            
            
            <p>Do kogo to może dotyczyć</p>
            
            
            
            <p>Ten certyfikat służy do ubiegania się o Certyfikat No Objection Certificate (NoC) dla Pani/Pana {employee_name}, jeśli ona/ona dołącza i świadczy swoje usługi na rzecz jakiejkolwiek innej organizacji. Jest o tym informowany, ponieważ wyczyścił wszystkie swoje salda i otrzymał swoje zabezpieczenie od firmy {app_name}.</p>
            
            
            
            <p>Życzymy jej/jej powodzenia w przyszłości.</p>
            
            
            
            <p>Z poważaniem,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Podpis</p>
            
            <p>{app_name}</p>',
            'pt' => '<h3 style="text-align: center;">Certificado de n&atilde;o obje&ccedil;&atilde;o</h3>
            
            
            
            <p>Data: {date}</p>
            
            
            
            <p>A quem interessar</p>
            
            
            
            <p>Este certificado &eacute; para reivindicar um Certificado de N&atilde;o Obje&ccedil;&atilde;o (NoC) para a Sra. / Sr. {employee_name} se ela ingressar e fornecer seus servi&ccedil;os a qualquer outra organiza&ccedil;&atilde;o. &Eacute; informado que ela cancelou todos os seus saldos e recebeu sua garantia da empresa {app_name}.</p>
            
            
            
            <p>Desejamos-lhe boa sorte no futuro.</p>
            
            
            
            <p>Sinceramente,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Assinatura</p>
            
            <p>{app_name}</p>',
            'ru' => '<h3 style="text-align: center;">Сертификат об отсутствии возражений</h3>
            
            
            
            <p>Дата: {date}</p>
            
            
            
            <p>Кого бы это ни касалось</p>
            
            
            
            <p>Этот сертификат предназначен для получения Сертификата об отсутствии возражений (NoC) для г-жи / г-на {employee_name}, если она / он присоединяется и предоставляет свои услуги любой другой организации. Сообщается, что она/он очистила все свои балансы и получила свою безопасность от компании {app_name}.</p>
            
            
            
            <p>Мы желаем ей/ему удачи в будущем.</p>
            
            
            
            <p>Искренне,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Подпись</p>
            
            <p>{app_name}</p>',
      
       ];

        
        foreach($defaultTemplate as $lang => $content)
        {
            NOC::create(
                [
                    'lang' => $lang,
                    'content' => $content,
                    'created_by' => 1,
                
                ]
            );
        }
        
    }
    public static function defaultNocCertificateRegister($user_id)
    {
       

        $defaultTemplate = [
              
            'ar' => '<h3 style="text-align: center;">شهادة عدم ممانعة</h3>
            
            
            
            <p>التاريخ: {date}</p>
            
            
            
            <p>إلى من يهمه الأمر</p>
            
            
            
            <p>هذه الشهادة مخصصة للمطالبة بشهادة عدم ممانعة (NoC) للسيدة / السيد {employee_name} إذا انضمت إلى أي مؤسسة أخرى وقدمت خدماتها / خدماتها. يتم إبلاغه لأنه قام بتصفية جميع أرصدته واستلام أمانه من شركة {app_name}.</p>
            
            
            
            <p>نتمنى لها / لها التوفيق في المستقبل.</p>
            
            
            
            <p>بإخلاص،</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>التوقيع</p>
            
            <p>{app_name}</p>',

            
            'da' => '<h3 style="text-align: center;">Ingen indsigelsesattest</h3>
            
            
            
            <p>Dato: {date}</p>
            
            
            
            <p>Til hvem det m&aring;tte vedr&oslash;re</p>
            
            
            
            <p>Dette certifikat er for at g&oslash;re krav p&aring; et No Objection Certificate (NoC) for Ms. / Mr. {employee_name}, hvis hun/han tilslutter sig og leverer sine tjenester til enhver anden organisation. Det informeres, da hun/han har udlignet alle sine saldi og modtaget sin sikkerhed fra {app_name}-virksomheden.</p>
            
            
            
            <p>Vi &oslash;nsker hende/ham held og lykke i fremtiden.</p>
            
            
            
            <p>Med venlig hilsen</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Underskrift</p>
            
            <p>{app_name}</p>',
            'de' => '<h3 style="text-align: center;">Kein Einwand-Zertifikat</h3>
            
            
            
            <p>Datum {date}</p>
            
            
            
            <p>Wen auch immer es betrifft</p>
            
            
            
            <p>Dieses Zertifikat soll ein Unbedenklichkeitszertifikat (NoC) f&uuml;r Frau / Herrn {employee_name} beanspruchen, wenn sie/er einer anderen Organisation beitritt und ihre/seine Dienste anbietet. Sie wird informiert, da sie/er alle ihre/seine Guthaben ausgeglichen und ihre/seine Sicherheit von der Firma {app_name} erhalten hat.</p>
            
            
            
            <p>Wir w&uuml;nschen ihr/ihm viel Gl&uuml;ck f&uuml;r die Zukunft.</p>
            
            
            
            <p>Aufrichtig,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Unterschrift</p>
            
            <p>{app_name}</p>',
            'en' => '<p style="text-align: center;"><span style="font-size: 18pt;"><strong>No Objection Certificate</strong></span></p>
            
            <p>Date: {date}</p>
            
            <p>To Whomsoever It May Concern</p>
            
            <p>This certificate is to claim a No Objection Certificate (NoC) for Ms. / Mr. {employee_name} if she/he joins and provides her/his services to any other organization. It is informed as she/he has cleared all her/his balances and received her/his security from {app_name} Company.</p>
            
            <p>We wish her/him good luck in the future.</p>
            
            <p>Sincerely,</p>
            <p>{employee_name}</p>
            <p>{designation}</p>
            <p>Signature</p>
            <p>{app_name}</p>',
            'es' => '<h3 style="text-align: center;">Certificado de conformidad</h3>
            
            
            
            <p>Fecha: {date}</p>
            
            
            
            <p>A quien corresponda</p>
            
            
            
            <p>Este certificado es para reclamar un Certificado de No Objeci&oacute;n (NoC) para la Sra. / Sr. {employee_name} si ella / &eacute;l se une y brinda sus servicios a cualquier otra organizaci&oacute;n. Se informa que &eacute;l/ella ha liquidado todos sus saldos y recibido su seguridad de {app_name} Company.</p>
            
            
            
            <p>Le deseamos buena suerte en el futuro.</p>
            
            
            
            <p>Sinceramente,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Firma</p>
            
            <p>{app_name}</p>',
            'fr' => '<h3 style="text-align: center;">Aucun certificat dopposition</h3>
            
            
            <p>Date : {date}</p>
            
            
            <p>&Agrave; toute personne concern&eacute;e</p>
            
            
            <p>Ce certificat sert &agrave; r&eacute;clamer un certificat de non-objection (NoC) pour Mme / M. {employee_name} sil rejoint et fournit ses services &agrave; toute autre organisation. Il est inform&eacute; quil a sold&eacute; tous ses soldes et re&ccedil;u sa garantie de la part de la soci&eacute;t&eacute; {app_name}.</p>
            
            
            <p>Nous lui souhaitons bonne chance pour lavenir.</p>
            
            
            <p>Sinc&egrave;rement,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Signature</p>
            
            <p>{app_name}</p>',
            'id' => '<h3 style="text-align: center;">Sertifikat Tidak Keberatan</h3>
            
            
            
            <p>Tanggal: {date}</p>
            
            
            
            <p>Kepada Siapa Pun Yang Memprihatinkan</p>
            
            
            
            <p>Sertifikat ini untuk mengklaim No Objection Certificate (NoC) untuk Ibu / Bapak {employee_name} jika dia bergabung dan memberikan layanannya ke organisasi lain mana pun. Diberitahukan karena dia telah melunasi semua saldonya dan menerima jaminannya dari Perusahaan {app_name}.</p>
            
            
            
            <p>Kami berharap dia sukses di masa depan.</p>
            
            
            
            <p>Sungguh-sungguh,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Tanda tangan</p>
            
            <p>{app_name}</p>',
            'it' => '<h3 style="text-align: center;">Certificato di nulla osta</h3>
            
            
            
            <p>Data: {date}</p>
            
            
            
            <p>A chi pu&ograve; interessare</p>
            
            
            
            <p>Questo certificato serve a richiedere un certificato di non obiezione (NoC) per la signora / il signor {employee_name} se si unisce e fornisce i suoi servizi a qualsiasi altra organizzazione. Viene informato in quanto ha liquidato tutti i suoi saldi e ricevuto la sua sicurezza dalla societ&agrave; {app_name}.</p>
            
            
            
            <p>Le auguriamo buona fortuna per il futuro.</p>
            
            
            
            <p>Cordiali saluti,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Firma</p>
            
            <p>{app_name}</p>',
            'ja' => '<h3 style="text-align: center;">異議なし証明書</h3>
            
            
            
            <p>日付: {date}</p>
            
            
            
            <p>関係者各位</p>
            
            
            
            <p>この証明書は、Ms. / Mr. {employee_name} が他の組織に参加してサービスを提供する場合に、異議なし証明書 (NoC) を請求するためのものです。彼女/彼/彼がすべての残高を清算し、{app_name} 会社から彼女/彼のセキュリティを受け取ったことが通知されます。</p>
            
            
            
            <p>彼女/彼の今後の幸運を祈っています。</p>
            
            
            
            <p>心から、</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>サイン</p>
            
            <p>{app_name}</p>',
            'nl' => '<h3 style="text-align: center;">Geen bezwaarcertificaat</h3>
            
            
            
            <p>Datum: {date}</p>
            
            
            
            <p>Aan wie het ook aangaat</p>
            
            
            
            <p>Dit certificaat is bedoeld om aanspraak te maken op een Geen Bezwaarcertificaat (NoC) voor mevrouw/dhr. {employee_name} als zij/hij lid wordt en haar/zijn diensten verleent aan een andere organisatie. Het wordt ge&iuml;nformeerd als zij/hij al haar/zijn saldos heeft gewist en haar/zijn zekerheid heeft ontvangen van {app_name} Company.</p>
            
            
            
            <p>We wensen haar/hem veel succes in de toekomst.</p>
            
            
            
            <p>Eerlijk,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Handtekening</p>
            
            <p>{app_name}</p>',
            'pl' => '<h3 style="text-align: center;">Certyfikat braku sprzeciwu</h3>
            
            
            
            <p>Data: {date}</p>
            
            
            
            <p>Do kogo to może dotyczyć</p>
            
            
            
            <p>Ten certyfikat służy do ubiegania się o Certyfikat No Objection Certificate (NoC) dla Pani/Pana {employee_name}, jeśli ona/ona dołącza i świadczy swoje usługi na rzecz jakiejkolwiek innej organizacji. Jest o tym informowany, ponieważ wyczyścił wszystkie swoje salda i otrzymał swoje zabezpieczenie od firmy {app_name}.</p>
            
            
            
            <p>Życzymy jej/jej powodzenia w przyszłości.</p>
            
            
            
            <p>Z poważaniem,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Podpis</p>
            
            <p>{app_name}</p>',
            'pt' => '<h3 style="text-align: center;">Certificado de n&atilde;o obje&ccedil;&atilde;o</h3>
            
            
            
            <p>Data: {date}</p>
            
            
            
            <p>A quem interessar</p>
            
            
            
            <p>Este certificado &eacute; para reivindicar um Certificado de N&atilde;o Obje&ccedil;&atilde;o (NoC) para a Sra. / Sr. {employee_name} se ela ingressar e fornecer seus servi&ccedil;os a qualquer outra organiza&ccedil;&atilde;o. &Eacute; informado que ela cancelou todos os seus saldos e recebeu sua garantia da empresa {app_name}.</p>
            
            
            
            <p>Desejamos-lhe boa sorte no futuro.</p>
            
            
            
            <p>Sinceramente,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Assinatura</p>
            
            <p>{app_name}</p>',
            'ru' => '<h3 style="text-align: center;">Сертификат об отсутствии возражений</h3>
            
            
            
            <p>Дата: {date}</p>
            
            
            
            <p>Кого бы это ни касалось</p>
            
            
            
            <p>Этот сертификат предназначен для получения Сертификата об отсутствии возражений (NoC) для г-жи / г-на {employee_name}, если она / он присоединяется и предоставляет свои услуги любой другой организации. Сообщается, что она/он очистила все свои балансы и получила свою безопасность от компании {app_name}.</p>
            
            
            
            <p>Мы желаем ей/ему удачи в будущем.</p>
            
            
            
            <p>Искренне,</p>
            
            <p>{employee_name}</p>
            
            <p>{designation}</p>
            
            <p>Подпись</p>
            
            <p>{app_name}</p>',
      
       ];

        
        foreach($defaultTemplate as $lang => $content)
        {
            NOC::create(
                [
                    'lang' => $lang,
                    'content' => $content,
                    'created_by' => $user_id,
                
                ]
            );
        }
        
    }
}
