<html>

<head>
<title>
AI | History Tutor
</title>

<style>

  body {
    background: #6c5b7b;
    margin: 0;
    padding: 0;
  }

  .content {
    width: 600px;
    height: 400px;

    position:absolute; /*it can be fixed too*/
    left:0; right:0;
    top:0; bottom:0;
    margin:auto;

    /*this to solve "the content will not be cut when the window is smaller than the content": */
    max-width:100%;
    max-height:100%;
    overflow:auto;
  }

  .question {
    text-align: center;
    width: 600px;
    font-size: 3em;
    color: #fefefe;
    font-weight: bold;
  }

  .answer {
    margin: 70 0 0 0;
    text-align: center;
    color: #ffffff;
    font-weight: bold;
  }

  .answer input {
    border: 0;
    outline: 0;
    background: transparent;
    font-size: 3em;
    width: 500px;
    text-align: center;
    color: #ffffff;
    font-weight: bold;
    border-bottom: 2px solid white;
    font-family: inherit;
  }

  .mark {
    margin: 70 0 0 0;
    text-align: center;
    color: #ffffff;
    font-weight: bold;
  }

</style>

<script>

function sleep (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}

function setRandomQuestion() {
  var questions = [
    "В каком году родился Петр Первый?",
    "Что произошло в России в 1862 году?",
    "Кто пришел к власти в 1917 году?",
    "Когда Наполеон сжег Москву?",
    "Кто победил во Второй Мировой Войне?",
    "Когда был найден философский камень?",
    "Какую реформу провели в каменном веке?"
  ];

  var question = questions[Math.floor(Math.random() * questions.length)];
  document.getElementById("question").innerHTML = question;
}

function validateForm() {
  var answers = [
    "Правильно! :)",
    "Верно!",
    "Ошибся :(",
    "Да, именно!",
    "Вы правы! :)",
    "Нет, это не так :(",
    "Так держать!"
  ]

  var answer = answers[Math.floor(Math.random() * answers.length)];
  document.getElementById("question").innerHTML = "<i>" + answer + "</i>";

  sleep(2000).then(() => {
    setRandomQuestion();
    document.getElementById("answer_input").value = "";
  });

  return false;
}


</script>

</head>

<body>

<div class="content">
<div class="wrapper"> 
<div id="question" class="question">
</div>

<div class="answer">
<form action="" method="post"  onsubmit="return validateForm()" >
<input autocomplete="off" id="answer_input" type="text"> </input>
<input type="submit" hidden>
</form>
</div>

<div id="mark" class="mark">
</div>

</div>
</div>

<script>

setRandomQuestion();

</script>

</body>

</html>
