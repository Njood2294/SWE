<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "root"; // Replace with your database password if any
$dbname = "handmade";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION["user_id"])) {
    die("You must be logged in.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $post_description = $conn->real_escape_string($_POST["post_description"]);
    


    // SQL query to insert data into the community table
    $sql = "INSERT INTO community (user_id, post_description) 
            VALUES ('$user_id', '$post_description')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Post added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>

        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community</title>
    
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #EDD8E2;
            color: #9B5372; /*for comment*/
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
         width: 80%;
         margin: auto;
         background:  #EDD8E2;
         padding: 20px;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         margin-top: 80px; 
}
        h1 {
            color: #9B5372;
        }
        .new-post {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .input-container {
           width: 100%;
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
        }
       textarea {
      width: 100%; /* جعله يمتد بكامل عرض الحاوية */
    max-width: 90%; /* زيادة الحد الأقصى للعرض */
    height: 180px; /* زيادة الارتفاع */
    padding: 15px;
    border: none;
    border-radius: 8px;
    background: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 18px;
    resize: none;
    display: block; /* التأكد أنه لا يتأثر بأي فلوت */
}
        input[type="file"] {
            border: none;
            background: none;
            cursor: pointer;
            color: #BF7896;
            outline: none;
            align-self: flex-start;
            margin-left: 10px;

        }
        input[type="file"]::-webkit-file-upload-button {
            background: #BF7896;
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="file"]::-webkit-file-upload-button:hover {
            background: #9B5372;
        }
        button {
            background: #BF7896;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #9B5372;
        }
        .postContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            padding: 15px;
            border-radius: 10px;
        }
        .post {
            background: #FFFFFF;
            padding: 15px;
            border-radius: 5px;
            width: 300px;
            text-align: left;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .post img {
            max-width: 100%;
            border-radius: 5px;
            margin-top: 10px;
        }
        .like-comment {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .like, .comment {
            cursor: pointer;
            color: #BF7896;
        }
        .like:hover, .comment:hover {
            color: #9B5372;
        }
        header {
    display: flex;
    align-items: center;
    background-color: #DFB8CC;
    padding: 0em 1em;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 7%;
    border-bottom: 0.2em solid #e4cbcb;
}

.logo-title {
    display: flex;
    align-items: center;
    color:#9B5372;
}
#logo-title{
    margin-left: 3%;
    padding-top: 5%;
}

#comHeader {
    display: flex;
    align-items: center;
    gap: 1em; 
    position: absolute;
    right: 3%; 
    top: 20%;
}

#comHeader a {
    display: inline-block;
    background-color: #BF7896; 
    padding: 0.4em; 
    border-radius: 0.5em;
}

#comHeader a img {
    display: block; 
    width: 0.8em; 
    height: 0.8em;
}

#comHeader1 {
    display: flex;
    justify-content: flex-end; 
    align-items: center;
    gap: 2em; 
    position: absolute;
    right: 33%; 
    top: 25%;
    padding-right: 0em;
    
}
.categories{
    padding: 0.1em; 
    
   /* background-color: #BF7896; 
    border-radius: 0.2em;*/ 
    color: #9B5372;
}    




footer {
    background-color: #DFB8CC; 
    
    display: flex;
    justify-content: space-between; 
    align-items: center;
    padding: 1em 5%; 
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 1%;
    border-top: 0.2em solid #e4cbcb; 
    color: #9B5372;
    font-weight: bold;
}



.footer-left img {
    width: 1.5em; 
    height: auto;
    margin-right: 0.5em; 
}

.footer-right {
    align-items: center;
   padding-right: 6em;
   
}



.footer-left {
    display: flex;
    align-items: center;
    margin-left: -3%;
    padding-left:-10%; 
    gap:1em;
}
a{
    font-size:1.3em;
    
    font-weight: bold;
    color:rgb(3, 3, 3);
    text-decoration: none;
}


.categories:hover, #comHeader a:hover {
    background-color: #EDD8E2; 
    
}
    </style>
