<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../IMG/cela-logo.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Loading</title>
    <style>
       html {
        height: 100%;
    }   
    body {
      
                font-family: "Poppins", sans-serif;
                font-weight: 300;
    }

.loader {
  position: absolute;
  top: calc(50% - 32px);
  left: calc(50% - 32px);
  width: 100px;
  height:100px;
  border-radius: 50%;
  perspective: 800px;
}

.inner {
  position: absolute;
  box-sizing: border-box;
  width: 100%;
  height: 100%;
  border-radius: 500%;  
}

.inner.one {
  left: 0%;
  top: 0%;
  animation: rotate-one 1s linear infinite;
  border-bottom: 10px solid #D6BC36;
}

.inner.two {
  right: 0%;
  top: 0%;
  animation: rotate-two 1s linear infinite;
  border-right: 10px solid #00004B;
}

.inner.three {
  right: 0%;
  bottom: 0%;
  animation: rotate-three 1s linear infinite;
  border-top: 10px solid #1A7B3B;
}

@keyframes rotate-one {
  0% {
    transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
  }
  100% {
    transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
  }
}

@keyframes rotate-two {
  0% {
    transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
  }
  100% {
    transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
  }
}

@keyframes rotate-three {
  0% {
    transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
  }
  100% {
    transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
  }
}
#loginSection {
            display: none;
        }
    </style>
    </head>
    <body>
        <div id="loginSection" class="loader">
            <div class="inner one"></div>
            <div class="inner two"></div>
            <div class="inner three"></div>
            
          </div>
          <script>

        setTimeout(function () {
            document.querySelector('.loader').style.display = 'none';
            document.getElementById('loginSection').style.display = 'block';
            setTimeout(function () {
                window.location.href = 'index.php';
            }, 1500);
        }, 500); 
    </script>
</body>
</html>
