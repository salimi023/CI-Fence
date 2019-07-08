# CI-FENCE

Multilingual, security library (non-image CAPTCHA and optional honeypot) for CodeIgniter.

The main goal of the library is to protect online forms of CodeIgniter based applications against spamming scripts.
In order to pass the CAPTCHA the user must provide the name of the current day in the preset language of the library.
The library also includes a honeypot feature, which is optional.

## SET UP AND CONFIGURATION

(For a demo setup and configuration please refer to the attached controller and view files).

### Location

* ./application/libraries

### Minimal requirements

* HTML form (method: post)
* text type input field for the CAPTCHA value
* text or hidden type input field for the honeypot value (optional)

### Language

* The library can use any languages added to the relating array.
* The array of languages can be shortened or expanded according to the requirements of the given application.
* Preset languages are as follows:
Arabic, German, Greek, English, Spanish, French, Hebrew, Hindi, Hungarian, Italian, Japanese, Korean, Polish, Portugese, Russian, Turkish, Ukrainian, Chinese
* In order to set the used language the short HTML ISO code (e.g `en` but not `en-US`; <https://www.w3schools.com/tags/ref_language_codes.asp>) must be given in the language property of the configuration array. In the lack of the code the lib tries to determine and use the primary language of the userclient (browser) provided that the relating language pack had been added to the array of languages. Failing to do that the default language is English.
* IMPORTANT: Please note, that the NAMES OF THE DAYS both in the native and English languages are in LOWERCASE format. This principle has to be followed when adding any new language dataset.

### Honeypot

* The honeypot is optional.
* In case of using the honeypot, a hidden input field must be added to the form and its value must be passed to the check() method of the library as the second argument of it. If honeypot is not required, the second argument of the method is not needed.

## USAGE

* Copy the CIFence.php file into the ./application/libraries folder.
* If the required language is not added to the languages array, please add it to it. Please, follow the pattern of the other preset language datasets.
* Provide the short code of the required language to the configuration array:
e.g ```$this->_config = ['language' => 'hu'];```
* Load the library into your controller:
```$this->load->library('cifence);```
* In case of using the core form_validation library of CI set up a validation rule, which will return the error alert of the lib given in the language dataset (controller).
e.g ```$this->form_validation->set_rules('captcha', 'answer', ['required', ['captcha_callable', [$this->cifence, 'check']]], ['captcha_callable' => $this->cifence->failMsg]);```
* Add a text type input field to your form (view). Please note, that the field must have a placeholder attribute, which displays the CAPTCHA question in the required language:
e.g ```<input type="text" name="captcha" value="" placeholder="<?php echo $this->cifence->placeholder; ?>" />```
The name attribute of the field can be set to any value.
* In case of using a honeypot, add a hidden input field to the form (view).
e.g ```<input type="text" name="honeypot" id="honeypot" autocomplete="off" value="" />```
The name attribute of the field can be set to any value.
* Within your controller call the check() method of the lib and pass the value(s) of the CAPTCHA and optionally the honeypot fields to it as arguments (CAPTCHA is the first argument, while honeypot is the second.) If honeypot is not required the second argument is not needed.
```$this->cifence->check($this->input->post('captcha'), $this->input->post('honeypot'));```
* Add an `if-else` condition to your controller, which holds the submit code of the form (in case of the CAPTCHA's verification) and the code planned to be run at CAPTCHA failure. As a default the lib returns an error message in case of failure, which can be displayed as the part of the form validation.
e.g ```if($this->cifence->passed) { // Your submit code } else { // Failure action }```

## LICENSE

The library is under MIT license.
