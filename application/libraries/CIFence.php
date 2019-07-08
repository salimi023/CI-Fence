<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*    
 * Copyright (c) <2019> <Imre Sallér>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * CI-Fence Library
 *
 * Multilingual non-image security (CAPTCHA + honeypot) library for CodeIgniter.
 *
 * @package		CodeIgniter
 * @subpackage  Libraries
 * @category    Security
 * @author		Imre Sallér
 * @link        https://github.com/salimi023/  
 * @license     https://opensource.org/licenses/MIT
 */

class CIFence {

    public $placeholder = null; // Placeholder text of the CAPTCHA input field set by the language configuration 
    public $passed = null;      // Boolean type variable enabling/disabling the submission code in the controller (result of the CAPTCHA/honeypot check)
    public $passMsg = null;     // Confirmation message in case of positive CAPTCHA/honeypot checking result (optional)
    public $failMsg = null;     // Failure alert in case of negative CAPTCHA/honeypot checking result
    private $_config = [];      // Configuration settings 
    private $_language = [];    // Language data           

    public function __construct() {                

        /**
         * HTML ISO Language Code of the selected language (https://www.w3schools.com/tags/ref_language_codes.asp)
         * 
         * IMPORTANT: In case of providing a language code please use only the short form of it. 
         * (e.g `en` stands for all English dialects and do not use `en-US`) 
         *  
         * In the lack of the language code the lib tries  to obtain the primary language of the userclient 
         * and use the relating language code if it is added to the `language` array.
         * In case of missing config language code and/or language array data the default language is English.   
         */

        $this->_config = [   
            'language' => ''            
        ];
        
        /** Language datasets
         *  The array can be shortened or expanded according to the requirements. Any languages can be added.
         * 
         *  IMPORTANT: Please note, that the NAMES OF THE DAYS both in native and English languages must be added in LOWERCASE format.    
         */
    
        $this->_language = [
            'ar' => [ // Arabic
                'placeholder' => 'ما اليوم هو اليوم؟',
                'alert' => 'يرجى تقديم الإجابة الصحيحة',
                'confirm' => 'الإجابة الصحيحة',
                'الإثنين' => 'monday',
                'الثلاثاء' => 'tuesday',
                'الأربعاء' => 'wednesday',
                'الخميس' => 'thursday',
                'الجمعة' => 'friday',
                'السبت' => 'saturday',
                'الأحد' => 'sunday'
            ],

            'de' => [ // German
                'placeholder' => 'Welcher Tag ist heute?',
                'alert' => 'Bitte geben Sie die richtige Antwort!',
                'confirm' => 'Richtige Antwort!',
                'montag' => 'monday',
                'dienstag' => 'tuesday',
                'mittwoch' => 'wednesday',
                'donnerstag' => 'thursday',
                'freitag' => 'friday',
                'samstag' => 'saturday',
                'sonntag' => 'sunday'
            ],

            'el' => [ // Greek
                'placeholder' => 'Τι μέρα είναι σήμερα;',
                'alert' => 'Παρακαλώ δώστε τη σωστή απάντηση!',
                'confirm' => 'Σωστή απάντηση!',
                'δευτέρα' => 'monday',
                'tρίτη' => 'tuesday',
                'τετάρτη' => 'wednesday',
                'πέμπτη' => 'thursday',
                'παρασκευή' => 'friday',
                'σάββατο' => 'saturday',
                'kυριακή' => 'sunday'
            ],

            'en' => [ // English
                'placeholder' => 'What day is it today?',
                'alert' => 'Please provide the correct answer!',
                'confirm' => 'Correct answer!',
                'monday' => 'monday',
                'tuesday' => 'tuesday',
                'wednesday' => 'wednesday',
                'thursday' => 'thursday',
                'friday' => 'friday',
                'saturday' => 'saturday',
                'sunday' =>  'sunday' 
            ],

            'es' => [ // Spanish
                'placeholder' => 'Que dia es hoy',
                'alert' => 'Por favor, proporcione la respuesta correcta!',
                'confirm' => 'Respuesta correcta!',
                'lunes' => 'monday',
                'martes' => 'tuesday',
                'miércoles' => 'wednesday',
                'jueves' => 'thursday',
                'viernes' => 'friday',
                'sábado' => 'saturday',
                'domingo' => 'sunday'
            ],

            'fr' => [ // French
                'placeholder' => 'Quel jour sommes-nous aujourd\'hui?',
                'alert' => 'S\'il vous plaît fournir la bonne réponse!',
                'confirm' => 'Bonne réponse!',
                'lundi' => 'monday',
                'mardi' => 'tuesday',
                'mercredi' => 'wednesday',
                'jeudi' => 'thursday',
                'vendredi' => 'friday',
                'samedi' => 'saturday',
                'dimanche' => 'sunday'
            ],

            'he' => [ // Hebrew
                'placeholder' => 'איזה יום היום',
                'alert' => 'נא לספק את התשובה הנכונה',
                'confirm' => 'תשובה נכונה',
                'יום שני' => 'monday',
                'יום שלישי' => 'tuesday',
                'יום רביעי' => 'wednesday',
                'יום חמישי' => 'thursday',
                'יום שישי' => 'friday',
                'יום שבת' => 'saturday',
                'יום ראשון' => 'sunday'
            ],

            'hi' => [ // Hindi
                'placeholder' => 'आज कौन सा दिन है?',
                'alert' => 'कृपया सही उत्तर दें!',
                'confirm' => 'सही उत्तर!',
                'सोमवार' => 'monday',
                'मंगलवार' => 'tuesday',
                'बुधवार' => 'wednesday',
                'बृहस्पतिवार' => 'thursday',
                'शुक्रवार' => 'friday',
                'शनिवार' => 'saturday',
                'रविवार' => 'sunday'                
            ],

            'hu' => [ // Hungarian
                'placeholder' => 'Milyen nap van ma?',
                'alert' => 'Kérem, adja meg a helyes választ!',
                'confirm' => 'Rendben!',
                'hétfő' => 'monday',
                'kedd' => 'tuesday',
                'szerda' => 'wednesday',
                'csütörtök' => 'thursday',
                'péntek' => 'friday',
                'szombat' => 'saturday',
                'vasárnap' =>  'sunday'
            ],

            'it' => [ // Italian
                'placeholder' => 'Che giorno è oggi?',
                'alert' => 'Si prega di fornire la risposta corretta!',
                'confirm' => 'Risposta corretta!',
                'lunedi' => 'monday',
                'martedì' => 'tuesday',
                'mercoledì' => 'wednesday',
                'giovedi' => 'thursday',
                'venerdì' => 'friday',
                'sabato' => 'saturday',
                'domenica' => 'sunday'
            ],

            'ja' => [ // Japanese
                'placeholder' => '今日は何日ですか？',
                'alert' => '正しい答えを入力してください。',
                'confirm' => '正解!',
                '月曜日' => 'monday',
                '火曜日' => 'tuesday',
                '水曜日' => 'wednesday',
                '木曜日' => 'thursday',
                '金曜日' => 'friday',
                '土曜日' => 'saturday',
                '日曜日' => 'sunday'
            ],

            'ko' => [ // Korean
                'placeholder' => '오늘은 오늘 무엇입니까?',
                'alert' => '정답을 입력하십시오!',
                'confirm' => '정답!',
                '월요일' => 'monday',
                '화요일' => 'tuesday',
                '수요일' => 'wednesday',
                '목요일' => 'thursday',
                '금요일' => 'friday',
                '토요일' => 'saturday',
                '일요일' => 'sunday'
            ],

            'pl' => [ // Polish
                'placeholder' => 'Jaki jest dzisiaj dzień?',
                'alert' => 'Podaj poprawną odpowiedź!',
                'confirm' => 'Prawidłowa odpowiedź!',
                'poniedziałek' => 'monday',
                'wtorek' => 'tuesday',
                'środa' => 'wednesday',
                'czwartek' => 'thursday',
                'piątek' => 'friday',
                'sobota' => 'saturday',
                'niedziela' => 'sunday'
            ],

            'pt' => [ // Portugese
                'placeholder' => 'Que dia é hoje?',
                'alert' => 'Por favor, forneça a resposta correta!',
                'confirm' => 'Resposta correta!',
                'segunda-feira' => 'monday',
                'terça-feira' => 'tuesday',
                'quarta-feira' => 'wednesday',
                'quinta-feira' => 'thursday',
                'sexta-feira' => 'friday',
                'sábado' => 'saturday',
                'domingo' => 'sunday'
            ],

            'ru' => [ // Russian
                'placeholder' => 'Какой сегодня день?',
                'alert' => 'Пожалуйста, предоставьте правильный ответ!',
                'confirm' => 'Правильный ответ!',
                'понедельник' => 'monday',
                'вторник' => 'tuesday',
                'среда' => 'wednesday',
                'четверг' => 'thursday',
                'пятница' => 'friday',
                'суббота' => 'saturday',
                'воскресенье' => 'sunday'
            ],

            'tr' => [ // Turkish
                'placeholder' => 'Bugün günlerden ne?',
                'alert' => 'Lütfen doğru cevabı veriniz!',
                'confirm' => 'Doğru cevap!',
                'pazartesi' => 'monday',
                'salı' => 'tuesday',
                'çarşamba' => 'wednesday',
                'perşembe' => 'thursday',
                'cuma' => 'friday',
                'cumartesi' => 'saturday',
                'pazar' => 'sunday'
            ],

            'uk' => [ // Ukrainian
                'placeholder' => 'Який день сьогодні?',
                'alert' => 'Надайте правильну відповідь!',
                'confirm' => 'Правильна відповідь!',
                'понеділок' => 'monday',
                'вівторок' => 'tuesday',
                'середа' => 'wednesday',
                'четвер' => 'thursday',
                'п\'ятниця' => 'friday',
                'субота' => 'saturday',
                'неділя' => 'sunday'
            ],

            'zh' => [ // Chinese
                'placeholder' => '今天是星期几？',
                'alert' => '请提供正确答案！',
                'confirm' => '正确答案！',
                '星期一' => 'monday',
                '星期二' => 'tuesday',
                '星期三' => 'wednesday',
                '星期四' => 'thursday',
                '星期五' => 'friday',
                '星期六' => 'saturday',
                '星期天' => 'sunday'
            ]
        ];

        /**
         * Setting of userclient or default language (EN) if the language code is not provided in the configuration.
         */
        if(empty($this->_config['language'])) {
            $this->_config['language'] = array_key_exists(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), $this->_language) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en'; 
        } 
        
        /**
         * Setting of CAPTCHA input field placeholder and message texts.
         */
        $this->placeholder = $this->_language[$this->_config['language']]['placeholder'];   // Placeholder
        $this->passMsg = $this->_language[$this->_config['language']]['confirm'];           // Confirmation message (optional)
        $this->failMsg = $this->_language[$this->_config['language']]['alert'];             // Failure message           
    }

    /** CAPTCHA and honeypot checking 
     *  Honeypot ($honeypot) can be enabled optionally. 
    */
    public function check($captcha, $honeypot = false) {                                      
        
        $response = mb_strtolower($captcha, 'UTF-8');
        $today = strtolower(date('l'));

        if(array_key_exists($response, $this->_language[$this->_config['language']]) && !$honeypot) {
            $this->passed = $this->_language[$this->_config['language']][$response] === $today ? true : false;
        }
        else {
            $this->passed = false;
        }       
        return $this->passed;                                           
    }
}

/** End of library
 *  Location: ./application/libraries/CIFence.php
 */