<?php
include_once('./php/connection.php');

session_start(); // Start the session
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['pwdrst'])) {
    // Retrieve user input
    $email = $_POST['email'];

    // Check if a cooldown period is in effect
    if (isset($_SESSION['cooldown']) && time() - $_SESSION['cooldown'] < 30) {
        $msg = "Please wait for 30 seconds before requesting another password reset link.";
    } else {
        // Check if the email exists in the database
        $check_email_query = "SELECT * FROM student WHERE email = ?";
        $stmt = $connection->prepare($check_email_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(16)); // You can customize the token length

            // Update the expiration timestamp of existing tokens for the same email
            $update_token_query = "UPDATE password_reset_tokens SET expiration_timestamp = ? WHERE email = ?";
            $update_token_stmt = $connection->prepare($update_token_query);
            $new_expiration_timestamp = time(); // Expire existing tokens immediately
            $update_token_stmt->bind_param("ss", $new_expiration_timestamp, $email);
            $update_token_stmt->execute();
            $update_token_stmt->close();

            // Store the new token in the database
            $store_token_query = "INSERT INTO password_reset_tokens (email, token, expiration_timestamp) VALUES (?, ?, ?)";
            $expiration_timestamp = time() + 3600; // Token expires in 1 hour
            $store_token_stmt = $connection->prepare($store_token_query);
            $store_token_stmt->bind_param("sss", $email, $token, $expiration_timestamp);
            $store_token_stmt->execute();

            if ($store_token_stmt->affected_rows > 0) {
                // Your API endpoint
                $api_url = 'https://dev.smsuno.clairemontferrond.net/api/send-email';

                // Your API key
                $apikey = '83c78aff719a3s2d6';

                // Prepare data for the API request
                $api_data = [
                    'apikey' => $apikey,
                    'to' => $email,
                    'subject' => 'Password Reset ' . $token,
                    'message' => 'Here is the link for password reset http://http://qcafs.000.pe/passwordreset.php?token=' . $token,
                    // Add other parameters if needed (cc, bcc, attachment, etc.)
                ];

                // Initialize cURL session
                $ch = curl_init($api_url);

                // Set cURL options
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $api_data);

                // Execute cURL session and get the API response
                $api_response = curl_exec($ch);

                // Close cURL session
                curl_close($ch);

                // Check if API response is in JSON format
                $result = json_decode($api_response, true);

                if(!$result){
                    error_log("Failed to send the password reset link. Debug: " . $api_response);
                    $msg = "Failed to send the password reset link. Please try again later.";
                }else{
                    $msg = "Password reset link sent successfully. Check your email for the reset instructions.";
                    $_SESSION['cooldown'] = time();
                }
                
            } else {
                $msg = "Failed to store password reset token. Please try again later.";
            }

            $store_token_stmt->close();
        } else {
            $msg = "Email not found in the database. Please provide a valid email.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        <div class="container mt-5 shadow-lg d-flex flex-column align-items-center" style="height: auto; max-width: 1000px;">
            <div class="container  mt-5 mb-5">
                <h4 class="fw-bold">FORGOT PASSWORD</h4>
                <form id="validate_form" method="post">
                    <label style="color:gray;" for="email" class="fw-bold mb-2 mt-4">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text border-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at-fill" viewBox="0 0 16 16">
                            <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671"/>
                            <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791"/>
                            </svg>
                        </span>
                        <input type="text" name="email" id="email" placeholder="Enter Email" required data-parsley-type="email" data-parsley-trigger="keyup" class="form-control" />
                         
                    </div>
<p class="error"><?php if(!empty($msg)) { echo $msg; } ?></p>
                    <div class="container d-flex justify-content-center p-4 mt-5">
                        <input type="submit" id="login" name="pwdrst" value="Send Password Reset Link" class="btn btn-success mt-5" />
                    </div>
                    <div class="container d-flex justify-content-center ">
                    <p >Back to <a class="fw-bold" href="index.php">Login</a></p>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
