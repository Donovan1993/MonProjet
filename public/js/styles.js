/*

~~~~~~~~~~Overlay when click on a card~~~~~~~~~~~~~~

*/

$(".card-block a").click(function (event) {
  // Creat a copy of the clicked card
  var $card = $(this).parents(".card").clone();

  // Avoid to follow the link
  event.preventDefault();

  // Add a div id overlay
  $("body").append('<div id="card_overlay">');
  // Add the copied card to the overlay
  $("#card_overlay").append($card);
  // Hide the voir link
  $("#card_overlay .card-block a").hide();
  // Add an extra description after the first p
  $(
    "<p>Description supplémentaire à propos du bien en question</p>"
  ).insertAfter("#card_overlay .card p");

  // On tablet and desktop the card takes the full width of the overlay
  if (window.matchMedia("(min-width: 767px)").matches) {
    $("#card_overlay .card img").css("float", "left");
  }

  // Take off the overlay when the user clicks somewhere
  $("#card_overlay").click(function (event) {
    $(this).remove();
  });
});

var swiper = new Swiper(".swiper-container", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

anime
  .timeline({ loop: true })
  .add({
    targets: ".ml15 .word",
    scale: [14, 1],
    opacity: [0, 1],
    easing: "easeOutCirc",
    duration: 800,
    delay: (el, i) => 800 * i,
  })
  .add({
    targets: ".ml15",
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000,
  });

// Wrap every letter in a span
var textWrapper = document.querySelector(".ml2");
textWrapper.innerHTML = textWrapper.textContent.replace(
  /\S/g,
  "<span class='letter'>$&</span>"
);

anime
  .timeline({ loop: true })
  .add({
    targets: ".ml2 .letter",
    scale: [4, 1],
    opacity: [0, 1],
    translateZ: 0,
    easing: "easeOutExpo",
    duration: 950,
    delay: (el, i) => 70 * i,
  })
  .add({
    targets: ".ml2",
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000,
  });
