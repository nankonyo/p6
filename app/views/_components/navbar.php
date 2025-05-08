
            <style type="text/css">
                #myNav {
                    transition: top 0.3s ease-in-out;
                }
                .navbar-transparent {
                    transition: background-color 0.3s ease-in-out;
                    box-shadow: none;
                }

                .navbar-solid {
                    transition: background-color 0.3s ease-in-out;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                }

                .dropdown-nav {
                    display: none;
                    position: fixed;
                    top: 53px;
                    left: 0;
                    width: 100vw;
                    z-index: 5;
                }

                .dropdown-item {
                    font-weight: bold;
                    display: flex;
                    align-items: center;
                    color: var(--bs-primary);
                }

                .dropdown-item i {
                    margin-right: 8px;
                    font-size: 1.2rem;
                }

                .dropdown-desc {
                    font-size: 0.8rem;
                    margin-left: 30px;
                    margin-bottom: 10px;
                }

                #suggestionList li {
                    cursor: pointer;
                }                 

                /* Kontainer scroll modal */
                #modalScrollBody.custom-scroll {
                    max-height: 300px;
                    overflow-y: auto;
                    overflow-x: hidden;
                    padding-right: 10px;
                    scrollbar-width: thin;
                    scrollbar-color: transparent transparent;
                }

                /* Scrollbar styling untuk WebKit browser */
                #modalScrollBody.custom-scroll::-webkit-scrollbar {
                    width: 8px;
                }

                #modalScrollBody.custom-scroll::-webkit-scrollbar-thumb {
                    background-color: transparent;
                    transition: background-color 0.3s ease;
                    border-radius: 4px;
                }

                /* Scrollbar terlihat saat hover */
                #modalScrollBody.custom-scroll:hover {
                    scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
                }

                #modalScrollBody.custom-scroll:hover::-webkit-scrollbar-thumb {
                    background-color: rgba(0, 0, 0, 0.2);
                }
            </style>

            <!-------------- nav ------------------>
            <nav id="myNav" class="navbar navbar-expand-md fixed-top p-0 border-0 navbar-transparent" style="height:60px;">
                <div class="container">
                    <span class="navbar-brand d-md-block d-none">
                        <img class="p-0 m-0" src="/assets/img/logo.png" width="50">
                    </span>
                    <div class="d-md-none d-flex w-25">
                        <ul class="navbar-nav d-flex flex-row gap-3 me-auto">
                            <li class="nav-item" style="margin-left:-7px">
                                <a class="nav-link p-0 m-0" data-bs-toggle="offcanvas" href="#navOffCanvas" role="button" aria-controls="navOffCanvas" style="font-size: 2rem;">
                                    <i class="bi bi-list"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="d-md-none d-flex w-75">
                        <ul class="navbar-nav d-flex flex-row gap-3 ms-auto">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="#" style="font-size:1.2rem;" data-bs-toggle="modal" data-bs-target="#searchModal">
                                    <i class="bi bi-search"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="font-size:1.2rem;">
                                    <i class="themeIcon bi"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end position-absolute border-0 p-1">
                                    <a class="dropdown-item theme-option rounded" data-theme="light" href="#"><i class="bi bi-sun"></i> Light</a>
                                    <a class="dropdown-item theme-option rounded" data-theme="dark" href="#"><i class="bi bi-moon"></i> Dark</a>
                                    <a class="dropdown-item theme-option rounded" data-theme="auto" href="#"><i class="bi bi-laptop"></i> Default System</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modulModal" style="font-size: 1.2rem;">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                </a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="/auth" style="font-size:1.2rem;">
                                   <i class="bi bi-person-circle"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                              <a class="nav-link active" style="font-size: 1.1rem;" href="/">Beranda</a>
                            </li>
                            <li id="layanan" class="menu-item">
                                <a class="nav-link" href="#" style="font-size: 1.1rem;" >
                                    Layanan <i class="bi bi-chevron-down h6"></i>
                                </a>
                                <div class="dropdown-nav card py-3 overflow-y-auto" style="max-height:500px;">
                                    <div class="container pt-3 pb-2">
                                        <div class="row">

                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 overflow-y-auto overflow-x-hidden bg-body-tertiary" style="max-height:400px;">
                                                <a class="dropdown-item" href="#" style="font-size:1.4rem;">
                                                    <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="30"> Pelatihan
                                                </a>
                                                <p class="dropdown-desc line-clamp-2">
                                                    Meningkatkan keahlian teknis dan spesifik sesuai dengan bidang kerja pegawai untuk menunjang kinerja profesional secara langsung.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 overflow-y-auto overflow-x-hidden bg-body-tertiary" style="max-height:400px;">
                                                <a class="dropdown-item" href="#" style="font-size:1.4rem;">
                                                    <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="30"> Pelatihan
                                                </a>
                                                <p class="dropdown-desc line-clamp-2">
                                                    Meningkatkan keahlian teknis dan spesifik sesuai dengan bidang kerja pegawai untuk menunjang kinerja profesional secara langsung.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 overflow-y-auto overflow-x-hidden bg-body-tertiary" style="max-height:400px;">
                                                <a class="dropdown-item" href="#" style="font-size:1.4rem;">
                                                    <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="30"> Pelatihan
                                                </a>
                                                <p class="dropdown-desc line-clamp-2">
                                                    Meningkatkan keahlian teknis dan spesifik sesuai dengan bidang kerja pegawai untuk menunjang kinerja profesional secara langsung.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 overflow-y-auto overflow-x-hidden bg-body-tertiary" style="max-height:400px;">
                                                <a class="dropdown-item" href="#" style="font-size:1.4rem;">
                                                    <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="30"> Pelatihan
                                                </a>
                                                <p class="dropdown-desc line-clamp-2">
                                                    Meningkatkan keahlian teknis dan spesifik sesuai dengan bidang kerja pegawai untuk menunjang kinerja profesional secara langsung.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 overflow-y-auto overflow-x-hidden bg-body-tertiary" style="max-height:400px;">
                                                <a class="dropdown-item" href="#" style="font-size:1.4rem;">
                                                    <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="30"> Pelatihan
                                                </a>
                                                <p class="dropdown-desc line-clamp-2">
                                                    Meningkatkan keahlian teknis dan spesifik sesuai dengan bidang kerja pegawai untuk menunjang kinerja profesional secara langsung.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 overflow-y-auto overflow-x-hidden bg-body-tertiary" style="max-height:400px;">
                                                <a class="dropdown-item" href="#" style="font-size:1.4rem;">
                                                    <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="30"> Pelatihan
                                                </a>
                                                <p class="dropdown-desc line-clamp-2">
                                                    Meningkatkan keahlian teknis dan spesifik sesuai dengan bidang kerja pegawai untuk menunjang kinerja profesional secara langsung.
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 overflow-y-auto overflow-x-hidden bg-body-tertiary" style="max-height:400px;">
                                                <a class="dropdown-item" href="#" style="font-size:1.4rem;">
                                                    <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="30"> Pelatihan
                                                </a>
                                                <p class="dropdown-desc line-clamp-2">
                                                    Meningkatkan keahlian teknis dan spesifik sesuai dengan bidang kerja pegawai untuk menunjang kinerja profesional secara langsung.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 overflow-y-auto overflow-x-hidden bg-body-tertiary" style="max-height:400px;">
                                                <a class="dropdown-item" href="#" style="font-size:1.4rem;">
                                                    <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="30"> Pelatihan
                                                </a>
                                                <p class="dropdown-desc line-clamp-2">
                                                    Meningkatkan keahlian teknis dan spesifik sesuai dengan bidang kerja pegawai untuk menunjang kinerja profesional secara langsung.
                                                </p>
                                            </div>
                                        </div>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#" style="font-size: 1.1rem;" >Tentang Kami</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#" style="font-size: 1.1rem;" >Klien</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#" style="font-size: 1.1rem;" >Kontak</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#" style="font-size:1.2rem;" data-bs-toggle="modal" data-bs-target="#searchModal">
                                    <i class="bi bi-search" style="transform: scale(1.3); display: inline-block;"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="font-size:1.2rem;">
                                    <i class="themeIcon bi" style="transform: scale(1.3); display: inline-block;"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end position-absolute px-1 border-0" style="font-size:1.2rem;">
                                    <a class="dropdown-item theme-option rounded" data-theme="light" href="#"><i class="bi bi-sun"></i> Light</a>
                                    <a class="dropdown-item theme-option rounded" data-theme="dark" href="#"><i class="bi bi-moon"></i> Dark</a>
                                    <a class="dropdown-item theme-option rounded" data-theme="auto" href="#"><i class="bi bi-laptop"></i> Default System</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" style="font-size:1.2rem;" data-bs-toggle="modal" data-bs-target="#modulModal">
                                    <i class="bi bi-grid-3x3-gap" style="transform: scale(1.3); display: inline-block;"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/auth" style="font-size:1.3rem;">
                                   <i class="bi bi-person-circle" style="transform: scale(1.3); display: inline-block;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
           </nav>
           <!-------------------- end of nav ------------->

           <!---------------------offcanvas ------------------->
            <div class="offcanvas offcanvas-start border-0" tabindex="-1" id="navOffCanvas">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="/">Beranda</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="layananDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Layanan
                    </a>
                    <ul class="dropdown-menu pb-5 w-100 px-2" aria-labelledby="layananDropdown">
                        <li>
                            <a class="dropdown-item rounded" href="#">
                                <img src="/assets/img/pelatihan.png" class="me-1" alt="Gambar" height="20"> Pelatihan
                            </a>
                        </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Tentang Kami</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Klien</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Kontak</a>
                  </li>
                </ul>

                <hr>

                <ul class="navbar-nav mt-3">
                  <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
                      <i class="bi bi-search"></i> Cari
                    </a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                      <i class="themeIcon bi"></i> Tema
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item theme-option" data-theme="light" href="#"><i class="bi bi-sun"></i> Light</a></li>
                      <li><a class="dropdown-item theme-option" data-theme="dark" href="#"><i class="bi bi-moon"></i> Dark</a></li>
                      <li><a class="dropdown-item theme-option" data-theme="auto" href="#"><i class="bi bi-laptop"></i> System Default</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/auth">
                      <i class="bi bi-person-circle"></i> Masuk
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!---------------------- end offcanvas---------------------->

             <!---------------------- Modal Modul ---------------------->
            <div class="modal fade mt-5" id="modulModal" tabindex="-1" aria-labelledby="modulModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content border-0 pb-4">
                        <div class="modal-header border-0 bg-primary">
                            <h6 class="modal-title text-white" id="modulModalLabel">Modul LPAP</h6>
                            <button type="button" class="btn-close white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-scroll" id="modalScrollBody">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

                                <div class="col-4">
                                    <a href="#" class="text-decoration-none text-dark">
                                        <div class="text-center h-100 border-0 pt-3">
                                            <img src="/assets/img/akun.png" class="card-img-top p-4" alt="Gambar">
                                            <div class="card-body p-0">
                                                <h6 class="card-title text-primary line-clamp-2">Akun Saya</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-4">
                                    <a href="#" class="text-decoration-none text-dark">
                                        <div class="text-center h-100 border-0 pt-3">
                                            <img src="/assets/img/pelatihan.png" class="card-img-top p-4" alt="Gambar">
                                            <div class="card-body p-0">
                                                <h6 class="card-title text-primary line-clamp-2">Pelatihan</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-4">
                                    <a href="#" class="text-decoration-none text-dark">
                                        <div class="text-center h-100 border-0 pt-3">
                                            <img src="/assets/img/drive.png" class="card-img-top p-4" alt="Gambar">
                                            <div class="card-body p-0">
                                                <h6 class="card-title text-primary line-clamp-2">Penyimpanan</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                 <!---------------------- END Modal Modul ---------------------->

            <!-- Modal Search -->
            <div class="modal fade mt-5" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content border-0">
                        <div class="modal-header border-0">
                            <h6 class="modal-title">Pencarian</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                            <input type="search" id="searchInput" class="form-control w-100" placeholder="Cari sesuatu...">
                            <ul id="suggestionList" class="list-group mt-4 d-none shadow-none">
                                <!-------list hire-------->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!------ end Modal Search ---------->

            <script>
              $(document).ready(function () {
                const suggestions = [
                  "Kopi Hitam", "Cappuccino", "Latte", "Es Teh", "Roti Bakar", "Nasi Goreng", "Mie Ayam",
                  "Ayam Geprek", "Teh Tarik", "Americano", "Kopi Susu", "Milkshake", "Jus Alpukat", "Susu Jahe"
                ];

                $('#searchInput').on('input', function () {
                  const query = $(this).val().toLowerCase();
                  const filtered = suggestions
                    .filter(item => item.toLowerCase().includes(query))
                    .slice(0, 10); // Ambil maksimal 10 hasil

                  const $list = $('#suggestionList');
                  $list.empty();

                  if (filtered.length > 0 && query.length > 0) {
                    filtered.forEach(item => {
                      $list.append(`<li class="list-group-item list-group-item-action h7 p-2 border-0">${item}</li>`);
                    });
                    $list.removeClass('d-none');
                  } else {
                    $list.addClass('d-none');
                  }
                });

                $('#suggestionList').on('click', 'li', function () {
                  $('#searchInput').val($(this).text());
                  $('#suggestionList').addClass('d-none');
                });
              });
            </script>


            <script>
                $('#modulModal').on('shown.bs.modal', function () {
                    document.getElementById('modulModal').removeAttribute('inert');
                    document.getElementById('modalScrollBody').scrollTop = 0;
                });

                $('#modulModal').on('hidden.bs.modal', function () {
                    document.getElementById('modulModal').setAttribute('inert', 'true');
                });

                $(document).ready(function () {
                    // ======== Theme Management ========
                    function getSystemTheme() {
                        return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                    }

                    function updateThemeIcon(theme) {
                        let iconClass = theme === "light" ? "bi-sun" :
                                        theme === "dark" ? "bi-moon" : "bi-laptop";
                        $(".themeIcon").attr("class", "themeIcon bi " + iconClass);
                    }

                    function updateThemeColor(theme) {
                        let themeColor = theme === "dark" ? "#2b3035" : "#f8f9fa";
                        $("meta[name='theme-color']").attr("content", themeColor);
                    }

                    function setTheme(theme) {
                        let appliedTheme = (theme === "auto") ? getSystemTheme() : theme;
                        $("html").attr("data-bs-theme", appliedTheme);
                        localStorage.setItem("theme", theme);
                        updateThemeIcon(theme);
                        updateThemeColor(appliedTheme);

                        let $heroOverlay = $("#heroOverlay");
                        $heroOverlay.removeClass("bg-overlay-dark bg-overlay-light");
                        $heroOverlay.addClass(appliedTheme === "dark" ? "bg-overlay-dark" : "bg-overlay-light");

                        $(".theme-option").each(function () {
                            $(this).toggleClass("disabled", $(this).data("theme") === theme);
                        });

                        toggleNavbarStyle();
                    }

                    // Tambah meta tag theme-color jika belum ada
                    if ($("meta[name='theme-color']").length === 0) {
                        $("head").append('<meta name="theme-color" content="">');
                    }

                    // Load theme dari localStorage
                    let savedTheme = localStorage.getItem("theme") || "auto";
                    setTheme(savedTheme);

                    $(".theme-option").on("click", function (e) {
                        e.preventDefault();
                        if (!$(this).hasClass("disabled")) {
                            setTheme($(this).data("theme"));
                        }
                    });

                    // ======== Navbar Dropdown Hover ========
                    let dropdownTimeout;

                    $(".menu-item").mouseenter(function () {
                        clearTimeout(dropdownTimeout);

                        // Cek apakah dropdown sudah terbuka
                        if ($(this).find(".dropdown-nav").is(":visible")) {
                            return; // Jika sudah terbuka, jangan jalankan efek lagi
                        }

                        $(".dropdown-nav").stop(true, true).slideUp(100);
                        $(".menu-item i").removeClass("bi-chevron-up").addClass("bi-chevron-down");

                        $(this).find(".dropdown-nav").stop(true, true).slideDown(100);
                        $(this).find("i").removeClass("bi-chevron-down").addClass("bi-chevron-up");
                    });

                    $(".menu-item, .dropdown-nav").mouseleave(function () {
                        dropdownTimeout = setTimeout(() => {
                            // Cek apakah kursor masih di dalam menu-item atau dropdown-nav
                            if (!$(".menu-item:hover, .dropdown-nav:hover").length) {
                                $(".dropdown-nav").stop(true, true).slideUp(100);
                                $(".menu-item i").removeClass("bi-chevron-up").addClass("bi-chevron-down");
                            }
                        }, 100);
                    });

                    // ======== Navbar Hide on Scroll Down ========
                    let lastScrollTop = 0;
                    let $navbar = $("#myNav");
                    let scrollDelta = 5;
                    let navbarHeight = $navbar.outerHeight();

                    $(window).on("scroll", function () {
                        let st = $(this).scrollTop();

                        if (Math.abs(lastScrollTop - st) <= scrollDelta) return;

                        if (st > lastScrollTop && st > navbarHeight) {
                            // Scroll down
                            if (!$(".menu-item:hover, .dropdown-nav:hover").length) {
                                $navbar.css("top", `-${navbarHeight}px`);
                            }
                        } else {
                            // Scroll up
                            $navbar.css("top", "0");
                        }

                        lastScrollTop = st;
                        toggleNavbarStyle();
                    });

                    function toggleNavbarStyle() {
                        let scrollTop = $(window).scrollTop();
                        let currentTheme = $("html").attr("data-bs-theme");

                        if (scrollTop > 10) {
                            $("#myNav")
                                .removeClass("navbar-transparent")
                                .addClass("navbar-solid")
                                .css("background-color", "var(--bs-tertiary-bg)");
                        } else {
                            $("#myNav")
                                .removeClass("navbar-solid")
                                .addClass("navbar-transparent")
                                .css("background-color", "transparent");
                        }
                    }

                    toggleNavbarStyle();

                    // ======== Disable Right Click on Hero Image ========
                    $('.navbar-brand').on('contextmenu', function (e) {
                        e.preventDefault();
                    });
                });
            </script>
