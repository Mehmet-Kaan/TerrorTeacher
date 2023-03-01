"use strict!";

let signInForm = document.forms["login-form"];
let signUpForm = document.forms["signUp-form"];

function sendLogInForm() {
    signInForm.submit();
}

function sendSignUp() {
    signUpForm.submit();
}

function showSignUp() {
    document.getElementById("signInForm").classList.add("noOpacity");
  
    setTimeout(() => {
        document.getElementById("signInForm").classList.add("hide");
        document.getElementById("signUpForm").classList.remove("hide");

        setTimeout(() => {
            document.getElementById("signUpForm").classList.remove("noOpacity");
        }, 100);

    }, 300);
   
}

function showSignIn() {
    document.getElementById("signUpForm").classList.add("noOpacity");
  
    setTimeout(() => {
        document.getElementById("signUpForm").classList.add("hide");
        document.getElementById("signInForm").classList.remove("hide");

        setTimeout(() => {
            document.getElementById("signInForm").classList.remove("noOpacity");
        }, 100);


    }, 300);
}


setInterval(() => {
    let allErrorP = document.querySelectorAll(".error");

    allErrorP.forEach(pElement => {
        pElement.remove();
    });
}, 1300);

