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

	// Ensure that teacherID is retrieved
    if($_SESSION["teacherID"] == "") 
    {
        // this code block should never be reached since the Surveys are only
        // accessible by teachers that are logged-in
        $errorMsg .= "Error retrieveing ID.<br>";
    }
    else
    {

        // get incomplete surveys
        $sqlIncompleteSurvey = "";
		
        $sqlIncompleteSurvey = "SELECT s.ID AS SurveyID, s.ClassID, s.LastQuestionAnswered, c.Name, st.Description FROM K12_SURVEY AS s, K12_CLASS AS c, K12_SURVEYTYPE as st WHERE s.ClassID = c.ID AND Completed =  'no' AND s.SurveyTypeID = st.ID AND TeacherID ='".$_SESSION["teacherID"]."'";
        $incompleteSurveyResult = mysqli_query($conn, $sqlIncompleteSurvey) or die(mysql_error());
        if(!$incompleteSurveyResult)
        {
            
            $errorMsg .= "No unfinished surveys.<br>";
        }
        else
        {
            // build 2D array of incomplete survey information
			// counter for primary level of array
            $i = 0;
            // create session variable for incomplete surveys
            $_SESSION["incompleteSurveys"] = array(); // initialize session variable

            // get the incomplete surveys from a given user
            // each row is a survey
            while($row = mysqli_fetch_array($incompleteSurveyResult))
            {   
                $surveyInfoArray = array();

                for($j = 0; $j < 5; $j++)
                {
                    $surveyInfoArray[$j] = $row[$j];
                }
                $_SESSION["incompleteSurveys"][$i] = $surveyInfoArray;
                $i++;
            }

            mysqli_free_result($incompleteSurveyResult);
            $conn->next_result();
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

