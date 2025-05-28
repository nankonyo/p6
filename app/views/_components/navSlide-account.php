<style>
    /* Wrapper */
    #slideNavWrapper {
        position: absolute;
        top: 60px;
    }

    /* Blur sides (hidden by default) */
    #slideNavWrapper::before,
    #slideNavWrapper::after {
        content: "";
        position: absolute;
        top: 0;
        width: 40px;
        height: 100%;
        z-index: 1;
        opacity: 0;                  /* default hidden */
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    /* Tema Terang */
    html[data-bs-theme="light"] #slideNavWrapper::before {
        left: 0;
        background: linear-gradient(to right, rgba(255,255,255,0.8), rgba(255,255,255,0));
    }
    html[data-bs-theme="light"] #slideNavWrapper::after {
        right: 0;
        background: linear-gradient(to left, rgba(255,255,255,0.8), rgba(255,255,255,0));
    }

    /* Tema Gelap */
    html[data-bs-theme="dark"] #slideNavWrapper::before {
        left: 0;
        background: linear-gradient(to right, rgba(33,37,41,0.8), rgba(33,37,41,0));
    }
    html[data-bs-theme="dark"] #slideNavWrapper::after {
        right: 0;
        background: linear-gradient(to left, rgba(33,37,41,0.8), rgba(33,37,41,0));
    }

    /* Show blur only when scroll buttons are active */
    #slideNavWrapper.show-left-blur::before {
        opacity: 1;
    }
    #slideNavWrapper.show-right-blur::after {
        opacity: 1;
    }

    /* Nav bar */
    #slideNav {
        overflow-x: auto;
        white-space: nowrap;
        display: flex;
        flex-wrap: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding: 0 12px;
    }
    #slideNav::-webkit-scrollbar {
        display: none;
    }

    /* Nav items */
    #slideNav .nav-item {
        flex-shrink: 0;
    }
    #slideNav .nav-link {
        padding: 0.75rem 1rem;
        font-weight: 500;
        text-decoration: none;
        white-space: nowrap;
    }
    #slideNav .nav-link:hover {
        color: #1a73e8;
    }
    #slideNav .nav-link.active {
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
    /* Show buttons on hover unless force-hidden */
    #slideNavWrapper:hover .scroll-btn:not(.force-hide) {
        display: flex;
    }
    .scroll-btn.force-hide {
        display: none !important;
    }

</style>

<div class="fixed-top z-1">
    <div class="d-block d-sm-block d-md-block d-lg-none position-relative bg-body-tertiary" id="slideNavWrapper">
        <!-- Scroll Left Button -->
        <button class="scroll-btn scroll-left position-absolute start-0 top-0 h-100">
            &#8249;
        </button>

        <!-- Nav Horizontal -->
        <ul class="nav custom-nav-tabs w-100 overflow-auto flex-nowrap d-flex" id="slideNav">
            <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Data Account</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Data Perangkat</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Hak Akses</a></li>
        </ul>

        <!-- Scroll Right Button -->
        <button class="scroll-btn scroll-right position-absolute end-0 top-0 h-100">
            &#8250;
        </button>
    </div>
</div>

<script>
    $(document).ready(function () {
        const $nav = $('#slideNav');
        const $wrapper = $('#slideNavWrapper');
        const $leftBtn = $('.scroll-left');
        const $rightBtn = $('.scroll-right');
        const scrollAmount = 150;

        function updateScrollButtonsAndBlur() {
            const scrollLeft = Math.round($nav.scrollLeft());
            const scrollWidth = $nav[0].scrollWidth;
            const clientWidth = $nav.outerWidth();
            const maxScrollLeft = scrollWidth - clientWidth;

            if (scrollLeft <= 0) {
                $leftBtn.addClass('force-hide');
                $wrapper.removeClass('show-left-blur');
            } else {
                $leftBtn.removeClass('force-hide');
                $wrapper.addClass('show-left-blur');
            }

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

        updateScrollButtonsAndBlur();
    });
</script>
