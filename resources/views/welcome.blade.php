<!DOCTYPE html> <html> <head> <title> Тестовое задание </title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> </head>


 <body style="text-align:center;" id="body"> <!-- заголовок -->


 <h1> Отправка SMS через api/send  </h1>

 <p><input type="text" id="to" placeholder="Номер телефона">
 <input type="text" id="message" placeholder="Сообщение">


 <button onclick="sendJSON()">Отправить SMS </button>

 <p class="result" style="color:blue"></p> </p> </body> </html>






<h1> Отправка SMS через api/mass  </h1>

<form method="post" action="/api/mass">
 <input type="text" id="massnums" placeholder="Номер телефонов через запятую">
 <input type="text" id="messagemass" placeholder="Сообщение">


<button type="submit">Отправить форму</button>

</form>


 <script>

 function sendJSON() {

  let result = document.querySelector('.result');
  let xhr = new XMLHttpRequest();
  let url = "/api/send";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
  if (xhr.readyState === 4 && xhr.status === 200) {result.innerHTML = this.responseText; } };

  data = JSON.stringify({ "message":message.value, "to": to.value });



  xhr.send(data); } </script>

