<?php
    include "header.php";
?>


<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/fullcalendar.min.js'></script>

    

    <br/>
        
    
    <script>

	$(document).ready(function() {

        
		$('#calendar').fullCalendar({
			defaultDate: this.date,
            displayEventTime: true,
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: [
				
                
                <?php
                
                require_once "inc/dbconnect.php";

                $sql = "select * From K12_EVENTS";
                //$sql = "call K12_EVENTS_GETEVENTS()";   // use stored procedure
                $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
   

                while($row = mysqli_fetch_array($result))
                {
                    $output = "{title:'" . $row['Title'] . "', start: '" . $row['StartDate'];
                    if($row['EndDate'] != '')
                        $output = $output . "', end: '" . $row['EndDate'] . "'},";
                    else
                        $output = $output . "'},";
                    echo $output;
                
                }
                
                ?>
			]
		});
		
	});

</script>





<div class="row">

	<div id='calendar'></div>
    
</div>
    
    
    

<?php
    include "calFooter.php";
    ?>