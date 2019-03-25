<?php

    header('Content-type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);
    file_put_contents("input.txt", array($data["id"], "\n", $data["user_answer"], "\n"));

    $cmnd = "python3 history/main.py input.txt";
    exec($cmnd, $output, $return_var);

    $answer = array("status" => $output[0]);
    echo json_encode($answer);
?>

