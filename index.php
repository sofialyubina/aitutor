<html>

<head>

<meta charset="UTF-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

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

    max-width:100%;
    max-height:100%;
    overflow:auto;
  }

  .question {
    text-align: center;
    width: 600px;
    height: 200px;
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

var current_question_index = 0;

function setRandomQuestion() {
  var questions = [
    "В каком году произошло призвание Рюрика на престол?",
    "Год созвания первого Земского Собора?",
    "Какое событие произошло 14 декабря 1825 года?",
    "Когда произошло Бородинское сражение?",
    "В каком году Петр Первый объявляет себя Императором России?",
    "Какая война происходила с 1700 по 1721 года?",
    "В каком году произошел Медный Бунт в Москве?",
    "При Иване 4 начинается новый режим в стране (1565-1572) назовите его.",
    "В каком году в Москве был Соляной бунт?",
    "В каком году Земский собор избрал на царствование Романовых?",
    "Какое известное восстание потрясло Россию в 1667 году? ",
    "В каком году был подписан Тильзитский мир?",
    "В каком году произошла Куликовская битва?",
    "Чье правление длится с 1801 по 1825 года?",
    "Годы правления Александра 2?",
    "В каком году был принят указ “О вольных хлебопашцах”",
    "В каком году принята Русская правда?",
    "Кто вступил на пост президента России в 2000 году?",
    "В каком году вооруженные силы РФ были введены в Чечню для наведения конституционного порядка?",
    "Кто стал автором реформы 1553 года? Именно она стала причиной церковного раскола.",
    "В каком году был убит царевич Дмитрий?",
    "Как называется период Российской истории 1603-1613?",
    "В каком году произошла Невская битва?",
    "В каком году Иван 4 объявляет ссебя царем?",
    "Год крещения Руси"
  ];

  current_question_index = Math.floor(Math.random() * questions.length);
  var question = questions[current_question_index];
  document.getElementById("question").innerHTML = question;
}

var all_answers = {
  "False": [
  	"Ошибся :(",
  	"Нет, это не так :(",
      ],
  "True": [
  	"Правильно! :)",
  	"Верно!",
  	"Да, именно!",
  	"Вы правы! :)",
  	"Так держать!"
  ]
};

function validateForm() {
  $.ajax({
      url: "check_answer.php",
      type: "POST",

      data: JSON.stringify({
          "id": current_question_index + 1,
          "user_answer": document.getElementById("answer_input").value
      }),

      contentType: "application/json",

      success: function(data) {
        console.log(data);
        var answers = all_answers[data.status]
  	var answer = answers[Math.floor(Math.random() * answers.length)];
  	document.getElementById("question").innerHTML = "<i>" + answer + "</i>";
      },

      error: function(e) {
  	  document.getElementById("question").innerHTML = "<i>" + "Что-то пошло не так..." + "</i>";
          console.log(e);
      }

  });

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
