function validate_fname() {
    var fname = document.getElementById("fname");
    var pos = fname.value.search(/^[a-zA-Z]+$/);
    if (pos != 0) {
        alert("The name you entered (" + fname.value +
            ") is not in the correct form. \n" +
            "The correct form is: " +
            " alphabet only\n");
        fname.focus();
        fname.select();
        document.getElementById("fname_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
        fname.style.border = "3px solid #F00";
        return false;
    } else {

        document.getElementById("fname_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
        fname.style.border = "3px solid #0F0";
        return true;
    }
}

function validate_lname() {
    var lname = document.getElementById("lname");
    var pos = lname.value.search(/^[a-zA-Z]+$/);
    if (pos != 0) {
        alert("The name you entered (" + lname.value +
            ") is not in the correct form. \n" +
            "The correct form is: " +
            " alphabet only\n");
        lname.focus();
        lname.select();
        document.getElementById("lname_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
        lname.style.border = "3px solid #F00";
        return false;
    } else {
        document.getElementById("lname_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
        lname.style.border = "3px solid #0F0";
        return true;
    }

}

function validate_date() {
    var date = document.getElementById("date");
    date_start = Date.parse(date.value);
    date_now = new Date();
    if (date_start - date_now.getTime() < 0) {
        alert("Please select a future date.");
        document.getElementById("date_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
        date.style.border = "3px solid #F00";
        return false;
    } else {
        document.getElementById("date_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
        date.style.border = "3px solid #0F0";
        return true;
    }
}

function validate_seats() {
    var seats = document.getElementById("seats");
    if (seats.value == "" || seats.value < 10 || seats.value > 100) {
        alert("Please select number of seats between 10-100\n");
        seats.focus();
        seats.select();
        document.getElementById("seats_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
        seats.style.border = "3px solid #F00";
        return false;
    } else {
        document.getElementById("seats_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
        seats.style.border = "3px solid #0F0";
        return true;
    }
}


function validate_phone() {
    var phoneRegEx = /^\+65(([\s-])?([0-9]{4})){2}$/;
    var pno = document.getElementById("pno").value;

    if (phoneRegEx.test(pno)) {
        document.getElementById("phone_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
        document.getElementById("pno").style.border = "3px solid #0F0";
        return true;

    } else {
        document.getElementById("phone_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
        document.getElementById("pno").style.border = "3px solid #F00";
        return false;
    }

}

function validate_email() {

    var emailRegEx = /^[\w0-9]([\w0-9-.]){1,}[\w0-9]@([\w]){1,}\.(([\w]){1,}\.){0,2}([\w]){2,3}$/;
    var email = document.getElementById("email").value;

    if (emailRegEx.test(email)) {
        document.getElementById("email_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
        document.getElementById("email").style.border = "3px solid #0F0";
        return true;
    } else {
        document.getElementById("email_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
        document.getElementById("email").style.border = "3px solid #F00";
        return false;
    }

}

function check_all()
{
  if(validate_fname() && validate_lname() && validate_seats() && validate_email() && validate_date()  && validate_phone())
    {
      document.getElementById('submit_button').children[0].disabled=0;
      document.getElementById('submit_fail').innerHTML="";
    }
  else {
          document.getElementById('submit_button').children[0].disabled=1;
          document.getElementById('submit_fail').innerHTML="Please correct the fields highlighted in red before submission!!";
  }
}
