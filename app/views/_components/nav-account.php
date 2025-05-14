            <style>
                /* Wrapper */
                #navAccountWrapper {
                    position: relative;
                    margin-top: 60px;
                }

                /* Blur sides */
                #navAccountWrapper::before,
                #navAccountWrapper::after {
                    content: "";
                    position: absolute;
                    top: 0;
                    width: 40px;
                    height: 100%;
                    z-index: 1;
                    opacity: 1;
                    pointer-events: none;
                    transition: background 0.3s ease;
                }

                /* Tema Terang */
                html[data-bs-theme="light"] #navAccountWrapper::before {
                    left: 0;
                    background: linear-gradient(to right, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0)); /* #fff */
                }

                html[data-bs-theme="light"] #navAccountWrapper::after {
                    right: 0;
                    background: linear-gradient(to left, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0)); /* #fff */
                }

                /* Tema Gelap */
                html[data-bs-theme="dark"] #navAccountWrapper::before {
                    left: 0;
                    background: linear-gradient(to right, rgba(33, 37, 41, 0.8), rgba(33, 37, 41, 0)); /* #212529 */
                }

                html[data-bs-theme="dark"] #navAccountWrapper::after {
                    right: 0;
                    background: linear-gradient(to left, rgba(33, 37, 41, 0.8), rgba(33, 37, 41, 0)); /* #212529 */
                }

                /* Show blur when not fully scrolled */
                #navAccountWrapper.show-left-blur::before {
                    opacity: 1;
                }

                #navAccountWrapper.show-right-blur::after {
                    opacity: 1;
                }

                /* Nav bar */
                /* Nav bar */
                #navAccount {
                    overflow-x: auto;
                    white-space: nowrap;
                    display: flex;
                    flex-wrap: nowrap;

                    /* Hide scrollbar visually but keep functionality */
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                    padding: 0 12px; /* Tambahkan margin horizontal */
                }
                #navAccount::-webkit-scrollbar {
                    display: none;                      /* Chrome, Safari, Opera */
                }

                /* Nav items */
                #navAccount .nav-item {
                    flex-shrink: 0;
                }

                #navAccount .nav-link {
                    padding: 0.75rem 1rem;
                    font-weight: 500;
                    text-decoration: none;
                    white-space: nowrap;
                }

                #navAccount .nav-link:hover {
                    color: #1a73e8;
                }

                #navAccount .nav-link.active {
                    font-weight: 600;
                    border-bottom: 3px solid #1a73e8;
                }

                /* Scroll buttons */
                .scroll-btn {
                    position: absolute;
                    top: 0;
                    height: 100%;
                    background: transparent;
                    border: none;
                    font-size: 3rem;
                    padding: 0 0.75rem;
                    cursor: pointer;
                    display: none;
                    align-items: center;
                    justify-content: center;
                    z-index: 10;
                    transition: transform 0.2s ease, color 0.2s ease;
                }

                .scroll-btn:hover {
                    transform: scale(1.1);
                }

                .scroll-left {
                    left: 0;
                }

                .scroll-right {
                    right: 0;
                }

                /* Show buttons on hover if not force-hidden */
                #navAccountWrapper:hover .scroll-btn:not(.force-hide) {
                    display: flex;
                }

                .scroll-btn.force-hide {
                    display: none !important;
                }
            </style>

            <div class="mx-1">
                <div class="d-block d-sm-block d-md-block d-lg-none position-relative" id="navAccountWrapper">
                    <!-- Scroll Left Button -->
                    <button class="scroll-btn scroll-left position-absolute start-0 top-0 h-100">
                        &#8249;
                    </button>

                    <!-- Nav Horizontal -->
                    <ul class="nav custom-nav-tabs w-100 overflow-auto flex-nowrap d-flex" id="navAccount">
                        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Personal info</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Data & privacy</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Security</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">People & sharing</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Payments</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Extra 1</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Extra 2</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Extra 3</a></li>
                    </ul>

                    <!-- Scroll Right Button -->
                    <button class="scroll-btn scroll-right position-absolute end-0 top-0 h-100">
                        &#8250;
                    </button>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    const $nav = $('#navAccount');
                    const $wrapper = $('#navAccountWrapper');
                    const $leftBtn = $('.scroll-left');
                    const $rightBtn = $('.scroll-right');
                    const scrollAmount = 150;

                    function updateScrollButtonsAndBlur() {
                        const scrollLeft = Math.round($nav.scrollLeft());
                        const scrollWidth = $nav[0].scrollWidth;
                        const clientWidth = $nav.outerWidth();
                        const maxScrollLeft = scrollWidth - clientWidth;

                        // Tombol kiri
                        if (scrollLeft <= 0) {
                            $leftBtn.addClass('force-hide');
                            $wrapper.removeClass('show-left-blur');
                        } else {
                            $leftBtn.removeClass('force-hide');
                            $wrapper.addClass('show-left-blur');
                        }

                        // Tombol kanan
                        if (scrollLeft >= maxScrollLeft - 1) {
                            $rightBtn.addClass('force-hide');
                            $wrapper.removeClass('show-right-blur');
                        } else {
                            $rightBtn.removeClass('force-hide');
                            $wrapper.addClass('show-right-blur');
                        }
                    }

                    $leftBtn.on('click', function () {
                        $nav.animate({ scrollLeft: '-=' + scrollAmount }, 300, updateScrollButtonsAndBlur);
                    });

                    $rightBtn.on('click', function () {
                        $nav.animate({ scrollLeft: '+=' + scrollAmount }, 300, updateScrollButtonsAndBlur);
                    });

                    $nav.on('scroll', function () {
                        setTimeout(updateScrollButtonsAndBlur, 50);
                    });

                    $(window).on('resize', updateScrollButtonsAndBlur);

                    // Inisialisasi
                    updateScrollButtonsAndBlur();
                });
            </script>