let eye = document.getElementById('eye');
let input = document.getElementById('password');

eye.addEventListener("click", function() {
    if (input.type == "password"){
        input.type = "text";
        eye.style.opacity=0.2;
    }else{
        input.type = "password";
        eye.style.opacity=0.8;
    }
})