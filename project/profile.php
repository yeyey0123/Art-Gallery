<?php
session_start(); 
$id = $_SESSION['id'];


// Check if the user is not logged in (session variable is not set)
if (!isset($_SESSION['name'])) {
    // Redirect the user back to the login page or perform any other action
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];


include 'connect1.php'; 

$sql = "SELECT * FROM userlist WHERE id = $id";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userImage = $row['image'];
    $name=$row['name'];
    $artistname=$row['artistname'];
    $email=$row['email'];
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f4a69556b5.js" crossorigin="anonymous"></script> 

    <style>
        body {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
.container-fluid {
    background: #393646;
    color: white;
    
}

.profile-image img {
    height: 200px; /* Fixed height */
    width: 200px; /* Fixed width */
    object-fit: cover; /* Zoom and crop to fit the container */
    object-position: center; /* Center the image within the container */
    border-radius: 100%;
    border:2px solid;
    border-color: #EEEEEE;
}
.profile-image img:hover {
    transform: scale(102%)
}
.username{
    font-size: 40px;
    font-weight: 700;
}
.nav a{
    text-decoration: none;
    color: white;
    position: relative;
}

.nav h3{
    font-size: 15px;
}
.nav a::after{
    content: '';
    width: 0;
    height: 3px;
    background: #EEEEEE;
    position: absolute;
    left: 0;
    bottom: -6px;
    transition: 0.5s;
}
.nav a:hover::after{
     width:100%;
}
.nav .dropdown a:hover::after{
     width:0%;
}


.home{
    background-color: #EEEEEE;
    color: #393646;
}

.artwork img {
    height: 100%;
    width: 100%;
    object-fit: cover; /* Zoom and crop the image to fit the container */
    object-position: center; /* Center the image within the container */
              
}

.artwork {
    position: relative;
    border-radius: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    width: 370px;
    height: 370px;
}
.artwork h3{
    font-size: 30px;
    font-weight:800;
}
.artwork p{
    font-size: 12px;
    padding-bottom:20px;
    color: #EEEEEE;
}
.artwork a{
    text-decoration: none;
    padding-top: 30px;
    color: #EEEEEE;
}
.description {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 0;
    background: linear-gradient(rgba(0,0.1,0.3,0.7), #4F4557);;
    color: #EEEEEE;
    overflow: hidden;
    transition: height 0.5s;
    border-radius: 30px;
    
}
.artwork:hover .description {
    height: 370px;
}  
.artwork:hover{
    transform: scale(1.1);
}


.row i{
    color: #393646;
}
.social-icon{
    margin-top: 1px;
}
.social-icon a{
    text-decoration: none;
    font-size: 32px;
    margin-right: 8px;
    color:#ababab;
    display: inline-block;
    transition: transform 0.5s;
}
.social-icon a:hover{
    color: #004AAD;
    transform: translateY(-5px);
}
p i{
    font-size: 23px;
}
.contactus p{
    font-size: 18px;
    color: #393646;
    font-weight: 700;
}
.contact-left{
    flex-basis: 35%;
}
.contact-right{
    flex-basis: 60%;
}
.contact-right form{
    width: 100%;
}
form input, form textarea{
    width: 100%;
    background: #F1F6F9;
    border: none;
    padding: 10px;
    margin: 10px 0;
    color:#393646;
    font-size: 18px;
    border-radius: 6px;
}
.btn1{
    border: none;
    background-color: #4F4557;
    border-radius: 8px;
    height: 40px;
    width: 120px;
    color: #EEEEEE;
    margin-top: 8px;
}
.btn1:hover{
    background: #393646;
}
.dropdown-menu a {
color: #393646;
}
.adds a{
    text-decoration: none;
    color: #393646;
    border:1px solid;
    padding-top: 2px;
    padding-bottom: 2px;
    padding-left: 5px;
    padding-right: 5px;
    border-radius: 5px;
    border-color: #393646;
    font-size: 14px;
}
.adds a:hover{
    background-color: #4F4557;
    color: #EEEEEE;
}
    </style>
</head>
<body>
<div class="container-fluid">
        <div class="container">
        <div class="profile-info d-flex align-items-end pt-4 pb-3">
                <?php 
                 if (isset($userImage)) {
                     echo '<div class="profile-image"><img src="upload/' . $userImage . '" alt="Profile Image"></div>';
                 }
                ?>
                <div class="username d-flex "><?php echo $name?> </div>
              
        </div>
        <hr>

        <div class="nav d-flex justify-content-center flex-wrap gap-5 pb-2">
            <h3><a href="#home">HOME</a></h3>
            <h3><a href="#gallery">ARTWORK</a></h3>
            <h3><a href="#contact">CONTACT</a></h3>
            
    <div class="dropdown">
        <h3 class="dropdown-toggle" id="settingsDropdown" onclick="toggleDropdown()" aria-expanded="false">
        </h3>
        <ul class="dropdown-menu" id="settingsMenu">
            <?php if ($id === 1){
            echo '<li><a class="dropdown-item" href="list.php">Accounts List</a></li>';} ?>
            <li><a class="dropdown-item" href="update1.php?updateid=<?php echo $id; ?>">Change info</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        
        </ul>
    </div>
</div>
        </div>
    
    </div>
    <div class="home" id="home">
        <div class="container">
            <div class="About">
            <h1 class="pt-5"><?php echo $artistname?></h1>

            <h2 class="mx-5 my-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore, nemo!</h2>
            <div class="py-4"><hr></div>
        </div>

        <div class="Gallery" id="gallery">
        <h1 class="pt-3">ARTWORK</h1>
        <div class="adds py-3 d-flex justify-content-end"><a href="posting.php">ADD</a></div>
        
 <?php
    $sql = "SELECT * FROM `gallery`";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $galleryData = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $galleryData[] = $row;
        }

        // Set the number of pictures to display initially and the number to load each time
        $initialDisplay = 3;
        $loadMoreStep = 3;
        $remainingPictures = count($galleryData) - $initialDisplay;

        echo '<div class="artwork-list row row-cols-md-3 g-4" id="artwork-list">'; // Add "row" class and "row-cols-md-3" class for Bootstrap grid
        for ($i = 0; $i < min($initialDisplay, count($galleryData)); $i++) {
            $id = $galleryData[$i]['id'];
            $title = $galleryData[$i]['title'];
            $about = $galleryData[$i]['about'];
            $picture = $galleryData[$i]['picture'];

            echo '<div class="col-md-4 mb-4 d-flex justify-content-center align-items-center">'; // Add "col-md-4" class for Bootstrap grid and centering classes
            echo '<div class="artwork position-relative overflow-hidden">';
            echo '<img src="posting/ ' . $picture . '" alt="Artwork">';
            echo '<div class="description">';
            echo '<h3>' . $title . '</h3>';
            echo '<p>' . $about . '</p>';
            echo '<a href="delete1.php?deleteid=' . $id . '" class="text-white">Delete</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>'; // Close the artwork-list container

        if ($remainingPictures > 0) {
            echo '<div class="container">';
            echo '<div class="d-flex justify-content-center pb-4">';
            echo '<button type="button" class="btn btn-outline-dark" id="load-more">See More</button>';
            echo '<button type="button" class="btn btn-outline-dark" id="show-less">Show less</button>';
            echo '</div>';
            echo '</div>';
        }
    }  
    ?>
    </div>
    <div class="pb-4"></div>

    <div id="contact" class="pt-5">
            <div class="row">
                <div class="contact-left">
                    <h1 class="Sub-title pb-2">Contact Me</h1>
                    <div class="contactus">
                    <p><i class="fa-solid fa-paper-plane"></i> <?php echo $email  ?></p>
                    <p><i class="fa-solid fa-phone"></i> 0912312323</p>
                    </div>
                    <div class="social-icon mb-2">
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter-square"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                    <div class="">
                        <button type="submit" class="btn1" name="submit" style="height: 43px;">Download CV</button></div>
                        
                </div>
                <div class="contact-right">
                    <form>
                        <input type="text" name="Name" placeholder="Your Name" required>
                        <input type="email" name="email" placeholder="Your Email" required>
                        <textarea name="message"  rows="6" placeholder="Your Message"></textarea>
                        <button type="submit" class="btn1" name="submit" style="width:100px;">Submit</button>
                    </form> 
                </div>
            </div>
            </div>
    </div>

 

        <div class="container-fluid d-flex justify-content-center mt-5">
            <div class="message py-4">
                Thanks for Visiting
            </div>
        </div>
    </div>





    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const artworkList = document.getElementById("artwork-list");
        const loadMoreButton = document.getElementById("load-more");
        const showLessButton = document.getElementById("show-less");

        let displayCount = <?php echo $initialDisplay; ?>;
        const galleryData = <?php echo json_encode($galleryData); ?>;
        const remainingPictures = <?php echo $remainingPictures; ?>;
        const loadMoreStep = <?php echo $loadMoreStep; ?>;
        const originalGalleryContent = artworkList.innerHTML; // Store the original gallery content
        showLessButton.style.display = "none";

        function updateGalleryDisplay() {
            for (let i = displayCount; i < displayCount + loadMoreStep && i < galleryData.length; i++) {
                const item = galleryData[i];
                const html = `
                    <div class="list col-md-4 mb-4 d-flex justify-content-center align-items-center">
                        <div class="artwork position-relative overflow-hidden">
                            <img src="posting/ ${item.picture}" alt="Artwork">
                            <div class="description">
                                <h3>${item.title}</h3>
                                <p>${item.about}</p>
                                <a href="delete1.php?deleteid=${item.id}" class="text-white">Delete</a>
                            </div>
                        </div>
                    </div>
                `;

                artworkList.innerHTML += html;
            }

            displayCount += loadMoreStep;
            if (displayCount >= galleryData.length) {
                loadMoreButton.style.display = "none";
                showLessButton.style.display = "inline-block";
            }
        }

        function showOriginalGallery() {
            artworkList.innerHTML = originalGalleryContent;
            displayCount = <?php echo $initialDisplay; ?>; // Reset displayCount to the initial display count
            loadMoreButton.style.display = (remainingPictures > 0) ? "inline-block" : "none";
            showLessButton.style.display = "none";
        }

        loadMoreButton.addEventListener("click", updateGalleryDisplay);

        // Initially, check if all data is already displayed and hide the "See More" button
        if (remainingPictures === 0) {
            loadMoreButton.style.display = "none";
        }

        showLessButton.addEventListener("click", showOriginalGallery);

    });

    function toggleDropdown() {
        const menu = document.getElementById("settingsMenu");
        menu.classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-toggle')) {
            const menus = document.getElementsByClassName("dropdown-menu");
            for (let i = 0; i < menus.length; i++) {
                const menu = menus[i];
                if (menu.classList.contains('show')) {
                    menu.classList.remove('show');
                }
            }
        }
    };
</script>

</body>
</html>

   
