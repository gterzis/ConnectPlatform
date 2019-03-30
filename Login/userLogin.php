<?php //called by Identification.php

class userLogin
{
    public $email;
    public $password;
    public function __construct($email, $password) {
        $this->email = strtolower($email); // convert characters to lower case
        $this->password = $password;
    }

    //EMAIL validation
    function checkEmail() {

        if (empty($this->email))
        {
            $error = str_replace(' ', '%20', "Email and password are both required");
            echo $error;
            exit();
        }
        else
        {
            $this->email = $this->test_input($this->email);
            //Check if e-mail address is well-formed
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            {
                $error = str_replace(' ', '%20', "Invalid email or password");
                echo $error;
                exit();
            }
        }
    }

    //PASSWORD validation
    function checkPassword(){

        if ( empty($this->password) )
        {
            $error = str_replace(' ', '%20', "Email and password are both required");
            echo $error;
            exit();
        }
        else if (!ctype_alnum($this->password) )
        {
            $error = str_replace(' ', '%20', "Invalid email or password");
            echo $error;
            exit;
        }
    }

    function test_input($data){
        $data = trim($data); //removes whitespace from both sides
        $data = stripslashes($data); //removes backslashes
        $data = htmlspecialchars($data);
        return $data;
    }
}