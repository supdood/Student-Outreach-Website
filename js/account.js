$(document).ready(function(){
    
    $(document.body).on('click', '#updateName', nameField);
    $(document.body).on('click', '#updateSchool', schoolField);
    $(document.body).on('click', '#updateEdu', eduField);
    
});

function nameField() {
    
    $('#nameArea').html("<br/>First Name:<input type='text' id='fnField' value=" + $('#firstName').text() + ">Last Name:<input type='text' id='lnField' value=" + $('#lastName').text() + "></input><button id='bName' onclick='updateName(fnField.value, lnField.value)'>Save Changes</button>");
    
    $('#firstName').html("");
    $('#lastName').html("");
    
}

function schoolField() {
    
    $('#schoolArea').html("<input type='text' id='sField' value=" + $('#school').text() + "></input><button id='sName' onclick='updateSchool(sField.value)'>Save Changes</button>");
    
    $('#school').html("");
    
}

function eduField() {
    
    $('#eduArea').html("<select id='eField'><option value='bs'>B.S.</option><option value='ms'>M.S.</option><option value='phd'>Ph.D.</option></select><button id='eName' onclick='updateEdu(eField.value)'>Save Changes</button>");
    
    $('#education').html("");
    
}

function updateName(fn, ln) {
    
    var xhttp;
    //If there is nothing in the search box, the suggestion field is left blank. 
    if (fn.length != 0 || ln.length != 0) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == "pass") {
                    $('#firstName').html(fn);
                    $('#lastName').html(ln);
                    $('#greeting').html(fn + " " + ln);
                }
            }
        }
        xhttp.open("GET", "updateFiles/updateName.php?fn="+fn +"&ln="+ln, true);
        xhttp.send(); 
    }
    
    $('#nameArea').html("<span id='updateName'>Update Name</span>");
    
}

function updateSchool(str) {
    
    var xhttp;
    //If there is nothing in the search box, the suggestion field is left blank. 
    if (str.length != 0) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == "pass") {
                    $('#school').html(str);
                }
            }
        }
        xhttp.open("GET", "updateFiles/updateSchool.php?s="+str, true);
        xhttp.send(); 
    }
    
    $('#schoolArea').html("<span id='updateSchool'>Update School</span>");
    
}

function updateEdu(str) {
    
    var xhttp;
    //If there is nothing in the search box, the suggestion field is left blank. 
    if (str.length != 0) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == "pass") {
                    switch (str) {
                        case "ms":
                            $('#education').html("M.S.");
                            break;
                        case "phd":
                            $('#education').html("Ph.D.");
                            break;
                        default:
                            $('#education').html("B.S.");
                            }
                }
            }
        }
        xhttp.open("GET", "updateFiles/updateEdu.php?e="+str, true);
        xhttp.send(); 
    }
    
    $('#eduArea').html("<span id='updateEdu'>Update Education Level</span>");
    
}