<!-- Include the header -->
<?php
    include "header.php";
    include "../db/dbconnect.php";   
?>

<?php
    // initialize variables
    $insertOK = false;
    $currentUser = "";
    $errorMsg = "";


    $ques1 = 1;
    $ques2 = 2;

    $ans1 = $_POST["a1"];
    $ans2 = $_POST["a2"];

    $sqlInsert = "INSERT INTO `nelson8_db`.`K12_SURVEY_ANSWERS` (`ID`, `SurveyTypeID`, `SurveyID`, `QuestionID`, `AnswerID`) VALUES (NULL, ";
    $sqlInsert1 = $sqlInsert . "1, " . "1, " . $ques1 . ", " . $ans1 . ");";
    $sqlInsert2 = $sqlInsert . "1, " . "1, " . $ques2 . ", " . $ans2 . ");";

    // TODO: consider using the .implode() function to build large strings

    $sqlFullInsert = $sqlInsert1 . $sqlInsert2;



    $result1 = mysqli_multi_query($conn, $sqlFullInsert); 

    print $result1;


?>

<div class="row">


    <h3>Thank you for your time!</h3>
    
    <p>
        <?php print $errorMsg ?>
	
    </p>
    
    

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php mysqli_close($conn)?>
<?php
include "footer.php";
?>
