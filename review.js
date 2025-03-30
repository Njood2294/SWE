document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".rating2 .star");
    let NumStar =0;

   //update num of star
    stars.forEach((star, index) => {
        star.addEventListener("click", function () {
            NumStar = stars.length - index; 
            convertToBlackOr(NumStar);
            document.getElementById("ratingValue").value = NumStar;
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
    

  
    
    
    
    
    
    
       
   let addPostButton = document.querySelector(".add-post");

if (addPostButton) {
    addPostButton.addEventListener("click", function () {
       
        window.location.href = "HomePage.html"; 
    });
} 
    
    
    
    
    
    
    
    
    
    
    
    
    
});
