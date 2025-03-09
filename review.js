


/*window.onload = function() {
    localStorage.clear();
};*/

document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".rating2 .star");
    let NumStar = 0;

    // update star when click
    stars.forEach((star, index) => {
        star.addEventListener("click", function () {
            NumStar = stars.length - index; 
            convertToBlackOr(NumStar);
        });
    });

    function convertToBlackOr(rating) {
        stars.forEach((star, index) => {
            if (index >= stars.length - rating) {
                star.src = "filledstar5.jpg"; 
            } else {
                star.src = "emptystar.PNG"; 
            }
        });
    }
       
    document.querySelector(".add-post").addEventListener("click", function () {
        const productName = document.getElementById("productName").value.trim();
        const reviewText = document.querySelector("textarea").value.trim();
        const fileInput = document.getElementById("fileUpload");
        let imageUrl = ""; 

        // make sure all input intered
        if (productName === "" || reviewText === "" || NumStar === 0) {
            alert("Please fill out all requirements");
            return;
        }

        if (fileInput.files.length > 0) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imageUrl = e.target.result;
                saveReview(productName, reviewText, NumStar, imageUrl);
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            saveReview(productName, reviewText, NumStar, imageUrl);
        }
    });

    function saveReview(productName, reviewText, rating, imageUrl) {
        let reviews = JSON.parse(localStorage.getItem("reviews")) || [];
    
        let newReview = {
            userName: "Guest", 
            productName: productName,
            reviewText: reviewText,
            rating: rating,
            imageUrl: imageUrl,
            likes: 0,
            dislikes: 0
        };
    
        reviews.push(newReview);
        localStorage.setItem("reviews", JSON.stringify(reviews));
    
        window.location.href = "HomePage.html"; 
    }
});  

