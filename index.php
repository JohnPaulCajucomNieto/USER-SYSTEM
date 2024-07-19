<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/qcafs.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.25.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Blinker:wght@200;400;600&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Login</title>
    <style>
        body {
            padding: 0;
            margin: 0;
            background-color: #eee;
            font-family: "Poppins", sans-serif;
            font-weight: 300;
        }

        button:hover {
            opacity: 0.9;
        }

        .input-group-text {
            padding: 0.6rem; 
        }

        .input-group input {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        @media (max-width:700px ) {
           h5{
            font-size:15px;
           }
        
    }
    
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div style="box-shadow: 0px 0px 10px 0px; background-color:white; border-radius: 5px;" class="col-10 col-md-5 text-center mt-4 mb-5 p-3 pt-1">
                <img class="small-img img-fluid col-6 mt-3 " src="./img/qcafs.png" alt="">
                <h5  style="text-align: center; font-family: 'Blinker', sans-serif; font-size:25px;" class="fw-bold  mb-4">QR Code-Based Attendance for Field Study</h5>
                <form action="./php/login.php" method="POST">
                    <input type="hidden" name="_token">
                    <div class="mb-3 col-md-10 mx-auto">
                        <div class="container1 text-start">
                            <label for="floatingInput" class="form-label fw-bold mb-2">Username</label>
                            <div class="input-group">
                                <span class="input-group-text border-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-md-10 mx-auto">
                    <div class="container1 text-start">
    <label for="floatingPassword" class="form-label fw-bold mb-2">Password</label>
    <div class="input-group">
        <span class="input-group-text border-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
            </svg>
        </span>
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="" required>
        
    </div>
    <div class="container1 d-flex justify-content-between align-items-center fst-italic" style="font-size: 14px; color: gray;">
   
           <div class="row mt-2">
           <label class="form-check-label" for="togglePassword">
                <input class="form-check-input" type="checkbox" id="togglePassword"> Show Password
            </label>
            
            <label class="form-check-label" for="rememberMe">
                <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe"> Remember Me
            </label>
           </div>


        
    </div>
</div>
                        <button class="mt-2  btn btn-primary" style="width: 30%; border-radius: 10px;" type="submit">Log in</button>
                        <p class=""><a href='forgot.php'>Forgot Password?</a></p>
                        <p>Don't have an account? <span style="text-decoration: underline; color: #00004B;"><a href="./php/sign-up.php">Register</a></span></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let rememberMeCheckbox = document.getElementById("rememberMe");
            let usernameInput = document.getElementById("floatingInput");
            let passwordInput = document.getElementById("floatingPassword");
      
            if (localStorage.getItem("rememberMeChecked") === "true") {
                rememberMeCheckbox.checked = true;
    
                if (localStorage.getItem("savedUsername")) {
                    usernameInput.value = localStorage.getItem("savedUsername");
                }
            }
            rememberMeCheckbox.addEventListener("change", function() {
                if (rememberMeCheckbox.checked) {
                    localStorage.setItem("rememberMeChecked", "true");
                    localStorage.setItem("savedUsername", usernameInput.value);
                } else {
                    localStorage.removeItem("rememberMeChecked");
                    localStorage.removeItem("savedUsername");
                }
            });
        });
    </script>
   <script>
    var passwordInput = document.getElementById('floatingPassword');
    var toggleCheckbox = document.getElementById('togglePassword');

    toggleCheckbox.addEventListener('change', function() {
        passwordInput.type = toggleCheckbox.checked ? 'text' : 'password';
    });
</script>
</body>
</html>

