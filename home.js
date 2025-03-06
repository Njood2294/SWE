document.addEventListener("DOMContentLoaded", function () {
    displayReviews();
});

function displayReviews() {
    let reviews = JSON.parse(localStorage.getItem("reviews")) || [];
    let reviewsContainer = document.querySelector(".reviews-list");

    reviewsContainer.innerHTML = ""; 

    reviews.forEach((review, index) => {
        let reviewCard = document.createElement("div");
        reviewCard.classList.add("review-card");

        let likeSrc = review.liked ? "likeFF.jpg" : "like.jpg";
        let dislikeSrc = review.disliked ? "dislikeF.jpg" : "dislike.jpg";

        reviewCard.innerHTML = `
            <p class="user-name">${review.userName}</p>
            <img src="${review.imageUrl || "default-user.png"}" alt="User Image" class="user-image">
            <h3 class="review-title">${review.productName}</h3>
            <p class="review-text">"${review.reviewText}"</p>
            <div class="review-footer">
                <div class="rating">
                    ${generateStars(review.rating)}
                </div>
                <div class="likes">
                    <img src="${likeSrc}" alt="Like" class="like-icon" onclick="likeReview(${index}, this)"> 
                    <span class="like-count">${review.likes}</span>
                    <img src="${dislikeSrc}" alt="Dislike" class="dislike-icon" onclick="dislikeReview(${index}, this)"> 
                    <span class="dislike-count">${review.dislikes}</span>
                </div>
            </div>
        `;

        reviewsContainer.appendChild(reviewCard);
    });
}


function generateStars(rating) {
    let starsHTML = "";
    for (let i = 0; i < 5; i++) {
        if (i < rating) {
            starsHTML += `<img src="filledstar5.jpg" alt="Star" class="star">`;
        } else {
            starsHTML += `<img src="emptystar.PNG" alt="Star" class="star">`;
        }
    }
    return starsHTML;
}


function likeReview(index, likeBtn) {
    let reviews = JSON.parse(localStorage.getItem("reviews"));
    let review = reviews[index];

    if (review.liked) {
        return; 
    }

    let dislikeBtn = likeBtn.nextElementSibling.nextElementSibling; // dislike button
    let likeCount = likeBtn.nextElementSibling; // num of like
    let dislikeCount = dislikeBtn.nextElementSibling; // num of dislike

    if (review.disliked) {
        
        review.dislikes -= 1;
        review.disliked = false;
        dislikeBtn.src = "dislike.jpg";
        dislikeCount.textContent = review.dislikes;
    }

  
    review.likes += 1;
    review.liked = true;
    likeBtn.src = "likeFF.jpg"; 
    likeCount.textContent = review.likes;

   
    localStorage.setItem("reviews", JSON.stringify(reviews));
}


function dislikeReview(index, dislikeBtn) {
    let reviews = JSON.parse(localStorage.getItem("reviews"));
    let review = reviews[index];

    if (review.disliked) {
        return; 
    }

    let likeBtn = dislikeBtn.previousElementSibling.previousElementSibling; // like btton
    let dislikeCount = dislikeBtn.nextElementSibling; // num of dis
    let likeCount = likeBtn.nextElementSibling; // num of like

    if (review.liked) {
        
        review.likes -= 1;
        review.liked = false;
        likeBtn.src = "like.jpg";
        likeCount.textContent = review.likes;
    }

   
    review.dislikes += 1;
    review.disliked = true;
    dislikeBtn.src = "dislikeF.jpg"; 
    dislikeCount.textContent = review.dislikes;

    
    localStorage.setItem("reviews", JSON.stringify(reviews));
}
