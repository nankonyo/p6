               
                <nav class="navbar navbar-expand-md p-0 border-0 shadow-sm bg-body-tertiary fixed-top shadow-none" style="height:60px;">
                    <div class="container-fluid">
                        <span class="navbar-brand">
                            <img class="p-0 m-0" src="/assets/img/logo.png" width="50"> 
                            <span class="text-info ms-2" style="font-size:1.2rem;"><?= $title ?></span>
                        </span>
                        <div class="d-flex justify-content-between flex-grow-1">
                            <!-- Menu Navbar -->
                            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                                <!-- Icon Grid (tanpa dropdown) -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modulModal" style="font-size: 1.6rem;">
                                        <i class="bi bi-grid-3x3-gap"></i>
                                    </a>
                                </li>

                                 <li class="nav-item">
                                    <a class="nav-link" href="account" style="font-size: 1.6rem;">
                                        <i class="bi bi-person-circle"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!---------------------- Modal Modul ---------------------->
                <div class="modal fade mt-5" id="modulModal" tabindex="-1" aria-labelledby="modulModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 pb-4">
                            <div class="modal-header border-0 bg-info">
                                <h6 class="modal-title text-white" id="modulModalLabel">Menu Pengguna</h6>
                                <button type="button" class="btn-close white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body custom-scroll" id="modalScrollBody">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

                                    <div class="col-4">
                                        <a href="#" class="text-decoration-none text-dark">
                                            <div class="text-center h-100 border-0 pt-0">
                                                <img src="/assets/img/akun.png" class="card-img-top p-4" alt="Gambar">
                                                <div class="card-body p-0">
                                                    <h6 class="card-title text-primary line-clamp-2">Akun Saya</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-4">
                                        <a href="#" class="text-decoration-none text-dark">
                                            <div class="text-center h-100 border-0 pt-0">
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

                <script>
                   
                    //======= jQuery Version =======
                    function getSystemTheme() {
                        return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                    }

                    function setTheme(theme) {
                        const appliedTheme = (theme === "auto") ? getSystemTheme() : theme;

                        // Set atribut data-bs-theme
                        $('html').attr('data-bs-theme', appliedTheme);

                        // Set meta tag theme-color
                        const themeColor = appliedTheme === "dark" ? "#2b3035" : "#f8f9fa";
                        let $meta = $('meta[name="theme-color"]');

                        if ($meta.length === 0) {
                            $meta = $('<meta>', { name: "theme-color" }).appendTo('head');
                        }

                        $meta.attr('content', themeColor);

                        // Simpan preferensi
                        if (theme !== "auto") {
                            localStorage.setItem("theme", theme);
                        } else {
                            localStorage.removeItem("theme");
                        }
                    }

                    // Inisialisasi saat DOM siap
                    $(document).ready(function () {
                        const savedTheme = localStorage.getItem("theme") || "auto";
                        setTheme(savedTheme);
                    });
                </script>