<?php

    header('Content-type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);

    file_put_contents("input.json", json_encode($data));

    $cmnd = "python3 service.py input.json";
    exec($cmnd, $output, $return_var);

    $answer = json_decode($output[0]);
    echo json_encode($answer);
?>

