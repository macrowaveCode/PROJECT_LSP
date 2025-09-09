// Kalau kamu ingin menambahkan interaksi dropdown bahasa nantinya
document.querySelector(".language-dropdown").addEventListener("click", function () {
  alert("Fitur pilih bahasa coming soon!");
});

function scrollCarousel(direction, buttonElement) {
  const carousel = buttonElement.closest(".carousel-section, .carousel-section2").querySelector(".carousel");
  const scrollAmount = 420;

  carousel.scrollBy({
    left: direction * scrollAmount,
    behavior: "smooth",
  });
}

function recaptchaSuccess(token) {
  if (typeof grecaptcha === "undefined") {
    alert("Sistem verifikasi belum siap. Silakan tunggu sebentar.");
    return;
  }

  const recaptchaToken = grecaptcha.getResponse();
  if (!recaptchaToken) {
    alert("Verifikasi gagal. Silakan coba lagi.");
    grecaptcha.reset();
    return;
  }

  console.log("✅ reCAPTCHA lolos dengan token:", recaptchaToken);
  window.location.href = "https://docs.google.com/forms/d/e/1FAIpQLScqQ8K7VIOHHrBt7xqLJTwUvPbHszeYotZEOp1HJLsYxpKJBA/viewform";
}
