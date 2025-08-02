const elements = document.querySelectorAll(".control-btn");
const elements2 = document.querySelectorAll(".carousel-nav");
elements.forEach((element) => {
  element.addEventListener("mouseenter", () => {
    element.classList.add("green");
  });

  element.addEventListener("mouseleave", () => {
    element.classList.remove("green");
  });
});
elements2.forEach((element) => {
  element.addEventListener("mouseenter", () => {
    element.classList.add("green");
  });

  element.addEventListener("mouseleave", () => {
    element.classList.remove("green");
  });
});

const headers = document.querySelectorAll(".accordion-header");

headers.forEach((header) => {
  header.addEventListener("click", () => {
    const content = header.nextElementSibling;
    const icon = header.querySelector(".icon");

    header.classList.toggle("open");
    content.classList.toggle("show");
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const emptyParagraphs = document.querySelectorAll("p");

  emptyParagraphs.forEach((p) => {
    // Trim the content and check if it only contains &nbsp; or is empty
    if (p.innerHTML.trim() === "&nbsp;" || p.textContent.trim() === "") {
      p.style.display = "none";
    }
  });
});

const preloader = document.getElementById("preloader");

const MIN_DISPLAY_TIME = 1000; // 2 seconds
const start = Date.now();

window.addEventListener("load", function () {
  const elapsed = Date.now() - start;
  const delay = Math.max(0, MIN_DISPLAY_TIME - elapsed);

  setTimeout(() => {
    if (preloader) {
      preloader.style.opacity = "0";
      preloader.style.visibility = "hidden";
      preloader.style.transition = "opacity 0.5s ease";
      setTimeout(() => preloader.remove(), 500); // Clean up after fade
    }
  }, delay);
});
// Star rating interactivity
document.querySelectorAll('.rating-stars .star').forEach(star => {
  star.addEventListener('mouseover', function () {
    const val = parseInt(this.dataset.value);
    highlightStars(val);
  });

  star.addEventListener('mouseout', function () {
    const selected = parseInt(document.getElementById('rating-value').value);
    highlightStars(selected);
  });

  star.addEventListener('click', function () {
    const val = parseInt(this.dataset.value);
    document.getElementById('rating-value').value = val;
    highlightStars(val);
  });
});

function highlightStars(count) {
  document.querySelectorAll('.rating-stars .star').forEach(star => {
    const val = parseInt(star.dataset.value);
    if (val <= count) {
      star.classList.add('selected');
    } else {
      star.classList.remove('selected');
    }
  });
}
