<?php
    session_start();

    if(!isset($_SESSION["isLoggedIn"])){
        header("Location: login.php");
        exit();
    }

    $inloggedUser = $_SESSION["inLoggedUser"];
    $userId = $inloggedUser["id"];

    require_once "server/phpfiles/functions.php";

    $data = loadJson("server/json/students.json");
    $students = $data["students"]; 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terror Teacher</title>
</head>
<body>
    <div id="title">
        <h1> <span>T</span>error <span>T</span>eacher</h1>
    </div>

    <main>
        <div id="randomName">
            <?php

                if(isset($_GET["updateList"])){
                    if( $_SESSION["nameToAddList"] != ""){
                        $data = loadJson("server/json/teachers.json");
                        $teachers = $data["teachers"];

                        $randomName = $_SESSION["nameToAddList"];

                        foreach ($teachers as $index => $teacher) {
                            if($teacher["id"] == $userId){
                                $inlTeacher = $teacher;

                                foreach ($students as $student) {
                                    if($student["name"] != $randomName){
                                        array_push($inlTeacher["namesPool"], $student["name"]);
                                    }
                                }

                                $teacher["namesPool"] = $inlTeacher["namesPool"];
                                $teachers[$index] = $teacher;
                            }
                        }
                    
                        $data["teachers"] = $teachers;
                        saveJson("server/json/teachers.json" , $data);

                        $_SESSION["nameToAddList"] = "";

                        echo "List updated!";
                    }
                    else{
                        echo "List already updated!";
                    }
                } 

                if(isset($_GET["getRandomName"])){
                    $data = loadJson("server/json/teachers.json");
                    $teachers = $data["teachers"];

                    if(empty($_SESSION["lastChosenName"])){
                        $lastChosenName = "";
                    }else{
                        $lastChosenName = $_SESSION["lastChosenName"];
                    }

                    foreach ($teachers as $teacher) {
                        if($teacher["id"] == $userId){
                            $randomName = getRandomName($teacher, $lastChosenName);
                        }
                    }

                    $_SESSION["nameToAddList"] = $randomName;
                    $_SESSION["lastChosenName"] = $randomName;

                    echo $randomName;
                }  
            ?>
        </div>
       
        <div class="upButtons">
            <div id="giveMeName" class="button">Get name</div>
            <div id="updateList" class="button">Update list</div>
        </div>
        
        <h3>Possibility of getting ...</h3>
        <div id="students">
            <?php               
                foreach ($students as $student) {
                    echo '
                        <div class="studentInfo">'. 
                            '<li>'. $student["name"] . '</li>'.
                            '<li>'. getStudentPossibility($inloggedUser, $student) . ' %</li>'.
                        '</div>
                    ';
                }
            ?>
        </div>
    </main>
    <div id="logout" class="button last">Log out</div>
    <script src="js/index.js"></script>
</body>
</html>