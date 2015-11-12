<!-- Include the header -->
<?php
include "header.php";
require_once "inc/dbconnect.php";

$access = "";

if (!isset($_SESSION['email'])) {
    header ('Location: login.php');
}

$sql = "select AccessLevel From K12_TEACHER WHERE Email = '" .$_SESSION['email']."'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
$access = mysqli_fetch_array($result);

if ($access[0] == 3) {
    Header ("Location:index.php") ;
}
else {
    $sql = "select Authenticated From K12_TEACHER WHERE Email = '" .$_SESSION['email']."'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
    $activated = mysqli_fetch_array($result);
    if ($activated[0] == 'no')
        Header ("Location:activation.php") ;
     }

?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3/datatables.css"/>
 
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3/datatables.js">  </script>
    <script>
    $(document).ready(function() {
        $('table.display').DataTable();
    });
    </script>
<script src="js/account.js"></script>

<?php

$msg = "";

//Greet the user
/*
$sql = "select FirstName, LastName, School, Education, CSBackground from K12_TEACHER where Email = '" .$_SESSION['email']. "'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
$field = mysqli_fetch_array($result); //the query results are objects, in this case, one object
$msg = "Welcome <span id='greeting'>" . $field[0] . " " . $field[1] . "</span>!<br/><br/>";
*/

?>


<div class="row">


    <h3>Admin Control Page</h3>
    
    <?php
    echo $msg;
    ?>
    
    <p>
    
        <?php
        
        if ($access[0] == 1) {
            
            $promoteUI = "
            <ul class='nav nav-tabs'>
                <li class='active'><a href='#tDataTab'>Teacher Data</a></li>
                <li><a href='#promote'>Promote Admins</a></li>
            </ul>
            <div class='tab-content'>
            <div id='promote' class='tab-pane fade'>
            
            <br/>
            User Email:<input type='text' id='promoteText' onkeyup='showHint(this.value)'>
            Suggestions: <span id='txtHint'></span>
            <br/><button id='promoteBtn' onclick='makeAdmin(promoteText.value)'>Promote</button>
            
            <br/><div id='msg'></div>
            
            <script>
                    //The showHint function.  This connects to suggestion.php to find suggested last names based on the characters typed so far.
                    function showHint(str) {
                        var xhttp;
                        //If there is nothing in the search box, the suggestion field is left blank. 
                        if (str.length == 0) { 
                            document.getElementById('txtHint').innerHTML = '';
                            return;
                        }
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (xhttp.readyState == 4 && xhttp.status == 200) {
                                document.getElementById('txtHint').innerHTML = xhttp.responseText;
                            }
                        }
                        xhttp.open('GET', 'ajaxPHP/suggestion.php?q='+str, true);
                        xhttp.send();   
                    }
                    function makeAdmin(str) {
                        var xhttp;
                        //If there is nothing in the search box, just return
                        if (str.length == 0) { 
                            return;
                        }
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (xhttp.readyState == 4 && xhttp.status == 200) {
                                if (xhttp.responseText == 'pass') {
                                    $('#msg').html('<b>User ' + str + ' has been promoted to an admin</b>');
                                }
                                else if (xhttp.responseText == 'fail') {
                                    $('#msg').html('<b>User ' + str + ' is already an admin.</b>');
                                }
                                else {
                                    $('#msg').html('<b>User ' + str + ' is already a super admin.</b>');
                                }
                            }
                        }
                        xhttp.open('GET', 'ajaxPHP/makeAdmin.php?a='+str, true);
                        xhttp.send();   
                    }
                    
                    //The getData function.  This connects to the dataTable.php file to get the data on users searched.
                    
                    function getData(str) {
                        var xhttp;
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (xhttp.readyState == 4 && xhttp.status == 200) {
                                
                                var data = JSON.parse(xhttp.responseText); 
                                //If no user was found with the given last name, it gives an error message.
                                if (data.length == 0) {
                                    document.getElementById('msg').innerHTML = '<b>No user with the last name "' + str + '" found.</b><br/><br/>';
                                    
                                    //clear the table 
                                    $('#data').DataTable().clear().draw();
                                }
                                else {
                                    
                                document.getElementById('msg').innerHTML = "";    
                                    
                                //clear the table before new rows are added
                                $('#data').DataTable().clear().draw();
                        
                                //Adds user data to the table one user at a time.
                                   $(document).ready(function() {
                                       for (i = 0; i < data.length; i++) {
                                            $('#data').DataTable().row.add([
                                                data[i][0],
                                                data[i][1],
                                                data[i][2],
                                                data[i][3],
                                                data[i][4],
                                                data[i][5],
                                                data[i][6]
                                            ]).draw(false);
                                       }
                                    });
                                }
                                    
                            }
                        }
                        xhttp.open('GET', 'dataTable.php?q='+str, true);
                        xhttp.send();   
                    }
                    
            $(document).ready(function(){
                $('.nav-tabs a').click(function(){
                    $(this).tab('show');
                });
                
            });
                    
            </script>
            
            </div>
                <div id='tDataTab' class='tab-pane fade in active'>
                    <br/>
                    User Email:<input type='text' id='teacherData'>
                    <span id='table'>
                    
                    <table id='data' class='display' cellspacing='0' width='100%'> 
                    <thead><tr>
                        <th>First Name</th><th>Last Name</th><th>Email</th><th>Gender</th><th>State</th><th>Birth Year</th><th>User ID</th>
                    </tr></thead>
                        <tbody>
                        </tbody>
                    </table>
                    
        
                </span>
                </div>
            </div>";
            echo ($promoteUI);
            
        }
        
        ?>
        
    </p>

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
