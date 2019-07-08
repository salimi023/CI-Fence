<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

    public $validation = null;
    public $submitted = null;    

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        $this->load->library('form_validation');

        /** Load CI-Fence library */
        $this->load->library('cifence');
        
        $this->form_validation->set_rules('name', 'name', 'strip_tags|trim|required', ['required' => 'Please provide a %s!']);
        $this->form_validation->set_rules('email', 'e-mail address', 'strip_tags|trim|required|valid_email', ['required' => 'Please provide an %s!', 'valid_email' => 'Please provide a valid %s!']);
        $this->form_validation->set_rules('msg', 'message', 'strip_tags|trim|required', ['required' => 'Please provide a %s!']);

        /** Set the validation rule of the CAPTCHA field */
        $this->form_validation->set_rules('captcha', 'answer', ['required', ['captcha_callable', [$this->cifence, 'check']]], ['captcha_callable' => $this->cifence->failMsg]);       
        
        if(!$this->form_validation->run()) {
            $this->validation = false;
        }
        else {
            $this->validation = true;

            /** Call the CAPTCHA and honeypot checking method
             * First argument: CAPTCHA value
             * Second argument: honeypot value
             * 
             * If honeypot is not used, the second argument is not needed.
             */
            $this->cifence->check($this->input->post('captcha'), $this->input->post('honeypot'));                        

            if($this->cifence->passed) { // Checking the returned CAPTCHA validation value (verified). 

                /** Your submit code comes here */

                $this->submitted = true;
            }
            else { // Denied.
                $this->submitted = false;
            }
        }        
        $this->load->view('form');             
    }   
}