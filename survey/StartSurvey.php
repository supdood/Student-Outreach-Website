<?php 
    include "surveyHeader.php"; 
    include "../db/dbconnect.php";
    include "utils/authenticationIncludes.php";
?>

<style type="text/css">
/*  input[type="text"]
    {
        width: 30%;
    }*/
    div
    {
        width: 30%;
        text-align: center;
        margin: 0 auto;
    }

</style>

<?php

    // initialize error message string
    $errorMsg = "";

    // if error message sent back to this page, add to the error messages
    if(isset($_GET["q"]))
    {
        $errorMsg .= $_GET["q"] . "<br><br>";
    }
    
    // check for incomplete surveys
    // first get teacherID
    $sqlTeacherID = "SELECT ID FROM K12_TEACHER WHERE Email = '".$_SESSION["email"] ."'";
    // print $sqlTeacherID;
    $teacherIDResult = mysqli_query($conn, $sqlTeacherID) or die(mysql_error());

	// Ensure that teacherID is retrieved
    if(!$teacherIDResult) 
    {
        $errorMsg .= "Error retrieveing ID.<br>";
    }
    else
    {
        $teacherIDField = mysqli_fetch_array($teacherIDResult); //the query results are objects, in this case, one object
        $teacherID = $teacherIDField[0];
        // print $teacherID;

        // create session variable for ID
        $_SESSION["teacherID"] = $teacherID;

        // since teacherID found, get incomplete surveys
        $sqlIncompleteSurvey = "";
		//TODO: include class name in the incompleteSurvey sql statement/array to include more info for the user
        $sqlIncompleteSurvey = "SELECT ID as SurveyID, ClassID, LastQuestionAnswered FROM K12_SURVEY WHERE Completed = 'no' AND TeacherID = '" . $teacherID."'";
        //print $sqlIncompleteSurvey;
        $incompleteSurveyResult = mysqli_query($conn, $sqlIncompleteSurvey) or die(mysql_error());
        if(!$incompleteSurveyResult)
        {
            //print "No unfinished Surveys found.";
            $errorMsg .= "No unfinished surveys.<br>";
        }
        else
        {
            // build 2D array of incomplete survey information
			// counter for primary level of array
            $i = 0;
            // create session variable for incomplete surveys
            $_SESSION["incompleteSurveys"] = array(); // initialize session variable

            // $incompleteSurveyArray = array();
            while($row = mysqli_fetch_array($incompleteSurveyResult))
            {   
                $surveyInfoArray = array();
                // print "<br>". count($row) . "<br>row[0]: " . $row[0] . "<br>row[1]: " . $row[1] . "<br>row[3]: " . $row[2];
                for($j = 0; $j < 3; $j++)
                {
                    $surveyInfoArray[$j] = $row[$j];
                }
                $_SESSION["incompleteSurveys"][$i] = $surveyInfoArray;
                $i++;
            }
            //print_r($_SESSION["incompleteSurveys"][0]);
        }
    }  

?>

<div class="row">


    <h3>Survey Manager</h3>
    <span style="color:red; text-align:center"><?php print $errorMsg ?></span>
    
    <form action="NewSurvey.php" method="post">
        <button name="ToNewSurvey">Take New Survey</button>
    </form>
    <br>
    <form action="ExistingSurvey.php" method="post">
        <button name="ToExistingSurvey">Finish a Survey</button>

    </form>
    

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "surveyFooter.php";
?>

