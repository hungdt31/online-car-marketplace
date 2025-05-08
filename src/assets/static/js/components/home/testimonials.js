document.addEventListener("DOMContentLoaded", function () {
  const avatars = document.querySelectorAll(".avatar");
  const testimonialComment = document.querySelector(".testimonial-comment");
  const starsContainer = document.querySelector(".review-header .stars");
  const testimonialImage = document.querySelector(".testimonial-images img");

  avatars.forEach((avatar) => {
    avatar.addEventListener("click", function () {
      // Get the data attributes for the clicked avatar
      const comment = avatar.getAttribute("data-comment");
      const stars = avatar.getAttribute("data-stars");
      const image = avatar.getAttribute("data-image");

      // Update the testimonial content
      testimonialComment.textContent = comment;
      starsContainer.textContent = stars; // Update the star rating
      testimonialImage.src = image; // Change the image
    });
  });
});
