<?php
session_start();
require_once "Controllers/Database.php";
require_once "Controllers/Functions.php";

$db = new Database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yuson Group of Companies</title>
    <!--image is taken in img outside of asset-->
    <link rel="icon" href="./Assets/img/brand_logo/YUSON GOC Logo.png" />


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
     <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="./style.css">
    

    <script src="https://kit.fontawesome.com/6dd170a24a.js" crossorigin="anonymous"></script>
    
</head>

<body>
      <!--Navigation Bar-->
    <nav id="main-nav" class="bg-dark-header">
        <input type="checkbox" id="main-nav-check-box"/>
        <div id="main-nav-label">
            <img id="nav-bar-img" src="./Assets/img/brand_logo/YUSON GOC Logo.png" alt="WSAP">
            <!-- <label></br>Yuson Group of Companies</label> -->

        </div>

        <input type="checkbox" id="main-nav-check-box" />

        <div id="main-nav-label"></div>

        <label for="main-nav-check-box" class="check-button">
            <i class="material-icons">menu</i>
        </label>
        <ul>
            <li><a href="#about-us"><span>About us</span></a></li>
            <li><a href="#mission"><span>Mission</span></a></li>
            <li><a href="#vision"><span>Vision</span></a></li>
            <li><a href="#corevalues"><span>Core Values</span></a></li>
            <li><a href="#brands"><span>Brands</span></a></li>
        </ul>
    </nav>


<section id="about-us">
    <div class="text">
         <p><b>Yuson Group of Companies</b>, YGC is an organization dedicated to controlling and operating subsidiaries under WSAP Inc., founded by <b>Mr. TJ Yuson</b>.</p>
         <a href="https://www.tjyuson.com/" target="_blank" style="text-decoration:none"><button type="button">About Founder</button>
      </a></div>
    <div class="logo-img">
        <img src="./img/yuson.png" >
    </div>
</section>
        
    <section id="mission">
        <div class="container">
            <div class="content">
            <h1 class="text-gradient">Mission</h1>
            <br>
            <img src="./img/Mission.png" alt="" class="mission">
             <p>Anchored on our core values of reliability, integrity, commitment, and excellence. Yuson Group of Companies is committed to national growth catering a wide range of services all throughout the Philippines through its multiple subsidiaries across different industries.</p>
        </div>
    </div>
        
    </section>

    <section id="vision">
        <div class="container">
        <div class="content">
            <h1 class="text-gradient">Vision</h1>
            <br>
            <img src="./img/vision.png" alt="" class="vision">
            <p>Our vision is to be a well-known holding company providing professional opportunities for clients and quality customer service, both locally and internationally. </p>
        </div>
    </div>
        
    </section>



    <section id="corevalues" style="background-color: white;">
        <div class="row equal">
        <h1 style="color: black; padding-bottom: 20px;" class ="text-gradient">Core Values</h1>
        <div class="col-xl-4 col-lg-6 cursor-pointer" >
        <div class="card card-link overflow-hidden text-white h-50" style="background: white ;border-left: #D4AF37  solid 8px;">
        <div class="card-statistic-3 p-4 h-100">
        <div class="d-flex justify-content-between flex-column h-100">
            <h2 class=" mb-0, text-gradient" style="color: black; float: center;"> Integrity </h2>
            <p class="fs-b" style="color: black;"> We value the morals and principles each company that Yuson Group of Companies represents. </p>
        </div>
        </div>
        </div>
        </div>

        <div class="col-xl-4 col-lg-6 cursor-pointer" >
        <div class="card card-link overflow-hidden text-white h-50" style="background: white ;border-left: #D4AF37  solid 8px;">
        <div class="card-statistic-3 p-4 h-100">
        <div class="d-flex justify-content-between flex-column h-100">
            <h2 class="mb-0, text-gradient" style="color: black; float: center;"> Commitment </h2>
            <p class="fs-b" style="color: black;">
                <class="tab">Our actions uphold the promises and agreements of the company to our clients
                and stakeholders. Keeping our word is of utmost importance.
            </p>
        </div>
        </div>
        </div>
        </div>

        <div class="col-xl-4 col-lg-6 cursor-pointer" >
        <div class="card card-link overflow-hidden text-white h-50" style="background: white ;border-left: #D4AF37  solid 8px;">
        <div class="card-statistic-3 p-4 h-100">
        <div class="d-flex justify-content-between flex-column h-100">
            <h2 class="mb-0, text-gradient" style="color: black; float: center;"> Excellence </h2>
            <p class="fs-b" style="color: black;">
                <class="tab">We ensure quality in everything we do. The clients always deserve the best 
                there is.
            </p>
        </div>
        </div>
        </div>
        </div>
        </div>
    </section>


 
    <section id="brands">
        <h1>Brands</h1>
        <div class="brands-container"></div>
    </section>


    
    <footer class="bg-dark text-accent">
        <div class="left-side">
        <a button type="button"  onclick="window.location.href = 'index_login.php';"> 
            <img  src="./Assets/img/Logo_white.png" alt="WSAP">
        </a>
        </button>
         </div>
        <div class="middle">
            <ul>
                <h2>Official Info:</h2>
              
                </li>
                    <li>
                    <i class="fa-solid fa-location-dot"></i>
                        79 Magsaysay, Bacoor, Cavite
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        +63 926 662 9900
                    </li>
            </ul>
        </div>
        <div class="right-side">
              <h2>Follow Us:</h2>
            <ul>
              <li>
                  <a target="_blank" href="https://www.facebook.com/yusongroupofcompanies">
                    <i class="fa-brands fa-facebook"></i>
                 </a></li>
            <li><a href="#">
                <i class="fa-brands fa-instagram"></i>
            </a></li>
            <li><a href="#">
                <i class="fa-brands fa-twitter"></i>
            </a></li>
            <li><a href="#">
                <i class="fa-brands fa-youtube"></i>
            </a></li>
        </ul>
        </div>
        <h4>Yuson Group of Companies © 2022</h4>
    </footer>

    <button class="up-btn">
        <i class="fa-solid fa-chevron-up"></i>
    </button>


    <script src="script.js"></script>
</body>

</html>