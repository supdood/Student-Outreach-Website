<?php
    include "surveyHeader.php"; 
    // include "utils/surveyFuncs.php";
    include "../db/dbconnect.php";
    include "utils/authenticationIncludes.php";
?>

<?php
    if(isset($_POST["btnStartPreSurvey"]))
    {   
        $notifications = "";

        // TODO: get count of questions in PreSurvey to be able to check whether a survey is completed

        // identifying survey type
        $_SESSION["surveyType"] = 1;

        // get total count of questions
        $questionCountSql = "call K12_PRESURVEY_QUESTIONS_GETQUESTIONCOUNT()";
    // print $questionCountSql;
        $questionCountResult = mysqli_query($conn, $questionCountSql) or die(mysqli_error($conn));
        $questionCountField = mysqli_fetch_array($questionCountResult);
        if(count($questionCountField != 0))
        {
            $_SESSION["questionCount"] = $questionCountField[0];
            // print "<br> questionCountField: " . $questionCountField[0];
        }

        // $questionCountSql = "";
        mysqli_free_result($questionCountResult);
        // $questionCountField = "";
        $conn->next_result();

        // create new survey in database
        $insertSql = "call K12_SURVEY_INSERTNEWSURVEY('".$_SESSION["teacherID"]."', '".$_SESSION["classID"]."', 'no', 1)";
    // print "<br>insertNewSurveySQL:  " . $insertSql;
    
        if(mysqli_query($conn, $insertSql))
        {
            $notifications .= "PreSurvey successfully created<br>";
        }

        // mysqli_free_result($result);

        // next get newly created surveyID
        $getSurveyIDSql = "Select ID From K12_SURVEY WHERE TeacherID ='".$_SESSION["teacherID"]."' AND ClassID = '".$_SESSION["classID"]."' AND SurveyTypeID = '1'";
    // print "<br> getSurveyIDSQL: " . $getSurveyIDSql;
        $getSurveyIDResult = mysqli_query($conn, $getSurveyIDSql) or die(mysqli_error($conn));

        if($getSurveyIDResult != false)
        {
            $field = mysqli_fetch_array($getSurveyIDResult);
            if(count($field) != 0)
            {
                $_SESSION["surveyID"] = $field[0];
                $surveyID = $field[0];
                // print "<br> surveyID value: " . $surveyID;

                // $notifications .= "<br>" . $surveyID;   
            }
        }
        

        // $getSurveyIDSql = "";
        // $getSurveyIDResult->close();
        // $conn->next_result();
        // $field = "";
        

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

        // $questionCountSql = "";
        $questionCountResult->close();
        $conn->next_result();
        // $questionCountField = "";



        // create new survey in database
        $insertSql = "call K12_SURVEY_INSERTNEWSURVEY('".$_SESSION["teacherID"]."', '".$_SESSION["classID"]."', '".$_SESSION["lastQuestionAnswered"]."', 'no', 2)";
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

            $notifications .= "<br>" . $surveyID;   
        }

        // $getSurveyIDSql = "";
        // mysqli_free_result($getSurveyIDResult);
        // $field = "";
    }

    if(isset($_POST["btnExistingSurvey"]))
    {
        // intiialize the notifications variable
        $notifications = "";

        // get surveyType of existing survey
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
        // $surveyTypeField = "";

        // if pre survey
        if($_SESSION["surveyType"] == 1)
        {
            // get total count of questions
            $questionCountSql = "";
            // $questionCountSql = "CALL K12_PRESURVEY_QUESTIONS_GETQUESTIONCOUNT()";
            $questionCountSql = "Select count(*) as c FROM K12_PRESURVEY_QUESTIONS";
            $questionCountResult = mysqli_query($conn, $questionCountSql);
            $questionCountField = mysqli_fetch_array($questionCountResult);

            if(count($questionCountField != 0))
            {
                $_SESSION["questionCount"] = $questionCountField[0];
            }

            // $questionCountSql = "";
            // mysqli_free_result($questionCountResult);
            // $questionCountField = "";
        }

        // if post survey
        elseif($_SESSION["surveyType"] == 2)
        {
            // get total count of questions
            // $questionCountSql = "CALL K12_POSTSURVEY_QUESTIONS_GETQUESTIONCOUNT()";
            $questionCountSql = "Select count(*) as c FROM K12_POSTSURVEY_QUESTIONS";
            $questionCountResult = mysqli_query($conn, $questionCountSql);
            $questionCountField = mysqli_fetch_array($questionCountResult);
            if(count($questionCountField != 0))
            {
                $_SESSION["questionCount"] = $questionCountField[0];
            }

            // $questionCountSql = "";
            // mysqli_free_result($questionCountResult);
            // $questionCountField = "";
        }
        // else
        // {
        //     $countError = "Sorry, there has been an error with the survey. Please try again later.";
        //     $countErrorType = "could not get question count";
        //     Header("location:StartSurvey.php?q=".$countError."&errorType=".$countErrorType);
        // }

        // create new survey in database
        // $insertSql = "K12_SURVEY_INSERTNEWSURVEY('".$_SESSION["teacherID"]."', '".$_SESSION["classID"]."', '".$_SESSION["lastQuestionAnswered"]."', 'no', 'post'";
        $existingSql = "Select LastQuestionAnswered FROM K12_SURVEY WHERE ID = ".$_SESSION["surveyID"]."";
        // print $existingSql . "<br>";
        $existingResult = mysqli_query($conn, $existingSql);

        $fields = mysqli_fetch_array($existingResult);
        // populate lastQuestionAnswered session variable
        $_SESSION["lastQuestionAnswered"] = $fields[0];

        // $existingSql = "";
        // mysqli_free_result($existingResult);
        // $fields = "";
    }


    if(isset($_POST["enter"]))
    {
        $notifications = "";
        $surveyID = $_SESSION["surveyID"];
        // increment lastQuestionAsked
        $_SESSION["lastQuestionAnswered"]++;
        $previousQuestionIndx = $_SESSION["lastQuestionAnswered"] - 1;

        if($_SESSION["lastQuestionAnswered"] == $_SESSION["questionCount"] + 1)
        {
            Header("location:CompletedSurvey.php?");
        }

        if(isset($_POST["answer"]))
        {
            // print "answer has been submitted";
            // insert last answer into TEACHER_ANSWERS

            $insertPrevAnswer = "call K12_SURVEY_ANSWERS_INSERT_SURVEY(".$surveyID.", ".$previousQuestionIndx.", ".$_POST["answer"].")";
            if(mysqli_query($conn, $insertPrevAnswer))
            {
                // print "<br> answer successfully stored";
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
    //print $qSql;
    $questionResult = mysqli_query($conn, $qSql) or die(mysql_error());
    $questionArray = array();
    // populate question array
    while($ques = mysqli_fetch_array($questionResult))
    {
        $questionHTML .= $ques[0];
    }
    mysqli_free_result($questionResult);
    //print "questionResult Count: ".count($questionResult) . "<br>";
    //print_r($questionResult);
    //print_r($questionArray);
    // print $questionHTML;

    
    // get answers from database
    // $aSql = "SELECT Description FROM K12_LICHERT_ANSWERS ORDER BY K12_LICHERT_ANSWERS.ID ASC";

    // $aSql = "call K12_LICHERT_ANSWERS_GETANSWERS()"; // returns values in ASC order

    //TODO: incorporate table from DB rather than local array
    // $answerResult = mysqli_query($conn, $aSql) or die(mysql_error());
    $answerArray = array();
    $answerArray[1] = "Strongly Agree";
    $answerArray[2] = "Agree";
    $answerArray[3] = "Neutral";
    $answerArray[4] = "Disagree";
    $answerArray[5] = "Strongly Disagree";

    for($i = 1; $i < 6; $i++)
    {
        $answerHTML .= "<input type='radio' value='".$i."'' name='answer'>"."&nbsp".$answerArray[$i]."</input>&nbsp&nbsp&nbsp&nbsp";
    }

    // $ans = "";
    // while($ans = mysqli_fetch_array($answerResult))
    // {
    //     // array_push($answerArray, $ans);
    //     // print $ans[0];
    //     $answerHTML .= "<input type='radio' value='".$ans[0]."'' name='answer'>"."&nbsp".$ans[0]."</input>&nbsp&nbsp&nbsp&nbsp";
    // }

    // mysqli_free_result($answerResult);
    // $conn->next_result();

    // print $answerResult;
    // $answerArray = mysqli_fetch_array($answerResult);
    // print_r($answerArray); 
    // print $answerHTML;
    

?>


<div class="row">


    <h1>Survey</h1>
    
    <form action="NextQuestion.php" method="post">
        <h2> <?php   print $questionHTML ?> </h2>
        <h3> <?php  print $answerHTML  ?>  </h3>
        
        <button type="submit" name="enter">Submit Survey</button>
    </form>
    <span style="text-align:center">  <?php if($notifications != "") print $notifications   ?>   </span>

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
    include "surveyFooter.php";
?>