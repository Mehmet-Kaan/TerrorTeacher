<?php
session_start();

function checkTheUser($users, $username, $password){
    foreach($users as $user){
        if(strtolower($user["username"]) == $username && strtolower($user["password"]) == $password){
            $_SESSION["inLoggedUser"] = $user;
            return true;
        } 
    }
    return false;
}

if(isset($_SESSION["isLoggedIn"])){
    header("Location: index.php");
    exit();
}

require_once "server/phpfiles/functions.php";

$data = loadJson("server/json/teachers.json");
$teachers = $data["teachers"];

if(isset($_GET["login"])){
    if (isset($_POST["username"], $_POST["password"])) {
        $username = strtolower($_POST["username"]);
        $password = strtolower($_POST["password"]);

        if(empty($username) || empty($password)){
            header("Location: login.php?error=filltheboth");
            exit();
        } else{
            if(checkTheUser($teachers, $username, $password)){
                $_SESSION["isLoggedIn"] = true;
                header("Location: index.php");
                exit();
            }else{
                header("Location: login.php?error=wrongUsernameorPassword");
                exit();
            }
        }
    }
}

function createNewUser($username, $password)
{
    $data = loadJson("server/json/teachers.json");
    $teachers = $data["teachers"];

    $usernameTaken = false;

    foreach($teachers as $user) {
        if($user["username"] == $username) {
            $usernameTaken = true;
        }
    }
  
    if($usernameTaken == false){        

        //Creating a user
        $newTeacher = [
            "username" => $username,
            "password" => $password,
            "namesPool" => [
                "Anna",
                "Mehmet",
                "Alexander",
                "Liam",
                "My",
                "Matilda",
                "Melinda",
                "Caspian"
            ]
        ];

        //Creating an ID for the new user
        $highestId = 0;
        foreach($teachers as $user) {
            if($user["id"] > $highestId) {
                $highestId = $user["id"];
            }
        }
        $newTeacher["id"] = $highestId + 1;

        //Saving the new user
        array_push($teachers, $newTeacher);

        $data["teachers"] = $teachers;
        saveJson("server/json/teachers.json", $data);

        $_SESSION["userCreated"] = $newTeacher;

        return true;
    }
    else{
        return false;
    }
}

if(isset($_GET["newUser"])){
    if (isset($_POST["newTeacher"], $_POST["newPassword"])) {
        $username = strtolower($_POST["newTeacher"]);
        $password = strtolower($_POST["newPassword"]);

        if(empty($username) || empty($password)){
            header("Location: login.php?error=filltheboth");
            exit();
        } else{
            
            if(createNewUser($username, $password)){
                header("Location: login.php?userCreated=true");
                exit();
            }else{
                header("Location: login.php?error=usernameAlreadyTaken");
                exit();
            }
        }
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Log In</title>
</head>
<body>
    <?php
        echo '
        <div id="title">
            <h1> <span>T</span>error <span>T</span>eacher</h1>
        </div>
        <main>

            <div class="forms"> 
            <div id="signInForm" class="form">
                <h2>Sign in!</h2>';    
    ?>  
            
        <?php
            if(isset($_GET["error"])){
                $error = $_GET["error"];

                if($error == "filltheboth"){
                    echo "<p class='error'>Fill both!!</p>";
                }

                if($error == "usernameAlreadyTaken"){
                    echo "<p class='error'>Name already taken!</p>";
                }

                if($error == "wrongUsernameorPassword"){
                    echo "<p class='error'> Wrong username or password!!</p>";
                }
            }

            if(isset($_GET["userCreated"])){
                if($_SESSION["userCreated"] != ""){
                    echo "<p class='error'>User created!</p>";
                    $_SESSION["userCreated"] = "";
                }else{
                    header("Location: login.php");
                    exit();
                }
                
            }

            echo'
                <form name="login-form" id="login-form" action="../login.php?login" method="POST">
                    <input type="text" id="username" name="username" placeholder="Terror Teacher">
                    <input type="password" id="password" name="password" placeholder="Pasword">
                    <div class="regularText">Don`t have an account?  <span onClick="showSignUp();">Sign Up!</span></div>
                    <div class="button" onClick=" sendLogInForm();">Sign in</div>
                </form>
            </div>
   
            <div id="signUpForm" class="form noOpacity hide">
                <h2>Sign Up!</h2>'; 
            ?>
                <?php 

                 if(isset($_GET["error"])){
                    $error = $_GET["error"];
    
                    if($error == "usernameAlreadyTaken"){
                        $pElement = "<p class='error'>Name already taken!</p>";
                        echo $pElement;
                    }
                }

                echo'
                <form name="signUp-form" id="signUp-form" action="../login.php?newUser" method="POST">
                <input type="text" id="newTeacher" name="newTeacher" placeholder="New Teacher">
                <input type="password" id="newPassword" name="newPassword" placeholder="Pasword">
                <div class="regularText">Already have an account?  <span onClick="showSignIn();">Sign In!</span></div>
                <div class="button" id="signUp" onClick="sendSignUp()">Sign Up</div>
                </form>
            </div>
        </div>
    </main>
    ';
    ?>
<script src="js/login.js"></script>
</body>
</html>