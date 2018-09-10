var tableBody = document.getElementById("tableBody");
var rows = "ZABCDEFGHJKLMNPQRSTUVWXYZ".split("");
var count = 0;
var max_count =0;

for(var i = no_of_rows-1; i>=1 ; i--) {
  document.getElementById("tableBody").innerHTML += '<tr id="'+rows[i]+'"><td class="Row">'+rows[i]+'</td></tr>';
  for(var j = 1; j<=10; j++){
    document.getElementById(rows[i]).innerHTML += '<td><input id="'+rows[i]+j+'" type="checkbox" onclick = "seatCounter(this)"><div class="tooltip"><label for="'+rows[i]+j+'" class="Seats">'+j+'</label><span class="tooltiptext">'+rows[i]+':'+j+'</span></div></td>';
  }
}
document.getElementById("tableBody").innerHTML +='<tr><td colspan="11" id="screen">Screen</td></tr>';

for (var i in reserved_seats){
      document.getElementById(String(rows[reserved_seats[i][0]])+String(reserved_seats[i][1])).disabled = true;
      document.getElementById(String(rows[reserved_seats[i][0]])+String(reserved_seats[i][1])).nextSibling.firstChild.className += " disabled";
}

function seatCounter(cb){

  if (count==max_count && cb.checked){
      alert('Exceeded number of seats selected');
      cb.checked = false;
  }
  else{
    if(cb.checked){
      count++;
    }
    else {
      count--;
    }
  }
}

function showDiv(select){

  if(select.value==0){
    document.getElementById('seat').style.display = "none";
    document.getElementById('proceed_button').style.display = "none";
  }
  else {
    document.getElementById('seat').style.display = "block";
    document.getElementById('proceed_button').style.display = "block";
    max_count = select.value;
  }
}

function login(){

  if(document.getElementById("portal").style.visibility == "hidden"){
    document.getElementById("portal").style.visibility = "visible";
    document.getElementById("login_id").style.backgroundColor = "#111";
  }
  else{
    document.getElementById("portal").style.visibility = "hidden";
    document.getElementById("login_id").style.backgroundColor = "#333";
  }
}

// Append seat to form (to the request body)
function sendForm(screen_id, showtime_id){
  // Create a pseudo Form

  var form = document.createElement('form');
  form.setAttribute('method',"post");
  form.setAttribute('action',"confirmation.php");

  var screen_id_form = document.createElement("input"); //input element, text
  screen_id_form.setAttribute('type',"text");
  screen_id_form.setAttribute('name','screen_id');
  screen_id_form.setAttribute('value',screen_id);

  var showtime_id_form = document.createElement("input"); //input element, text
  showtime_id_form.setAttribute('type',"text");
  showtime_id_form.setAttribute('name','showtime_id');
  showtime_id_form.setAttribute('value',showtime_id);

  form.appendChild(screen_id_form);
  form.appendChild(showtime_id_form);

  var seats = document.querySelectorAll('input:checked');
  var seat_list = [];
  // Add all the seats
  seats.forEach(function(seat){seat_list.push(seat.id)});

  for(var i = 0; i<max_count; i++){
    var seat_id_form = document.createElement("input"); //input seat, text
    seat_id_form.setAttribute('type',"text");
    seat_id_form.setAttribute('name','seat_id[]');
    seat_id_form.setAttribute('value',seat_list[i]);
    form.appendChild(seat_id_form);
  }
  if(seats.length == max_count){
      document.body.appendChild(form);
      form.submit();
  }else {
    alert('Not enough seats');
  }


}
