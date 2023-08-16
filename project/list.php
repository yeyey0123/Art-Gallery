  <?php
  include 'connect1.php';
  session_start();

  if (!isset($_SESSION['id'])) {
    // Redirect the user back to the login page or perform any other action
    header("Location: login.php");
    exit();
}
$id = $_SESSION['id'];

if ($_SESSION['id'] !== 1) {
  // Redirect the user to another page or display an error message
  header("Location: unauthorized.php");
  exit();
}
  ?>
  



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gallery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
    crossorigin="anonymous">
  <style>
    .body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .container {
      background: whitesmoke;
      border-radius: 30px;
    }

    a {
      text-decoration: none;
    }
    .a2 img{
      height:25px;
      width:25px;
    }
  </style>
</head>

<body>

  <div class="container my-5">
    <div class="col-ld-12">
      <div class="pt-4 px-3 d-flex justify-content-center">
        <h3>LIST OF USERS</h3>
      </div>

      <div class="px-3">
        <hr>
      </div>

      <div class="d-flex justify-content-end py-3 px-3">
          <div class="a2">
          <a href="add.php" class="text-light"><img src="upload/addb.png" alt=""></a>
          </div>
      </div>

      <div class="mx-3">
        <table class="table text-center">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Artistname</th>
              <th scope="col">Password</th>
              <th scope="col" class="col-2">Image</th>
              <th scope="col" class="col-2">Operation</th>
            </tr>
          </thead>
          <?php
         
          $sql = "Select * from `userlist`";
          $result = mysqli_query($conn,$sql);
          


          
          if($result){
              while($row=mysqli_fetch_assoc($result)){
                  $id=$row['id'];
                  $name=$row['name'];
                  $email=$row['email'];
                  $artist=$row['artistname'];
                  $password=$row['password'];
                  $image=$row['image'];

          

                  echo '<tr>
                  <th scope="row">'.$id.'</th>
                  <td>'.$name.'</td>
                  <td>'.$email.'</td>
                  <td>'.$artist.'</td>
                  <td>'.$password.'</td>
                  <td><img src="upload/' .$image. '" width="auto" height="100"></td>
                  <td> 
                  <button class="btn btn-primary" ><a href="update.php?
                  updateid='.$id.'" 
                  class="text-light">Update</a></button>

                  <button class="btn btn-danger" ><a href="delete.php?
                  deleteid='.$id.'" 
                  class="text-light">Delete</a></button>
                  
                  </td>
                  </tr>';


              }
          }
    
          ?>
        </table>
      </div>

      <div class="mx-3">
        <button class="btn btn-primary mb-3">
          <a href="profile.php" class="text-light">Home</a>
        </button>

        <button class="btn btn-primary mb-3">
          <a href="logout.php" class="text-light">Logout</a>
        </button>

        <!--<button class="btn btn-success" id="exportBtn">Download</button> /soon-->
      </div>
    </div>
  </div>
</body>
</html>

  
      

      <!--
      
      <script>
  document.getElementById("exportBtn").addEventListener("click", function() {
      window.location.href = "export.php";
  });
  </script>
    </body>
  </html>