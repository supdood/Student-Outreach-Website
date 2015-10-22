<!-- Jason Nelson
    PreSurvey.php
    This will populate a survey from the K_12_PRESURVEY_QUESTIONS table
    and 
    The answers will populate from the K12_LICHERT_ANSWERS table-->

<!-- Include the header --> 
<?php 
    include "header.php"; 
    include "utils/surveyFuncs.php";
    include "../db/dbconnect.php";
?>

<?php  
    // initialize error message string
    $errorMsg = "";
    
    // get questions from database
    $qSql = "SELECT Question FROM K12_PRESURVEY_QUESTIONS";
    $questionResult = mysqli_query($conn, $qSql) or die(mysql_error());
    // $questionArray = mysqli_fetch_array($questionResult);

    
    // get answers from database
    $aSql = "SELECT Description FROM K12_LICHERT_ANSWERS ORDER BY K12_LICHERT_ANSWERS.ID ASC";
    $answerResult = mysqli_query($conn, $aSql) or die(mysql_error());
    // $answerArray = mysqli_fetch_array($answerResult); 

    // check for error in query results
    if(!$questionResult || !$answerResult) {$errorMsg = $errorMsg . "Error grabbing values from database.<br>";}

    // initialize survey html variable
    $surveyHTML = "";
    // populate questions with utility function
    $surveyHTML = PopulateQuestions($questionResult, $answerResult);


?>


    
    <!-- A jumbotron to post recent events or announcements at the top of the page.  This can include pictures -->
    
<!-- <div class="jumbotron">
    <div class="container">
        <h1>Student Outreach</h1>
        <p>The IUPUI Student Outreach program is an initiative my IUPUI to get more young students interested in computers, science, and mathematics.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>
</div> -->

<div class="row">


    <h3>Entry Survey</h3>
    <form action="SurveyConfirmation.php" method="post">
        <p>
           <?php print $surveyHTML?><br> 
        </p>
        
        <button type="submit" name="submit">Submit Survey</button>
    </form>

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>