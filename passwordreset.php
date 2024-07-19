<?php
include_once('./php/connection.php');
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $check_token_query = "SELECT * FROM password_reset_tokens WHERE token = ? AND expiration_timestamp > ?";
    $check_token_stmt = $connection->prepare($check_token_query);
    $current_timestamp = time();
    $check_token_stmt->bind_param("si", $token, $current_timestamp);
    $check_token_stmt->execute();
    $result = $check_token_stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, show the password reset form
        $token_row = $result->fetch_assoc(); // Fetch the token row
        $email = $token_row['email']; // Retrieve email from the token

        if (isset($_POST['reset_password'])) {
            // Retrieve user input
            $password = $_POST['pwd'];
            $confirm_password = $_POST['cpwd'];

            // Validate password and confirm password
            if ($password == $confirm_password) {
                // Update the student_password in the database without hashing
                $update_password_query = "UPDATE student SET student_password = ? WHERE email = ?";
                $update_stmt = $connection->prepare($update_password_query);
                $update_stmt->bind_param("ss", $password, $email);
                $update_stmt->execute();

                if ($update_stmt->affected_rows > 0) {
                    
                    echo '<script>';
        echo 'alert("Password reset successfully.");';
        echo 'window.location.href = "index.php";';
        echo '</script>';

                } else {
                    echo '<script>';
                    echo 'alert("Failed to update password. Please try again later.");';
                    echo 'window.location.href = "passwordreset.php";';
                    echo '</script>';
                    $msg = "";
                }

                $update_stmt->close();
            } else {
                echo '<script>';
                echo 'alert("Password and Confirm Password do not match.");';
                echo 'window.location.href = "passwordreset.php";';
                echo '</script>';
               
            }
        }
    } else {
        echo '<script>';
                echo 'alert("Link expired. Request new!");';
                echo 'window.location.href = "forgot.php";';
                echo '</script>';
      
    }

    $check_token_stmt->close();
}
?>

<html>  
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-e1ibtokeAnAqkPZdV/OnbuQ6vZuqN+tGIlC3B6L/xI8V5KwVRy/xBvQ+q6Or4Jx" crossorigin="anonymous"></script>
</head>
<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    .main-container {
        max-width: 1000px; 
        margin: 0 auto;
    }
    .containers{
        max-width: 1000px; 
        margin: 0 auto;
    }
    .btn-group {
        box-shadow: 1px 3px 3px 1px gray;
        margin-top: 20px;
    }

    .btn-group button {
        width: 100%;
    }

    @media (min-width: 576px) {
        .btn-group button {
            width: auto;
        }
        .container {
            max-width: 576px; 
        }
    }
    @media (min-width: 768px) {
        .container {
            max-width: 720px; 
        }
    }
    @media (min-width: 992px) {
        .container {
            max-width: 1020px; 
        }
    }
    
    .btn-group {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
        
    }

    .btn-group button {
        width: calc(50% - 5px); 
        box-sizing: border-box;
    }

    @media (min-width: 576px) {
        .btn-group button {
            width: calc(25% - 5px); 
        }
    }
  
</style>
<body>

<div class="container">
        <div class="container mt-5 shadow-lg d-flex flex-column align-items-center" style="height: 480px; max-width: 1000px;">
            <div class="container mt-5 mb-5">
                <h4 class="fw-bold">RESET PASSWORD</h4>
                <form id="validate_form" method="post">  
                    <input type="hidden" name="email" value="<?php echo $email; ?>"/>
                    <label style="color:gray;" for="floatingInput" class="fw-bold mb-2 mt-4">Password</label>
                    <div class="input-group">
                        <span class="input-group-text border-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5"/>
</svg>
                        </span>
                        <input type="password" name="pwd" id="pwd" placeholder="Enter Password" required data-parsley-type="pwd" data-parsley-trigger="keyup" class="form-control"/>
                    </div>
              
                    <label style="color:gray;" for="floatingInput" class="fw-bold mb-2 mt-4">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text border-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793z"/>
                            </svg>
                        </span>
                        <input type="password" name="cpwd" id="cpwd" placeholder="Enter Confirm Password" required data-parsley-type="cpwd" data-parsley-trigger="keyup" class="form-control"/>
                    </div> <div class="container d-flex justify-content-center p-2 mt-5">
                
                <input style="width:150px;" type="submit" id="login" name="reset_password" value="Reset Password" class="btn btn-success" />
            </div>

                </form>
            </div>
           
            <div class="container d-flex justify-content-center ">
                <p class="error"><?php if(!empty($msg)){ echo $msg; } ?></p>
                <p>Back to <a class="fw-bold" href="index.php">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
