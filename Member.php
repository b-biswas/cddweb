<?php
    namespace Phppot;

    use \Phppot\DataSource;

    class Member
    {

        private $dbConn;

        private $ds;

        function __construct()
        {
            require_once "DataSource.php";
            $this->ds = new DataSource();
        }

        function validateMember()
        {
            $valid = true;
            $errorMessage = array();
            foreach ($_POST as $key => $value)
            {
                if (empty($_POST[$key]))
                {
                    $valid = false;
                }
            }
            
            if($valid == true)
            {
                // Password matching validation
                if ($_POST['password'] != $_POST['password2'])
                {
                    $valid = false;
                    if(array_key_exists('lang', $_GET))
                    {
                        if ($_GET['lang'] == 'fr')
                        {
                            $errorMessage[] = 'Les mots de passe doivent être identiques.';
                        }
                        elseif($_GET['lang'] == 'de')
                        {
                            $errorMessage[] = 'Passwords should be the same.';
                        }
                        else
                        {
                            $errorMessage[] = 'Passwords should be the same.';
                        }                        
                    }
                    else
                    {
                        $errorMessage[] = 'Passwords should be the same.';
                    }
                }

                // Email Validation
                $checkEmail = true;
                if (! isset($error_message))
                {
                    $email = $_POST['userEmail'];

                    if (filter_var($email, FILTER_VALIDATE_EMAIL))
                    {
                        list($userEmail, $mailDomain) = explode("@", $email); 
                        if (!checkdnsrr($mailDomain, "MX"))
                        {
                            $checkEmail = false;
                        }
                    }
                    else
                    {
                        $checkEmail = false;

                    }
                }

                if ($checkEmail == false)
                {
                    $valid = false;
                    if(array_key_exists('lang', $_GET))
                    {
                        if ($_GET['lang'] == 'fr')
                        {
                            $errorMessage[] = "L'adresse e-mail est invalide.";
                        }
                        elseif($_GET['lang'] == 'de')
                        {
                            $errorMessage[] = "Invalid email address.";
                        }
                        else
                        {
                            $errorMessage[] = "Invalid email address.";
                        }                        
                    }
                    else
                    {
                        $errorMessage[] = "Invalid email address.";
                    }
                }
                
                // Check if Terms and Conditions are accepted
                /*
                if (! isset($error_message)) {
                    if (! isset($_POST["terms"])) {
                        $errorMessage[] = "Accept terms and conditions.";
                        $valid = false;
                    }
                }
                */
            }
            else
            {
                $errorMessage[] = "All fields are required.";
            }
            
            if ($valid == false)
            {
                return $errorMessage;
            }
            return;
        }

        function isMemberExists($email)
        {
            $query = "select * FROM registered_users WHERE email = ?";
            $paramType = "s";
            $paramArray = array($email);
            $memberCount = $this->ds->numRows($query, $paramType, $paramArray);
            
            return $memberCount;
        }


        function isMemberAllowed($email)
        {
            $query = "select * FROM allowed_users WHERE email = ?";
            $paramType = "s";
            $paramArray = array($email);
            $memberCount = $this->ds->numRows($query, $paramType, $paramArray);
            
            return $memberCount;
        }

        function getMemberStatus($email)
        {
            $query = "SELECT status FROM allowed_users WHERE email = ?";
            $paramType = "s";
            $paramArray = array($email);
            $status = $this->ds->select($query, $paramType, $paramArray);
            
            return $status;
        }


        function insertMemberRecord($first_name, $last_name, $email, $password, $status)
        {
            $options = array(['cost' => 12]);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT, $options);
            $query = "INSERT INTO registered_users (first_name, last_name, email, password, status) VALUES (?, ?, ?, ?, ?)";
            $paramType = "sssss";
            $paramArray = array(
                $first_name,
                $last_name,
                $email,
                $passwordHash,
                $status
            );
            $insertId = $this->ds->insert($query, $paramType, $paramArray);
            return $insertId;
        }
    }
?>