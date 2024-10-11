<?php

class authentication {

    public function bind_to_template($replacements, $template) {
        return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
            return $replacements[$matches[1]] ?? ''; // Return the replacement value or empty if not set
        }, $template);
    }

    // Signup function with form validation, error checking, and sending a verification email
    public function signup($conn, $ObjGlob, $ObjSendMail, $lang, $conf) {
        if (isset($_POST["signup"])) {
            $errors = array();

            // Escaping and formatting input values
            $fullname = $_SESSION["fullname"] = $conn->escape_values(ucwords(strtolower($_POST["fullname"])));
            $email_address = $_SESSION["email_address"] = $conn->escape_values(strtolower($_POST["email_address"]));
            $username = $_SESSION["username"] = $conn->escape_values(strtolower($_POST["username"]));

            // Validate only letters 
            if (ctype_alpha(str_replace(" ", "", str_replace("\'", "", $fullname))) === FALSE) {
                $errors['nameLetters_err'] = "Invalid name format: Full name must contain only letters and spaces.";
            }

            // Validate email format
            if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
                $errors['email_format_err'] = 'Invalid email format.';
            }

            // Validate email 
            $arr_email_address = explode("@", $email_address);
            $spot_dom = end($arr_email_address);

            if (!in_array($spot_dom, $conf['valid_domains'])) {
                $errors['mailDomain_err'] = "Invalid email domain. Use only: " . implode(", ", $conf['valid_domains']);
            }

            // Check if email already exists
            $spot_email_address_res = $conn->count_results(sprintf("SELECT email FROM users WHERE email = '%s' LIMIT 1", $email_address));
            if ($spot_email_address_res > 0) {
                $errors['mailExists_err'] = "Email already exists.";
            }

            // Check if username already exists
            $spot_username_res = $conn->count_results(sprintf("SELECT username FROM users WHERE username = '%s' LIMIT 1", $username));
            if ($spot_username_res > 0) {
                $errors['usernameExists_err'] = "Username already exists.";
            }

            // Verify if username contains only letters
            if (!ctype_alpha($username)) {
                $errors['usernameLetters_err'] = "Invalid username format. Username must contain letters only without spaces.";
            }

            // Proceed with registration if no errors
            if (empty($errors)) {
                $cols = ['fullname', 'email', 'username', 'ver_code', 'ver_code_time'];
                $vals = [$fullname, $email_address, $username, $conf['verification_code'], $conf['ver_code_time']];
                $data = array_combine($cols, $vals);

                // Insert data into the database
                $insert = $conn->insert('users', $data);

                if ($insert === TRUE) {
                    // Prepare email template
                    $replacements = array(
                        'fullname' => $fullname,
                        'email_address' => $email_address,
                        'verification' => $conf['verification'],
                        'site_full_name' => strtoupper($conf['site_initials'])
                    );

                    // Send verification email
                    $ObjSendMail->SendMail([
                        'to_name' => $fullname,
                        'to_email' => $email_address,
                        'subject' => $this->bind_to_template($replacements, $lang["AccountVerification"]),
                        'message' => $this->bind_to_template($replacements, $lang["AccRegVer_template"])
                    ]);

                    // Redirect to verification page
                    header('Location: verification.php');
                    // Clear session data
                    unset($_SESSION["fullname"], $_SESSION["email_address"], $_SESSION["username"]);
                    exit();
                } else {
                    // Handle insert failure (
                    $errors['insert_err'] = "Registration failed. Please try again later.";
                }
            } else {
                // Handle validation errors 
                $ObjGlob->setMsg('signup_errors', $errors, 'alert-danger');
            }
        }
    }

    public function verification($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
        if(isset($_POST["verification"])){
            $errors = array();
            $ver_code = $_SESSION["verification"] = $conn->escape_values($_POST["verification"]."454");
            if(!is_numeric($ver_code)){
                $errors['Not_numeric'] = "Invalid code. The code should be a digit";
            }
            if(strlen($ver_code < 5) || strlen($ver_code > 5) ) {
                $errors['invalid_len'] = "Invalid code. The code should have 5 digits";
            }
            // Check verification code Exists
            $spot_ver_code_res = $conn->count_results(sprintf("SELECT ver_code FROM users WHERE verification = '%d' LIMIT 1", $ver_code));
            if ($spot_ver_code_res != 1){
                $errors['ver_code_not_exist'] = "Invalid code.";
            }
            if(!count($errors)){
                die('All Correct');
            }else{
                $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
                $ObjGlob->setMsg('errors', $errors, 'invalid');
            }
            }
        }
    }

