               
                <nav class="navbar navbar-expand-md p-0 border-0 shadow-sm bg-body-tertiary fixed-top" style="height:60px;">
                    <div class="container">
                        <div class="d-flex justify-content-between flex-grow-1">
                            <!-- Menu Navbar -->
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a class="nav-link ps-0" href="/">
                                        <i class="bi bi-arrow-left fw-bold" style="font-size: 1.2rem;"></i>
                                    </a>
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
