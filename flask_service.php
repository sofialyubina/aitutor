<?php

    header('Content-type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);
    #file_put_contents("input.json", json_encode($data));

    if ($data["endpoint"] == "get_random_task") {
        $cmnd = "curl -d task_type=". $data["task_type"] . " -G http://localhost:5000/get_random_task";
        exec($cmnd, $output, $return_var);

    } else if ($data["endpoint"] == "score_task") {
        $cmnd = "curl -G http://localhost:5000/score_task";

        file_put_contents("input.json", json_encode($data));
        #file_put_contents("input.json", $cmnd);
        exec($cmnd, $output, $return_var);
    }

    $answer = json_decode($output[0]);
    echo json_encode($answer);
?>

