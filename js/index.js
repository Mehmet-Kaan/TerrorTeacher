"use strict!";

let giveMeNameButton = document.getElementById("giveMeName");
let updateButton = document.getElementById("updateList");
let logoutButton = document.getElementById("logout");

giveMeNameButton.addEventListener("click", (e)=>{
   location.href = "index.php?getRandomName=true";
});

updateButton.addEventListener("click", (e)=>{
   location.href = "index.php?updateList=true";
});

logoutButton.addEventListener("click", (e)=>{
   location.href = "logout.php";
});
