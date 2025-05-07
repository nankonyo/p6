		 	
		 	<style type="text/css">
				 .hero {
				position: relative;
				height: 100vh;
				overflow: hidden;
				}

				.youtube-bg {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				z-index: 0;
				pointer-events: none; /* agar iframe tidak mengganggu interaksi */
				}

				.youtube-bg iframe {
				width: 100vw;
				height: 56.25vw; /* 16:9 aspect ratio */
				min-height: 100vh;
				min-width: 177.77vh;
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				}

				.bg-overlay-dark {
				background-color: rgba(0, 0, 0, 0.8) !important;
				}

				.bg-overlay-light {
				background-color: rgba(255, 255, 255, 0.8) !important;
				}

				.overlay {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				z-index: 1;
				}

				.hero-content {
				position: relative;
				z-index: 2;
				text-align: center;
				}

				 /* Animations */
				 .hero-title {
				opacity: 0;
				transform: translateY(30px) scale(0.95);
				transition: all 1s ease;
				}

				.hero-title.show {
				opacity: 1;
				transform: translateY(0) scale(1);
				}

				.hero-sub {
				opacity: 0;
				transform: translateY(20px);
				transition: all 1s ease 0.5s;
				font-size: 3.5rem !important;
				font-weight: 300;
				display: inline-block;
				}
				

				.hero-sub.show {
				opacity: 1;
				transform: translateY(0);
				}

				/* Kursor Kedip */
				.cursor {
				display: inline-block;
				width: 2px; /* Lebih ramping */
				height: 3.3rem;
				animation: blink 0.7s step-end infinite;
				margin-left: 5px;
				transition: width 0.2s ease; /* Mengubah ukuran kursor */
				filter: invert(1);
				}

				/* Animasi Kedip Kursor */
				@keyframes blink {
				50% {
					opacity: 0;
				}
				}

				/* Buttons Styling */
				.hero-buttons {
				opacity: 0;
				display: flex;
				justify-content: center;
				gap: 15px;
				margin-top: 30px;
				}

				.hero-buttons a {
				padding: 12px 30px;
				font-size: 18px;
				text-decoration: none;
				border-radius: 50px;
				transition: background 0.3s ease;
				}

				@media (max-width: 575.98px) {
					.hero-sub {
						font-size: 1.8rem !important;
					}
					.cursor {
						height: 1.5rem;
						}
					}

		 	</style>

			<section class="hero d-flex align-items-center justify-content-center">
				<div class="youtube-bg">
				<iframe
				src="https://www.youtube.com/embed/3iTsYcNyjHs?autoplay=1&loop=1&mute=1&rel=0&cc_load_policy=0&controls=0&disablekb=1&fs=0&iv_load_policy=3&playlist=3iTsYcNyjHs"
				frameborder="0"
				allow="autoplay"
				></iframe>
				</div>

				<div class="overlay bg-overlay-dark" id="heroOverlay"></div>

				<div class="container hero-content">
					<img class="my-3 d-sm-none d-block mx-auto" src="/assets/img/logo.png" width="120">
					<h5 id="hero-title" class="hero-title mb-4">Lembaga Pengembangan Aparatur Pemerintah (LPAP)</h3>
					<p id="hero-sub" class="hero-sub lead fs-4 mb-4">
						<span id="typing-text"></span><span class="cursor bg-body-tertiary" id="cursor"></span>
					</p>
					<div class="d-flex flex-column flex-md-row justify-content-center gap-3 hero-buttons" id="hero-buttons">
						<a href="#page-content" class="btn btn-primary btn-lg px-5">Mulai Sekarang</a>
						<a href="#learn-more" class="btn btn-outline-info btn-lg px-5">Pelajari Lebih Lanjut</a>
					</div>
				</div>

			</section>

			<section id="page-content" class="py-5">
				<div class="container">
				<h1>About Company</h1>
				<p>
					Lembaga Pengembangan Aparatur Pemerintah (LPAP) berdiri pada tahun 2014 memiliki cita cita dan berkomitmen untuk berperan serta dalam membangun sumber daya manusia Indonesia serta menjadi mitra Pemerintah dalam upaya meningkatkan kualitas Aparatur Sipil Negara.
				</p>
				<h1>Introduction</h1>
				<p>
					Dalam rangka mewujudkan cita-cita Indonesia dibutuhkan aparatur yang profesional, tangguh dan dapat diandalkan dalam menjalankan birokrasi pemerintahan, sehinga menjadi tuntutan dan kewajiban setiap ASN untuk terus melakukan aktualisasi, terus meningkatkan profesionalisme serta paham dan patuh pada peraturan perundangan ASN yang berlaku serta mampu menyesuaikan dengan tuntutan zaman saat ini.
				</p>
				</div>
			</section>

			<script>
				$(document).ready(function () {
					const texts = [
						"Menyediakan Program Pelatihan Berkualitas",
						"Memfasilitasi Pengembangan Karir ASN",
						"Meningkatkan Kapasitas Digital ASN",
						"Mengadakan Evaluasi dan Sertifikasi",
						"Mengutamakan Pembelajaran Berbasis Pengalaman",
						"Mendorong Kolaborasi dan Kemitraan",
						"Mengintegrasikan Nilai-nilai Etika dan Integritas",
						"Memonitor dan Mengevaluasi Dampak Pelatihan"
					];
					let textIndex = 0;
					let charIndex = 0;
					let isDeleting = false;
					const speed = 100;
					const deleteSpeed = 30;
					const wait = 1500;
					const $typingText = $('#typing-text');
					const $cursor = $('#cursor');

					function typeText() {
						const currentText = texts[textIndex];
						let textToDisplay = currentText.substring(0, charIndex);
						$typingText.text(textToDisplay);

						if (!isDeleting) {
							if (charIndex < currentText.length) {
								charIndex++;
								setTimeout(typeText, speed);
							} else {
								isDeleting = true;
								setTimeout(typeText, wait);
							}
						} else {
							if (charIndex > 0) {
								$cursor.css('width', '2px'); // Kurangi ketebalan kursor saat menghapus
								charIndex--;
								setTimeout(typeText, deleteSpeed);
							} else {
								isDeleting = false;
								textIndex = (textIndex + 1) % texts.length;
								setTimeout(typeText, wait); // Tunggu sebelum mulai mengetik lagi
							}
						}
					}

					typeText();

					$('#hero-title').addClass('show');
					setTimeout(() => $('#hero-sub').addClass('show'), 500);
					setTimeout(() => $('#hero-buttons').fadeTo(800, 1), 1500);
				});
				</script>