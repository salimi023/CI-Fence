<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>CI-Fence Demo</title>
    <style>
    body,
    html {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif
    }

    label {
        font-weight: bold;
        font-size: 1.2em
    }

    form {
        margin: 20px 0 0 0
    }

    input,
    textarea {
        border-radius: 5px
    }

    input {
        height: 30px;
        width: 50%;
        padding: 0 0 0 10px
    }

    textarea {
        width: 50%;
        padding: 10px
    }

    .wrapper {
        width: 80%;
        margin: 100px auto 0 auto
    }

    .form-group {
        width: 100%;
        margin: 0 0 20px 0
    }

    .asterisk {
        color: red
    }

    .alert {
        color: red;
        margin: 5px 0 0 0
    }

    .sent {
        width: 50%;
        background-color: green;
        padding: 20px;
        margin: 20px 0 0 0;        
        color: #FFF;
        border-radius: 10px        
    }

    .not-sent {
        width: 50%;
        background-color: red;
        padding: 20px;
        margin: 20px 0 0 0;        
        color: #FFF;
        border-radius: 10px
    }

    .submit-alert {
        font-size: 1.5em;
        line-height: 40px 
    }    

    #honeypot {
        display: none
    }

    #submit {
        background-color: green;
        border: solid thin green;
        color: #FFF
    }

    #submit:hover {
        background-color: red;
        border: solid thin red;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(156, 145, 156, 1);
        -moz-box-shadow: 10px 10px 5px 0px rgba(156, 145, 156, 1);
        box-shadow: 10px 10px 5px 0px rgba(156, 145, 156, 1);
    }
    </style>
</head>

<body>
    <main class="wrapper">
        <h1>CI-Fence</h1>
        <small>Fields marked with <span class="asterisk">*</span> are obligatory!</small>

        <?php
        if(isset($_POST['submit'])) { // Submission alerts (optional)

            if($this->validation) {
                if($this->submitted) {
                    echo '<article class="sent"><span class="submit-alert">Successful submission!</span><br />Thank you!</article>'; 
                }
                else {
                    echo '<article class="not-sent"><span class="submit-alert">Submission failed! Please, try again!</span></article>';
                }
            }
        }
        
        echo form_open('form');
        ?>
        <section class="form-group">
            <label for="name">Name:<span class="asterisk">*</span></label><br />
            <input type="text" name="name" value="<?php echo set_value('name'); ?>" /><br />
            <?php echo form_error('name', '<span class="alert">', '</span>'); ?>
        </section>
        <section class="form-group">
            <label for="email">E-mail:<span class="asterisk">*</span></label><br />
            <input type="text" name="email" value="<?php echo set_value('email'); ?>" /><br />
            <?php echo form_error('email', '<span class="alert">', '</span>'); ?>
        </section>
        <section class="form-group">
            <label for="msg">Message:<span class="asterisk">*</span></label><br />
            <textarea name="msg" cols="50" rows="20"><?php echo set_value('msg'); ?></textarea><br />
            <?php echo form_error('msg', '<span class="alert">', '</span>'); ?>
        </section>

        <!--
        CAPTCHA && honeypot fields
        Please note that the placeholder of the CAPTCHA field is displaying the placeholder value set by the relating language dataset of the CI-Fence lib.
        The fields' name attribute can be set to anything. Please adjust the field names in your controller method accordingly (at the call of the check() method and the form validaton rules).
        Honeypot field is optional.        
        -->
        <section class="form-group">
            <label for="sec">Security Question:<span class="asterisk">*</span></label><br />
            <input type="text" name="captcha" value="" placeholder="<?php echo $this->cifence->placeholder; ?>" /><br />
            <?php echo form_error('captcha', '<span class="alert">', '</span>'); ?>
            <input type="text" name="honeypot" id="honeypot" autocomplete="off" value="" />
        </section>
        <!--End of CAPTCHA && honeypot fields-->

        <section class="form-group">
            <input type="submit" name="submit" id="submit" value="Submit" />
        </section>
        </form>
    </main>
</body>

</html>