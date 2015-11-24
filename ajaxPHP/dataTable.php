<?php

//Ethan Fetsko
//Data Table Page
//November 7, 2015

require_once "../ajax/dbconnect.php";
header('Content-Type: application/json');

// get the q parameter from URL.  This is the text that the user typed into the text box.
//$q = $_REQUEST["q"];
$sID = $_REQUEST["i"];

$sID = mysqli_real_escape_string($con, $sID);

$match = false;


$sql = "select SurveyTypeID From K12_SURVEY where ID = '".$sID."'";
$result = $DB->GetAll($sql);
$tID = $result[0][0];

$sql = "select * From K12_SURVEY_ANSWERS where SurveyID = '".$sID."'";
$result = $DB->GetAll($sql);
$answers = $result;

//$sql = "select Question From K12_POSTSURVEY_QUESTIONS where ID = '".$sID."'";
//$result = $DB->GetAll($sql);
//$questions = $result[0][0];

$questionIDArray = array();
$answerIDArray = array();

$questionArray = array();
$answerArray = array();

foreach ($result as $row) {
    $questionIDArray[] = $row['QuestionID'];
    $answerIDArray[] = $row['AnswerID'];
}

foreach ($questionIDArray as $index) {
    if ($tID == 1)
        $sql = "select Question From K12_PRESURVEY_QUESTIONS where ID = '".$index."'";
    else
        $sql = "select Question From K12_POSTSURVEY_QUESTIONS where ID = '".$index."'";
    $result = $DB->GetAll($sql);
    $questionArray[] = $result[0][0];
    
}

foreach ($answerIDArray as $index) {
    $sql = "select Description From K12_LICHERT_ANSWERS where ID = '".$index."'";
    $result = $DB->GetAll($sql);
    $answerArray[] = $result[0][0];
    
}

$data = array();

for($i = 0; $i < count($answerArray); $i++) {
    $array = array($i+1, $questionArray[$i], $answerArray[$i]); 
    $data[] = $array;
}


//$q = strtolower($q);

//Itterrates through each row in the REGISTRATION
/*
foreach ($result as $row) {
    
    //If the last name matches what was typed in, an array of it's values is added to the $data arary.
    if (strtolower($row["LastName"]) == $q) {
        $data[] = array($row["FirstName"], $row["LastName"], $row["UserName"], $row["Gender"], $row["State"], $row["BirthYear"], $row["ID"]);
        $match = true;
    }
}
*/

//The $data array is then echoed back to lab5.php via json.
echo json_encode($data);

?>