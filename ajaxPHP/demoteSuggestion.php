<?php

//Ethan Fetsko
//Suggestion Page
//November 7, 2015

require_once "../ajax/dbconnect.php";

?>

<?php

// get the q parameter from URL.  This is the text typed into the text box.
$q = $_REQUEST["q"];

$q = mysqli_real_escape_string($con, $q);

$hint = "";

$sql = "select Email From K12_TEACHER where AccessLevel = 2";
$result = $DB->GetAll($sql);

$emails = array();

if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    
    //Itterates through each row.
    foreach ($result as $emailA)
    {
        $email = $emailA[0];
        //If there text typed in matches the begining of a last name, then the last name is added to the $names array.
        if(stristr(substr($email, 0, $len), $q)) {
            if (!in_array($email, $emails))
                $emails[] = $email;
        }
    }
}

$c = count($emails);
//Itterates through the $names array to construct the hint that will be given back to the lab5.php file.
for ($i = 0; $i < $c; $i++) {
    
    if($hint === "") {
                $hint = $emails[$i];
            }
    else
        $hint .= ", $emails[$i]";
    
}

//Sent 'no suggestion' if there are no matches, otherwise send the list of hints.
echo $hint === "" ? "no suggestion" : $hint;





?>