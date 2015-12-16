<?php
    include "surveyHeader.php"; 
    // include "utils/surveyFuncs.php";
    include "../db/dbconnect.php";
    include "utils/authenticationIncludes.php";
?>

<style type="text/css">
span{
    margin-top: 5px;
    margin-bottom: 5px;
    
}

</style>

<?php
    if(isset($_POST["btnStartPreSurvey"]))
    {   
        $notifications = "";

        // identifying survey type
        $_SESSION["surveyType"] = 1;

        // get total count of questions
        $questionCountSql = "call K12_PRESURVEY_QUESTIONS_GETQUESTIONCOUNT()";
    
        $questionCountResult = mysqli_query($conn, $questionCountSql) or die(mysqli_error($conn));
        $questionCountField = mysqli_fetch_array($questionCountResult);
        if(count($questionCountField != 0))
        {
            $_SESSION["questionCount"] = $questionCountField[0];
    
        }

    
        mysqli_free_result($questionCountResult);
    
        $conn->next_result();

        // create new survey in database
        $insertSql = "call K12_SURVEY_INSERTNEWSURVEY('".$_SESSION["teacherID"]."', '".$_SESSION["classID"]."', 'no', 1)";
    
    
        if(mysqli_query($conn, $insertSql))
        {
            $notifications .= "PreSurvey successfully created<br>";
        }

    

        // next get newly created surveyID
        $getSurveyIDSql = "Select ID From K12_SURVEY WHERE TeacherID ='".$_SESSION["teacherID"]."' AND ClassID = '".$_SESSION["classID"]."' AND SurveyTypeID = '1'";
    
        $getSurveyIDResult = mysqli_query($conn, $getSurveyIDSql) or die(mysqli_error($conn));

        if($getSurveyIDResult != false)
        {
            $field = mysqli_fetch_array($getSurveyIDResult);
            if(count($field) != 0)
            {
                $_SESSION["surveyID"] = $field[0];
                $surveyID = $field[0];

            }
        }
    }

    if(isset($_POST["btnStartPostSurvey"]))
    {
        // intiialize the notifications variable
        $notifications = "";

        // identifying survey type
        $_SESSION["surveyType"] = 2;

        // get total count of questions
        $questionCountSql = "call K12_POSTSURVEY_QUESTIONS_GETQUESTIONCOUNT()";
        $questionCountResult = mysqli_query($conn, $questionCountSql);
        $questionCountField = mysqli_fetch_array($questionCountResult);
        if(count($questionCountField != 0))
        {
            $_SESSION["questionCount"] = $questionCountField[0];
        }

    
        $questionCountResult->close();
        $conn->next_result();
    



        // create new survey in database
        $insertSql = "call K12_SURVEY_INSERTNEWSURVEY('".$_SESSION["teacherID"]."', '".$_SESSION["classID"]."', 'no', 2)";
        if(mysqli_query($conn, $insertSql))
        {
            $notifications .= "PostSurvey successfully created<br>";
        }
        // next get newly created surveyID
        $getSurveyIDSql = "SELECT ID FROM K12_SURVEY WHERE TeacherID ='".$_SESSION["teacherID"]."' AND ClassID ='".$_SESSION["classID"]."' AND SurveyTypeID = '".$_SESSION["surveyType"]."'";
        $getSurveyIDResult = mysqli_query($conn, $getSurveyIDSql)  or die(mysql_error());
        $field = mysqli_fetch_array($getSurveyIDResult);
        if(count($field) != 0)
        {
            $_SESSION["surveyID"] = $field[0];
            $surveyID = $field[0];

            
        }
    }

    if(isset($_POST["btnExistingSurvey"]))
    {
        // intiialize the notifications variable
        $notifications = "";

        //flag for entering exisiting survey
        $reEnter = true;

        // get surveyType of existing survey
        if($_SESSION["surveyType"] == "")
        {
            $surveyTypeSql = "call K12_SURVEY_GETSURVEYTYPE(".$_SESSION["surveyID"].")";
            $surveyTypeResult = mysqli_query($conn, $surveyTypeSql);
            $surveyTypeField = mysqli_fetch_array($surveyTypeResult);
            if(count($surveyTypeField != 0))
            {
                // set session variable
                $_SESSION["surveyType"] = $surveyTypeField[0];
            }

            // $surveyTypeSql = "";
            mysqli_free_result($surveyTypeResult);
            $conn->next_result();
        }
        
        

        // if pre survey
        if($_SESSION["surveyType"] == 1)
        {
            // get total count of questions
            $questionCountSql = "";
        
            $questionCountSql = "Select count(*) as c FROM K12_PRESURVEY_QUESTIONS";
            $questionCountResult = mysqli_query($conn, $questionCountSql);
            $questionCountField = mysqli_fetch_array($questionCountResult);

            if(count($questionCountField != 0))
            {
                $_SESSION["questionCount"] = $questionCountField[0];
            }

        }

        // if post survey
        elseif($_SESSION["surveyType"] == 2)
        {
            // get total count of questions

            $questionCountSql = "Select count(*) as c FROM K12_POSTSURVEY_QUESTIONS";
            $questionCountResult = mysqli_query($conn, $questionCountSql);
            $questionCountField = mysqli_fetch_array($questionCountResult);
            if(count($questionCountField != 0))
            {
                $_SESSION["questionCount"] = $questionCountField[0];
            }
        }


        $existingSql = "Select LastQuestionAnswered FROM K12_SURVEY WHERE ID = ".$_SESSION["surveyID"]."";
        
        $existingResult = mysqli_query($conn, $existingSql);

        $fields = mysqli_fetch_array($existingResult);
        // populate lastQuestionAnswered session variable
        $_SESSION["lastQuestionAnswered"] = $fields[0];
        

        mysqli_free_result($existingResult);
        $conn->next_result();

    }

    if($_SESSION["lastQuestionAnswered"] >= $_SESSION["questionCount"])
    {
        Header("location:CompletedSurvey.php?");
    }





    // captures the answers to the questions as they are submitted
    if(isset($_POST["enter"]))
    {
        if(!isset($reEnter)) $reEnter = false;
        $notifications = "";
        $surveyID = $_SESSION["surveyID"];
        
        // increment lastQuestionAsked
        // if not first loop of returning to an existing survey 
        if (!$reEnter)
        {
            $_SESSION["lastQuestionAnswered"]++;    
        }
        $reEnter = false;
        
        $previousQuestionIndx = $_SESSION["lastQuestionAnswered"] - 1;


        if(isset($_POST["answer"]))
        {

            $insertPrevAnswer = "call K12_SURVEY_ANSWERS_INSERT_SURVEY(".$surveyID.", ".$previousQuestionIndx.", '".$_POST["answer"]."')";
         
            if(mysqli_query($conn, $insertPrevAnswer))
            {
                $conn->next_result();

                // update SURVEY lastQuestionAnswered field
                $updateLastQuestionAnswered = "UPDATE  K12_SURVEY SET LastQuestionAnswered = '".$_SESSION["lastQuestionAnswered"]."' WHERE  ID ='".$surveyID."'";
                if(mysqli_query($conn, $updateLastQuestionAnswered))
                {
                    $notifications .= "Previous Answer Successfully Saved.<br>";
                }
            }
        }
    }  
    // initialize error message string
    $errorMsg = "";


    
    // initialize survey html variable
    $questionHTML = "";
    $answerHTML = "";
    
    // get questions from database

    if($_SESSION["surveyType"] == 1)
    {
        $qSql = "call K12_PRESURVEY_QUESTIONS_GETQUESTIONAT('".$_SESSION["lastQuestionAnswered"]."')";
    }

    if($_SESSION["surveyType"] == 2)
    {
        $qSql = "call K12_POSTSURVEY_QUESTIONS_GETQUESTIONAT('".$_SESSION["lastQuestionAnswered"]."')";
    }
    
    $questionResult = mysqli_query($conn, $qSql) or die(mysql_error());
    $questionArray = array();
    
    // populate question array
    while($ques = mysqli_fetch_array($questionResult))
    {
        $questionHTML .= $ques[0];
    }
    mysqli_free_result($questionResult);
    $conn->next_result();



    $aSql = "call K12_LICHERT_ANSWERS_GETANSWERS()"; // returns values in ASC order
    $answerResult = mysqli_query($conn, $aSql) or die(mysql_error());
    

    $ans = "";
    $i = 1;

    // add all answers as radio buttons to $answerHTML variable
    while($ans = mysqli_fetch_array($answerResult))
    {
        // if the last question, set radio button as checked
        if($i == 6)
        {
            $answerHTML .= "<input type='radio' value='".$i."'' name='answer' checked>"."&nbsp".$ans[0]."</input>&nbsp&nbsp&nbsp&nbsp";    
            $i++;
        }
        else
        {
            $answerHTML .= "<input type='radio' value='".$i."'' name='answer'>"."&nbsp".$ans[0]."</input>&nbsp&nbsp&nbsp&nbsp";
            $i++;    
        }
        
    }

    mysqli_free_result($answerResult);
    $conn->next_result();

?>


<div class="row">


    <h1>Survey</h1>
    
    <form action="NextQuestion.php" method="post">
        <h2> <?php   print $questionHTML ?> </h2>
        <p> <?php  print $answerHTML  ?>  </p>
        
        <button type="submit" name="enter">Submit Survey</button>
    </form>
    <span> <?php  print $_SESSION["lastQuestionAnswered"]  ?> of <?php  print $_SESSION["questionCount"] ?> </span>
    <br>
    <span style="text-align:center">  <?php if($notifications != "") print $notifications   ?>   </span>

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
    include "surveyFooter.php";
?>