<?php
    include "header.php"; 
    // include "utils/surveyFuncs.php";
    include "../db/dbconnect.php";
?>

<?php
    if(isset($_POST["enter"]))
    {
        // increment lastQuestionAsked
        $_SESSION["lastQuestionAnswered"]++;
        
        

    }  
    // initialize error message string
    $errorMsg = "";
    
    // get questions from database
    //$qSql = "SELECT Question FROM K12_PRESURVEY_QUESTIONS";
    // print "before creating sql string";
    $qSql = "call K12_PRESURVEY_QUESTIONS_GETQUESTIONAT('".$_SESSION["lastQuestionAnswered"]."')";
    //print $qSql;
    $questionResult = mysqli_query($conn, $qSql) or die(mysql_error());
    $questionArray = mysqli_fetch_array($questionResult);
    //print "questionResult Count: ".count($questionResult) . "<br>";
    //print_r($questionResult);
    //print_r($questionArray);

    
    // get answers from database
    //$aSql = "SELECT Description FROM K12_LICHERT_ANSWERS ORDER BY K12_LICHERT_ANSWERS.ID ASC";
    $aSql = "call K12_LICHERT_ANSWERS_GETANSWERS()"; // returns values in ASC order
    $answerResult = mysqli_query($conn, $aSql) or die(mysql_error());
    // initialize answer store
    $answerArray = array();
    $ans = "";
    while($ans = mysqli_fetch_array($answerResult))
    {
        array_push($answerArray, $ans);
    }
    // print $answerResult;
    // $answerArray = mysqli_fetch_array($answerResult);
    // print_r($answerArray); 

    // check for error in query results
    if(!$questionResult || !$answerResult) {$errorMsg = $errorMsg . "Error grabbing values from database.<br>";}

    // initialize survey html variable
    $questionHTML = "";
    $answerHTML = ""
    // populate questions with utility function
    // $surveyHTML = PopulateQuestions($questionResult, $answerResult);
    

?>


<div class="row">


    <h3>Entry Survey</h3>
    
    <form action="NextQuestion.php" method="post">
        <p>
           <?php print $surveyHTML?><br> 
        </p>
        
        <button type="submit" name="enter">Submit Survey</button>
    </form>

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>