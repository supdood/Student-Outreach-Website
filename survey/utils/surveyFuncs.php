<!-- Jason Nelson
Survey Functions
Functions intended to perform survey related operations -->
<?php
// function ConnectToDatabase()
// {
// 	$conn = mysqli_connect("localhost", "nelson8", "nelson8") or die(mysql_error());
// 	$select = mysqli_select_db("nelson8_db", $conn);

// 	return $select;
// }

function PopulateQuestions($QuestionResult, $AnswerResult)
{
	// will be the string of questions
	$str = "";
	// // get the length of the Question array
	// $arrayLength = count($QuestionArray);
	// iterate through all the elements of array

	// iniitalize AnswerArray
	$AnswerArray = array();
	// populate AnswerArray
	while($ans = mysqli_fetch_array($AnswerResult, MYSQLI_NUM))
	{
		array_push($AnswerArray, $ans);
	}

	// counter
	$i = 1;
	while($question = mysqli_fetch_array($QuestionResult))
	{
		// for each element, build html
		$tempQStr = "";
		$tempAStr = "";
		
		// TODO: may need to alternate ASC & DESC order of lichert answers
		// if (i % 2 == 0) {ASC} else DESC on $AnswerArray
		foreach($question as $q)
		{
			$tempQStr = "<p><label name='q".$i."' class='question".$i."' value='".$i."'>".($i).")  ".$q."</label><br>";
		}

		// // populate answer radio button html
		// $answerArrayLength = count($AnswerArray);


		// initialize answer counter
		$j = 0;
		foreach($AnswerArray as $ans)
		{
			$tempAStr =  $tempAStr . "<input type='radio' value=".$j." name='"."a".$i."' class='question".$i."'>"."&nbsp".$ans[0]."</input>&nbsp&nbsp&nbsp&nbsp";
			$j = $j+1;
		}
		// increment radio group number
		// increment question counter
		$i = $i + 1;

		$str = $str . $tempQStr . $tempAStr . "</p>";
		// $str = $str . "<br>QuestionArrayLength" . $arrayLength . "<br>AnswerArray" . $answerArrayLength;
	}
	$questionCount = $i;
	return $str;
}

function GetQuestionAt($questionQueryStr, $questionIndex)
{
	// will be the html formatted string with question at return
	$str = "";

	// retreive question from Database
	$questionResult = mysqli_query($conn, $qSql) or die(mysql_error());


}



?>