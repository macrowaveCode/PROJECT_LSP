    // Ambil elemen
    const btnLogin = document.getElementById("btn-login");
    const btnRegister = document.getElementById("btn-register");
    const modalLogin = document.getElementById("modal-login");
    const modalRegister = document.getElementById("modal-register");
    const closeLogin = document.getElementById("close-login");
    const closeRegister = document.getElementById("close-register");

    // Buka modal
    btnLogin.onclick = () => modalLogin.style.display = "block";
    btnRegister.onclick = () => modalRegister.style.display = "block";

    // Tutup modal
    closeLogin.onclick = () => modalLogin.style.display = "none";
    closeRegister.onclick = () => modalRegister.style.display = "none";

    // Tutup klik di luar modal
    window.onclick = (e) => {
      if(e.target == modalLogin) modalLogin.style.display = "none";
      if(e.target == modalRegister) modalRegister.style.display = "none";
    }
