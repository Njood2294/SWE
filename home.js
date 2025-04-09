document.addEventListener("DOMContentLoaded", function () {
    fetchReviews();
});

function fetchReviews() {
    fetch("getReviews.php")
        .then(response => response.json())
        .then(data => {
            console.log("returned info from getReviews.php:", data);
            if (Array.isArray(data)) {
                displayReviews(data);
            } else {
                console.error("The retrieved data is not an array!", data);
            }
        })
        .catch(error => console.error("Error fetching ratings:", error));
}

function displayReviews(reviews) {
    let reviewsContainer = document.querySelector(".reviews-list");
    reviewsContainer.innerHTML = ""; 

    reviews.forEach(review => {
        let reviewCard = document.createElement("div");
        reviewCard.classList.add("review-card");

        reviewCard.innerHTML = `
            <div class="review-header">
                <img src="${review.img_url ? review.img_url : 'default-user.png'}" alt="User Image" class="user-image">
                <p class="user-name">${review.user_name}</p>
            </div>
            <h3 class="review-title">${review.product_name}</h3>
            <p class="review-text">"${review.review_text}"</p>
            <div class="review-footer">
                <div class="rating">
                    ${generateStars(review.rating)}
                </div>
                <div class="likes">
                    <img src="like.jpg" alt="Like" class="like-icon" onclick="updateLike(${review.review_id}, 'like', this)"> 
                    <span class="like-count">${review.likes}</span>
                    
                    <img src="dislike.jpg" alt="Dislike" class="dislike-icon" onclick="updateLike(${review.review_id}, 'dislike', this)"> 
                    <span class="dislike-count">${review.dislikes}</span>
                </div>
            </div>
        `;

        reviewsContainer.appendChild(reviewCard);
    });
}

function updateLike(reviewId, action, element) {
    let counter = element.nextElementSibling; 
    
    fetch("updateLikes.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `review_id=${reviewId}&action=${action}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            counter.textContent = parseInt(counter.textContent) + 1; // زيادة العدد
        } else {
            console.error("error", data.message);
        }
    })
    
}


function generateStars(rating) {
    let starsHTML = "";
    for (let i = 1; i <= 5; i++) {
        starsHTML += `<img src="${i <= rating ? 'filledstar5.jpg' : 'emptystar.PNG'}" alt="Star" class="star">`;
    }
    return starsHTML;
}


document.addEventListener("DOMContentLoaded", function () {
    fetchReviews();
});

function fetchReviews() {
    fetch("getReviews.php")
       .then(response => response.json())
      .then(data => {
            console.log("returned info from getReviews.php:", data);
           if (Array.isArray(data)) {
                displayReviews(data);
            } else {
                console.error("The retrieved data is not an array!", data);
            }
        })
      .catch(error => console.error("Error fetching ratings:", error));
}





document.addEventListener("DOMContentLoaded", function () {
    fetchReviews();

    let searchBtn = document.getElementById("search-btn");
    let searchBox = document.getElementById("search-box");

    if (!searchBtn || !searchBox) {
       
        return;
    }

   
    function executeSearch() {
        let query = searchBox.value.trim();
        if (query === "") {
            alert("Please enter your product name or id.");
            return;
        }

       

        fetch(`search.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                console.log("Data received:", data);
                if (Array.isArray(data) && data.length > 0) {
                    let categoryId = data[0].category_id;
                    switch (parseInt(categoryId)) { 
    case 1: window.location.href = "mirror.php"; break;
    case 2: window.location.href = "pottery.php"; break;
    case 3: window.location.href = "woodcarving.php"; break;
    case 4: window.location.href = "paintingkit.php"; break;
    case 5: window.location.href = "charms.php"; break;
    default: alert(" No suitable page found for this product.");
}
                } else {
                    alert(" No products found");
                }
            })
            .catch(error => console.error("error", error));
    }












    searchBtn.addEventListener("click", executeSearch);

    
    searchBox.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); 
            executeSearch();
        }
    });

   
});