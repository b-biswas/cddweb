<?php		
	namespace Phppot;
	use \Phppot\Member;
	    
    $firstName = filter_var($_POST["firstName"], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST["lastName"], FILTER_SANITIZE_STRING);
    $userEmail = filter_var($_POST["userEmail"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
	    
    require_once ("Member.php");

    $member = new Member();
    $errorMessage = $member->validateMember($firstName, $lastName, $userEmail, $password);
	    
    if (empty($errorMessage))
    {
        $memberCount = $member->isMemberExists($userEmail);
        $memberAllowed = $member->isMemberAllowed($userEmail);

        if ($memberCount == 0 && $memberAllowed == 1)
        {
        	$status = getMemberStatus($email);
            $insertId = $member->insertMemberRecord($firstName, $lastName, $userEmail, $password, $status);
            if (! empty($insertId)) {
                header("Location: en/thanks_en.php");
            }
        }
        else if ($memberCount > 0)
        {
            $errorMessage[] = "User already exists.";
        }
        else
        {
        	$errorMessage[] = "You're not allowed to register. If you think it's an error, please contact us.";
        }	        
    }
?>