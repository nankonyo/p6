               
                <nav class="navbar navbar-expand-md p-0 border-0 shadow-sm bg-body-tertiary fixed-top" style="height:60px;">
                    <div class="container-fluid">
                        <span class="navbar-brand">
                            <img class="p-0 m-0" src="/assets/img/logo.png" width="50"> 
                            <span class="text-info ms-2" style="font-size:1.2rem;"><?= $title ?></span>
                        </span>
                        <div class="d-flex justify-content-between flex-grow-1">
                            <!-- Menu Navbar -->
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1.2rem;">
                                        <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end position-absolute p-1 bg-body-tertiary" aria-labelledby="userDropdown">
                                        <li><a class="dropdown-item rounded" href="/account"><?= $title ?></a></li>
                                        <li><a class="dropdown-item rounded" href="/logout?redir=<?= $redir_source;?>">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

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
