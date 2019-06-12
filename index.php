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

    var questions = ["hello"];
    var current_question_index = 0;

    var current_task = null;
    var asked_type = "date"

    function setRandomQuestion() {
        $.ajax({
            url: "flask_service.php",
            type: "POST",

            data: JSON.stringify({
                "endpoint": "get_random_task",
                "task_type": asked_type,
            }),

            contentType: "application/json",

            success: function(data) {
                console.log(data)
                current_task = data.task;
      	        document.getElementById("question").innerHTML = current_task.question;
            },

            error: function(e) {
                console.log(e);
            }
        });
    }

    function setRandomDateEventQuestion() {
        if (Math.random() >= 0.5) {
            asked_type = "date";
            setRandomQuestion();
        } else {
            asked_type = "event";
            setRandomQuestion();
        }
    }

    function setRandomPersonQuestion() {
        asked_type = "person";
        setRandomQuestion();
    }

    function setRandomTermQuestion() {
        asked_type = "term";
        setRandomQuestion();
    }

    function setRandomReasonResultQuestion() {
        if (Math.random() >= 0.5) {
            asked_type = "reason";
            setRandomQuestion();
        } else {
            asked_type = "result";
            setRandomQuestion();
        }
    }

    var all_answers = {
      false: [
      	"Вы ошиблись :(",
      	"Нет, это не так :(",
    	"Подумайте еще...",
    	"Пока не то..."
      ],

      true: [
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
      	    document.getElementById("question").innerHTML = current_task.question;
        }

        document.getElementById("answer_input").value = "";

      });
    }

    function validateForm() {
        $.ajax({
            url: "flask_service.php",
            type: "POST",

            data: JSON.stringify({
                "endpoint": "score_task",
                "task_type": current_task["type"],
                "task_id": current_task["id"],
                "answer": document.getElementById("answer_input").value
            }),

            contentType: "application/json",

            success: function(data) {
                console.log(data)

                var answers = all_answers[data.answer.score]
      	        var answer = answers[Math.floor(Math.random() * answers.length)];
      	        document.getElementById("question").innerHTML = "<i>" + answer + "</i>";

                if (data.answer.score) {
                    last_true = true;
                } else {
                    last_true = false;
                }

                setup_question();
            },

            error: function(e) {
                console.log(e);
      	        document.getElementById("question").innerHTML = "<i>" + "Что-то пошло не так..." + "</i>";
                last_true = false;
                //setup_question();
            }
        });

      return false;
    }

    var record_started = false;

    var record_img = "https://cdn0.iconfinder.com/data/icons/buntu-media-2/100/built-in_microphone_glyph_convert-512.png";
    var record_started_img = "https://www.nestigator.com/assets/property_loading_v3-bcc913d33efd9e44f1496d86b19f8153a190230d09bca1e158b90e80a50d99e6.gif";

	var recognizer = new webkitSpeechRecognition();
	recognizer.lang = 'ru-Ru';
	recognizer.onresult = function (event) {
	  var result = event.results[event.resultIndex];
	  if (result.isFinal) {
	    console.log('Вы сказали: ' + result[0].transcript);
    	document.getElementById("answer_input").value = result[0].transcript;

	    recognizer.stop();
	    console.log("Recording stopped");
    	document.getElementById("record_img").src = record_img;
        record_started = false;
	  } else {
	    console.log('Промежуточный результат: ', result[0].transcript);
	  }
	};


	function startrecord() {
        if (record_started) {
	        recognizer.stop();
	        console.log("Recording stopped");
    	    document.getElementById("record_img").src = "https://cdn0.iconfinder.com/data/icons/buntu-media-2/100/built-in_microphone_glyph_convert-512.png";
            record_started = false;
        } else {
            document.getElementById("record_img").src = record_started_img;
            record_started = true;
	        console.log("Recording started");
		    recognizer.start();
        }
	}


    </script>

</head>

<body>

    <div class="menu">
        <div class="column" onclick="setRandomDateEventQuestion()">Даты и события</div>
        <div class="column" onclick="setRandomPersonQuestion()">Участники</div>
        <div class="column" onclick="setRandomTermQuestion()">Термины</div>
        <div class="column" onclick="setRandomReasonResultQuestion()">Причины и следствия</div>
        <div class="column robot" onclick="">Задать вопрос ;)</div>
    </div>


    <div class="content">
    <div class="wrapper">
    <div id="question" class="question">
    </div>

    <div class="answer">
    <form action="" method="post"  onsubmit="return validateForm()" >
    <input autocomplete="off" id="answer_input" type="text"> </input>
    <button type="button" onclick="startrecord()" class="record_button" ><img id="record_img" src="https://cdn0.iconfinder.com/data/icons/buntu-media-2/100/built-in_microphone_glyph_convert-512.png" width="20"/></button>
    <input type="submit" hidden>
    </form>
    </div>

    <div id="mark" class="mark">
    </div>

    </div>
    </div>

    <script>
    setRandomDateEventQuestion();
    </script>

</body>
</html>
