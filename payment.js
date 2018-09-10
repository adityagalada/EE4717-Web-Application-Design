function checkName(){

  var nameRegEx = /^([a-zA-Z-']){2,}(\s([a-zA-Z-']){2,})+$/;
  var name = document.getElementById("name").value;

  if(nameRegEx.test(name)){
      document.getElementById("name_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
      document.getElementById("name").style.border = "3px solid #0F0";
      return true;
  }
  else{
      document.getElementById("name_marker").innerHTML="<img src ='Images/cross.png' width ='30'>";
      document.getElementById("name").style.border = "3px solid #F00";
      return false;

      }

}

function checkPhone(){

  var phoneRegEx = /^\+65(([\s-])?([0-9]{4})){2}$/;
  var pno = document.getElementById("pno").value;

  if(phoneRegEx.test(pno)){
            document.getElementById("phone_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
      document.getElementById("pno").style.border = "3px solid #0F0";
      return true;

  }
  else{
      document.getElementById("phone_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
      document.getElementById("pno").style.border = "3px solid #F00";
      return false;
  }

}

function checkEmail(){

  var emailRegEx = /^[\w0-9]([\w0-9-.]){1,}[\w0-9]@([\w]){1,}\.(([\w]){1,}\.){0,2}([\w]){2,3}$/;
  var email = document.getElementById("email").value;

  if(emailRegEx.test(email)){
          document.getElementById("email_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
      document.getElementById("email").style.border = "3px solid #0F0";
      return true;
  }
  else{
          document.getElementById("email_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
      document.getElementById("email").style.border = "3px solid #F00";
      return false;
  }

}


function cardValidate(){

  var card_type = document.getElementById("card").value;
  var card_no = document.getElementById("ccno");

  var card_type = document.getElementById("card").value;

  var visaRegEx = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
  var mastercardRegEx = /^(?:5[1-5][0-9]{14})$/;
  var amexRegEx = /^(?:3[47][0-9]{13})$/;
  var isValid = false;
  document.getElementById("ccno").style.border = "3px solid #F00";
  // document.getElementById("ccno").style.borderColor = "red";

  if (visaRegEx.test(card_no.value) && card_type==1) {
    isValid = true;

  } else if(mastercardRegEx.test(card_no.value) && card_type==2) {
    isValid = true;

  } else if(amexRegEx.test(card_no.value) && card_type==3) {
    isValid = true;
  }

  if(isValid)
  {    document.getElementById("card_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
       document.getElementById("ccno").style.border = "3px solid #0F0";
      return true;
    }
  else {
        document.getElementById("card_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
        return false;
  }

}

function check_type(){

  var card_type = document.getElementById("card");
  if(card_type.value==0){
    document.getElementById("card_type_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
    alert("Please select a Card Type first!");
    return false;
  }
  else {
    document.getElementById("card_type_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
    return true;
  }
}

function cvv_validate(){

  var cvvRegEx = /^([0-9]{3})$/;
  var cvv = document.getElementById("cvv").value;

  if(cvvRegEx.test(cvv)){
      document.getElementById("cvv").style.border = "3px solid #0F0";
      document.getElementById("cvv_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
      return true;
  }
  else{
    document.getElementById("cvv_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
      document.getElementById("cvv").style.border = "3px solid #F00";
      return false;
  }
}

function check_expiration(){

  var today, someday;
  var exMonth=document.getElementById("expm").value;
  var exYear=document.getElementById("expy").value;
  if((exYear!=0) && (exMonth!=0)){
    today = new Date();
    someday = new Date();
    someday.setFullYear(exYear, exMonth, 1);

    if (someday < today) {
      document.getElementById("month_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
      document.getElementById("year_marker").innerHTML = "<img src ='Images/cross.png' width ='30'>";
      alert("Please enter a valid expiry date");
      return false;
    }
    else {
      document.getElementById("month_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
      document.getElementById("year_marker").innerHTML = "<img src ='Images/tick.png' width ='30'>";
      return true;
    }
  }
}

function check_all()
{
  if(checkName() && checkPhone() && checkEmail() && cardValidate() && check_type() && cvv_validate() && check_expiration())
    {
      document.getElementById('submit_button').children[0].disabled=0;
      document.getElementById('submit_fail').innerHTML="";
    }
  else {
          document.getElementById('submit_button').children[0].disabled=1;
          document.getElementById('submit_fail').innerHTML="Please correct the fields highlighted in red before submission!!";
  }
}