</head>
<body>
    
    <header>
        <div class="logo-title">
            <img src="Logo-removebg-preview - Copy.png" alt="Website Logo" width="25%" height="25%">
            <h3 id="logo-title">Hand made</h3>
        </div>
        <div id="comHeader">
            <a href="HomePage.html"> <img src="Home.svg" alt="Home" ></a>
           <a href="Cart.html"> <img src="cart-shopping-solid.svg" alt="cart" ></a>
           <a href="Homemade/profile.php"> <img src="user-solid.svg" alt="profile"></a>
           <a href="Homemade/logout.php"> <img src="logout.svg" alt="logout" ></a>
        </div>
        <div id="comHeader1">
           <a href="paintingkit.html" class="categories">painting</a>
            <a href="pottery.html" class="categories">pottery</a>
            <a href="woodcarving.html" class="categories">Wood craving</a>
            <a href="mirror.html" class="categories">Mirrors</a>
            <a href="charms.html" class="categories">Chains</a>
        </div>



    </header>
    
  <div class="container">
        <h1>Handmade Crafts Community</h1>
        
        <div class="new-post">
            <form action="community.php" method="POST" enctype="multipart/form-data" id="postForm">
                <div class="input-container">
                    <textarea name="post_description" id="postContent" placeholder="Write your post here..." required></textarea>
                    <input type="file" name="post_image" id="postImage" accept="image/*">
                </div>
                <button type="submit"  name="submit_post">Add Post</button>
                <input type="hidden" name="b">

            </form>
        </div>
        
        <div id="posts" class="postContainer">
            <!-- Posts will be added dynamically here -->
        </div>
    </div>

    <script>
document.getElementById("postForm").addEventListener("submit", function(event) {
            event.preventDefault();  // Prevent default form submission

            // Get form data
            let content = document.getElementById("postContent").value.trim();
            let imageFile = document.getElementById("postImage").files[0];

            // If no content, do nothing
            if (content === "") return;

            let formData = new FormData();
            formData.append("post_description", content);
           

            // Send the form data via AJAX to PHP
            fetch("community.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Display the new post in the UI after submission
                addPost(content, imageFile);
                // Clear the form fields
                document.getElementById("postContent").value = "";
                document.getElementById("postImage").value = "";
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });

        // Add post to the page dynamically
        function addPost(content, imageFile) {
            let postContainer = document.createElement("div");
            postContainer.classList.add("post");

            // Add content text
            let postContent = `<p>${content}</p>`;

            // If there is an image, display it
            if (imageFile) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement("img");
                    img.src = e.target.result;
                    postContainer.appendChild(img);
                };
                reader.readAsDataURL(imageFile);
            }

            postContainer.innerHTML += postContent + `
                <div class="like-comment">
                    <span class="like" onclick="likePost(this)">💓 0</span>
                    <span class="comment" onclick="commentPost(this)">💬 Comment</span>
                </div>
            `;

            // Prepend the new post to the top of the posts container
            document.getElementById("posts").prepend(postContainer);
        }

        // Like functionality
        function likePost(element) {
            let likes = parseInt(element.textContent.split(" ")[1]);
            element.textContent = `💓 ${likes + 1}`;
        }

        // Comment functionality
        function commentPost(element) {
            let comment = prompt("Write your comment:");
            if (comment) {
                let commentPara = document.createElement("p");
                commentPara.textContent = `💬 ${comment}`;
                element.parentElement.parentElement.appendChild(commentPara);
            }
        }
    </script>
      <footer>
        <div class="footer-left">
            <p>Contact Us:</p>
            <img src="twitter.webp" alt="Twitter Icon"> @HandMade
            <img src="instagram.webp" alt="Instagram Icon"> @HandMade
            <img src="email.png" alt="Email Icon"> HandMade@gmail.com
        </div>
        <div class="footer-right">
            &copy; 2025 HandMade
        </div>
    </footer>
</body>
</html>

       
        
    </body>
</html>
