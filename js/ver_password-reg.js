let eye = document.getElementById('eye');
let input = document.getElementById('password');
let eye1 = document.getElementById('eye1');
let input1 = document.getElementById('password1');

eye.addEventListener("click", function() {
    if (input.type == "password"){
        input.type = "text";
        eye.style.opacity=0.2;
    }else{
        input.type = "password";
        eye.style.opacity=0.8;
    }
})
eye1.addEventListener("click", function() {
    if (input1.type == "password"){
        input1.type = "text";
        eye1.style.opacity=0.2;
    }else{
        input1.type = "password";
        eye1.style.opacity=0.8;
    }
})