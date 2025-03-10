





document.addEventListener("DOMContentLoaded", function () {
    displayReviews();
});

function displayReviews() {
    let reviews = JSON.parse(localStorage.getItem("reviews")) || [];
    let reviewsContainer = document.querySelector(".reviews-list");

    /*reviewsContainer.innerHTML = ""; */

    reviews.forEach((review, index) => {
        let reviewCard = document.createElement("div");
        reviewCard.classList.add("review-card");

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
                    <img src="like.jpg" alt="Like" class="like-icon" onclick="likeReview(this)"> 
                    <span class="like-count">${review.likes}</span>
                    <img src="dislike.jpg" alt="Dislike" class="dislike-icon" onclick="dislikeReview(this)"> 
                    <span class="dislike-count" >${review.dislikes}</span>
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

/*function likeReview(index, likeBtn) {
    let reviews = JSON.parse(localStorage.getItem("reviews"));
    let review = reviews[index];

    review.likes += 1;
    likeBtn.nextElementSibling.textContent = review.likes;

    localStorage.setItem("reviews", JSON.stringify(reviews));
}

function dislikeReview(index, dislikeBtn) {
    let reviews = JSON.parse(localStorage.getItem("reviews"));
    let review = reviews[index];

    review.dislikes += 1;
    dislikeBtn.nextElementSibling.textContent = review.dislikes;

    localStorage.setItem("reviews", JSON.stringify(reviews));
}*/
function likeReview(likeBtn) {
    let likeCount = likeBtn.nextElementSibling;
    likeCount.textContent = parseInt(likeCount.textContent) + 1;
}

function dislikeReview(dislikeBtn) {
    let dislikeCount = dislikeBtn.nextElementSibling;
    dislikeCount.textContent = parseInt(dislikeCount.textContent) + 1;
}
