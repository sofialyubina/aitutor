<?php
  $bgcolors = array("#5f3596", "#733596", "#8b3596", "#96357e", "#963561");
  $bgcolor = $bgcolors[array_rand($bgcolors)];
?>

<html>

<head>

    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <title>AI | History Tutor</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?<?php echo date('l jS [ ] f F Y h:i:s A'); ?>" />

    <style>
        body {
            background: <?php echo $bgcolor; ?>;
            margin: 0;
            padding: 0;
        }
    </style>

    <script>

    function sleep (time) {
      return new Promise((resolve) => setTimeout(resolve, time));
    }

    var current_question_index = 0;
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

    function setRandomQuestion() {
      current_question_index = Math.floor(Math.random() * questions.length);
      var question = questions[current_question_index];
      document.getElementById("question").innerHTML = question;
    }

    var all_answers = {
      "False": [
      	"Вы ошиблись :(",
      	"Нет, это не так :(",
    	"Подумайте еще...",
    	"Пока не то..."
          ],
      "True": [
      	"Правильно! :)",
      	"Верно!",
      	"Да, именно!",
      	"Вы правы! :)",
      	"Так держать!"
      ]
    };

    var last_true = false;

    function setup_question() {
      sleep(2000).then(() => {
        if (last_true) {
        	setRandomQuestion();
        } else {
      	var question = questions[current_question_index];
      	document.getElementById("question").innerHTML = question;
        }

        document.getElementById("answer_input").value = "";
      });
    }

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

            if (data.status === "True") {
                last_true = true;
            } else {
                last_true = false;
            }

            setup_question();
          },

          error: function(e) {
      	  document.getElementById("question").innerHTML = "<i>" + "Что-то пошло не так..." + "</i>";
              console.log(e);
              last_true = false;
              setup_question();
          }
      });

      return false;
    }

    </script>

</head>

<body>

    <div class="menu">
        <div class="column" onclick="setRandomQuestion()">Даты и события</div>
        <div class="column" onclick="setRandomQuestion()">Участники</div>
        <div class="column" onclick="setRandomQuestion()">Термины</div>
        <div class="column" onclick="setRandomQuestion()">Причины и следствия</div>
        <div class="column robot" onclick="setRandomQuestion()">Задать вопрос ;)</div>
    </div>


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
