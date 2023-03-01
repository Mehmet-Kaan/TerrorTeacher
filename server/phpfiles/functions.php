<?php

function loadJson($filename){
    $json = file_get_contents($filename);
    return json_decode($json, true);
};

function saveJson($filename, $data){
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
    return true;
};

// Skickar ut JSON till användaren
function sendJson($data, $statuscode = 200){
    header("Content-Type: application/json");
    http_response_code($statuscode);
    $json = json_encode($data);
    echo $json;
    die();
}

function getRandomName($inloggeduser, $lastChosenName){
    $poolOfNames = $inloggeduser["namesPool"];
    
    $randomName = $poolOfNames[rand( 0, (count($poolOfNames)-1) ) ];

    if($lastChosenName != null){
        while ($lastChosenName == $randomName) {
            $randomName = $poolOfNames[rand( 0, (count($poolOfNames)-1) ) ];
        }
    }
  
    return $randomName;
}

function getStudentPossibility($inloggeduser, $student){

    $counter = 0;

    $data = loadJson("server/json/teachers.json");
    $teachers = $data["teachers"];

    foreach ($teachers as $teacher) {
        if($teacher["id"] == $inloggeduser["id"]){

            foreach ($teacher["namesPool"] as $name) {
                if($name == $student["name"]){
                    $counter++;
                }
            }
            return round((($counter / count($teacher["namesPool"])) * 100), 2);
        }
    }  
}



?>
