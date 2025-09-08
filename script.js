const burger = document.getElementById("burger-menu");
const nav = document.getElementById("nav-menu");

burger.addEventListener("click", () => {
  nav.classList.toggle("active");
});

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

// Sementara belum ada interaksi JS, bisa digunakan untuk animasi tambahan nanti
console.log("Tentang Kami section loaded.");

// Bisa dikembangkan jika ada interaksi (misal buka popup atau animasi scroll)
console.log("Lokasi Kami section loaded");

// Scroll saat tombol diklik
document.getElementById("scroll-left").addEventListener("click", () => {
  document.getElementById("logo-scroll").scrollBy({ left: -200, behavior: "smooth" });
});

document.getElementById("scroll-right").addEventListener("click", () => {
  document.getElementById("logo-scroll").scrollBy({ left: 200, behavior: "smooth" });
});

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
