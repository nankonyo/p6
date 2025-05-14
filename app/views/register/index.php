            	<style>
					.role-card {
						cursor: pointer;
						border: 2px solid transparent;
						transition: border 0.2s;
					}
					.role-card:hover {
						transform: scale(1.05); /* Slight zoom effect */
						border-color: #0d6efd; /* Primary color */
					}
					
					.role-card.border-primary {
						border-color: #0d6efd !important;
					}
					
					::placeholder {
						opacity: 0.5 !important;
					}

					.register-card {
						max-width: 520px;
						padding: 2rem;
						border-radius: 10px;
						box-shadow: 0 0 15px rgba(0,0,0,0.1);
					}

				</style>
				<div class="container" id="registerBox">

					<div class="register-card mx-auto my-3 mb-5 bg-body-tertiary px-3 pt-3 pb-5">
						<div class="d-flex align-items-center position-relative">
							<img src="/assets/img/akun.png" width="60" class="me-2">
							<span class="h2 text-primary m-0 p-0">Pendaftaran Akun</span>
							<a href="#" class="h7 ms-1" style="margin-top:-20px;">
								<i class="bi bi-info-circle h6"></i>
							</a>
						</div>
						<hr class="mb-3">
						
						<form method="POST" enctype="multipart/form-data" class="row g-2" id="registerForm">
							<!-- Role Selection Section -->
							<div class="mb-2">
								<div class="row g-2">
									<div class="col-4">
										<div class="card role-card h-100 bg-primary rounded-5" data-role="1" role="button" tabindex="0">
											<div class="card-body text-center text-white">
												<i class="bi bi-globe" style="font-size:1.8rem;"></i>
												<h6 class="mt-2 h7">Pengguna</h6>
											</div>
										</div>
									</div>
									<div class="col-4">
										<div class="card role-card h-100 bg-primary rounded-5 opacity-25" data-role="2" role="button" tabindex="0">
											<div class="card-body text-center text-white">
												<i class="bi bi-building-fill" style="font-size:1.8rem;"></i>
												<h6 class="mt-2 h7">Staff</h6>
											</div>
										</div>
									</div>
									<div class="col-4">
										<div class="card role-card h-100 bg-primary rounded-5 opacity-25" data-role="3" role="button" tabindex="0">
											<div class="card-body text-center text-white">
												<i class="bi bi-building-fill-gear" style="font-size:1.8rem;"></i>
												<h6 class="mt-2 h7">Admin</h6>
											</div>
										</div>
									</div>
								</div>
								<input class="is-valid" type="hidden" name="id_role" id="id_role" value="1">
							</div>

							<!-- Email Field -->
							<div class="col-md-12">
								<label for="email" class="form-label text-primary m-0">Alamat Email</label>
								<input type="text" class="form-control form-control-lg" id="email" name="email" autocomplete="off">
								<div class="valid-feedback"></div>
								<div class="invalid-feedback"></div>
							</div>

							<!-- Password Field -->
							<div class="col-md-6 position-relative">
								<label for="password" class="form-label text-primary m-0">Kata Sandi</label>
								<input type="password" class="form-control form-control-lg pe-5" id="password" name="password" autocomplete="off">
								<div class="valid-feedback"></div>
								<div class="invalid-feedback"></div>
								<i class="bi bi-eye-slash toggle-eye text-muted" data-target="#password" style="position:absolute; right:20px; top:29px; cursor:pointer; font-size:1.6rem;"></i>
							</div>

							<!-- Password Confirm Field -->
							<div class="col-md-6 mb-3 position-relative">
								<label for="password_confirm" class="form-label text-primary m-0">Ulangi Kata Sandi</label>
								<input type="password" class="form-control form-control-lg pe-5" id="password_confirm" name="password_confirm" autocomplete="off">
								<div class="valid-feedback"></div>
								<div class="invalid-feedback"></div>
								<i class="bi bi-eye-slash toggle-eye text-muted" data-target="#password_confirm" style="position:absolute; right:20px; top:29px; cursor:pointer; font-size:1.6rem;"></i>
							</div>

							<!-- Terms Checkbox -->
							<div class="col-12 mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="terms" name="terms" value="1" autocomplete="off">
									<label class="form-check-label" for="terms">
										Saya menyetujui <a href="/register/terms" target="_blank">Syarat dan Ketentuan</a>
									</label>
									<div class="valid-feedback"></div>
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<!-- Submit Button -->
							<button type="submit" class="btn btn-lg btn-primary w-100 d-flex justify-content-center align-items-center" id="submitBtn">
								<span class="spinner-border me-2 d-none spinner-border-sm border-2" role="status" aria-hidden="true" id="submitSpinner"></span>
								<span id="submitText">Daftar Sekarang</span>
							</button>
						</form>
						<span class="float-end pt-4 h7"><?= $credit;?></span>
					</div>

				</div>

				<div id="successMessage" class="d-none text-center mx-auto" style=max-width:600px;>
					<div class="alert alert-success p-5 rounded shadow-sm">
						<i class="bi bi-check-circle-fill text-success mb-3" style="font-size:3rem;"></i>
						<h4 class="mb-3">Pendaftaran Berhasil!</h4>
						<p id="successDetail" class="mb-3"></p>
						<a href="/auth">Ke Halaman Masuk</a>
					</div>
				</div>

				<!-- Modal Bootstrap untuk pesan -->
				<div class="modal fade mt-5" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content border-0 pb-4 h7">
							<div class="modal-header bg-info text-white">
								<h6 class="modal-title" id="alertModalLabel">Informasi</h6>
								<button type="button" class="btn-close white" data-bs-dismiss="modal"></button>
							</div>
							<div class="mt-3 text-center px-3">
								<i class="bi bi-exclamation-circle text-info" style="font-size:3rem;"></i>
								<div class="modal-body m-0 p-0 text-break" id="modalMessage"></div>
							</div>
							
						</div>
					</div>
				</div>
				
				<script>

					// select role

					$(document).ready(function () {
						$('.role-card').on('click', function () {
							// Hilangkan semua perubahan opacity dan border
							$('.role-card').removeClass('opacity-100').addClass('opacity-25');
							
							// Tambahkan opacity penuh ke elemen yang dipilih
							$(this).removeClass('opacity-25').addClass('opacity-100');
							
							// Set nilai role ke input tersembunyi
							$('#id_role').val($(this).data('role') || '');
						});
					});

					// eye

					$(document).ready(function () {
						$('.toggle-eye').on('click', function () {
							const targetSelector = $(this).data('target');
							const $targetInput = $(targetSelector);
							const isPassword = $targetInput.attr('type') === 'password';

							$targetInput.attr('type', isPassword ? 'text' : 'password');
							$(this).toggleClass('bi-eye bi-eye-slash');
						});
					});

					// field controll

					$(document).ready(function () {

						// Email field restrictions
						$('#email').on('input', function () {
							let emailValue = $(this).val();

							// Allow only specific characters: letters, digits, and symbols @, -, _, .
							emailValue = emailValue.replace(/[^a-zA-Z0-9@._-]/g, '');
							
							// Convert to lowercase
							emailValue = emailValue.toLowerCase();
							
							// Limit to 100 characters
							if (emailValue.length > 100) {
								emailValue = emailValue.slice(0, 100);
							}

							$(this).val(emailValue); // Update the email input with the restricted value
						});

						// Password field restrictions
						$('#password').on('input', function () {
							let passwordValue = $(this).val();

							// Limit to 100 characters
							if (passwordValue.length > 100) {
								passwordValue = passwordValue.slice(0, 100);
							}

							$(this).val(passwordValue); 
						});

						// Password confirm field restrictions
						$('#password_confirm').on('input', function () {
							let passwordConfirmValue = $(this).val();

							// Limit to 100 characters
							if (passwordConfirmValue.length > 100) {
								passwordConfirmValue = passwordConfirmValue.slice(0, 100);
							}

							$(this).val(passwordConfirmValue);
						});
					});


					// validation register

					$(document).ready(function () {
						// Validasi Email
						$('#email').on('input', function () {
							var email = $(this).val();
							var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
							if (emailRegex.test(email)) {
								setValid($(this), 'Alamat email valid.');
							} else {
								setInvalid($(this), 'Harap masukkan alamat email yang valid.');
							}
							validateForm();
						});

						// Gabung Validasi Password & Konfirmasi
						$('#password, #password_confirm').on('input', function () {
							validatePasswordFields();
						});
						
						// Fungsi Validasi Password
						function validatePasswordFields() {
							var password = $('#password').val();
							var confirm = $('#password_confirm').val();

							if (password.length >= 6) {
								setValid($('#password'), 'Kata sandi kuat.');
							} else {
								setInvalid($('#password'), 'Kata sandi harus memiliki panjang minimal 6 karakter.');
							}

							if (confirm.length < 6) {
								setInvalid($('#password_confirm'), 'Kata sandi harus memiliki panjang minimal 6 karakter.');
							} else if (password === confirm) {
								setValid($('#password_confirm'), 'Kata sandi cocok dan valid.');
							} else {
								setInvalid($('#password_confirm'), 'Kata sandi tidak cocok.');
							}

							adjustEyeIconPosition();
							validateForm();
						}

						// Validasi Checkbox Terms
						$('#terms').on('change', function () {
							if ($(this).is(':checked')) {
								setValid($(this), 'Anda telah menyetujui syarat dan ketentuan.');
							} else {
								setInvalid($(this), 'Anda harus menyetujui syarat dan ketentuan.');
							}
							validateForm();
						});

						// Fungsi Validasi Global
						function validateForm() {
							var isValid = true;
							$('input').each(function () {
								if (!$(this).hasClass('is-valid')) {
									isValid = false;
								}
							});
							if (!$('#terms').is(':checked')) isValid = false;
							$('#registerForm button[type="submit"]').prop('disabled', !isValid);
						}

						// Fungsi Feedback
						function setValid($el, message) {
							$el.removeClass('is-invalid').addClass('is-valid');
							$el.siblings('.valid-feedback').text(message).show();
							$el.siblings('.invalid-feedback').hide();
						}

						function setInvalid($el, message) {
							$el.removeClass('is-valid').addClass('is-invalid');
							$el.siblings('.invalid-feedback').text(message).show();
							$el.siblings('.valid-feedback').hide();
						}

						// Fungsi Penyesuaian Posisi Icon
						function adjustEyeIconPosition() {
							$('#password, #password_confirm').each(function () {
								const icon = $(this).siblings('.toggle-eye');
								if ($(this).hasClass('is-valid') || $(this).hasClass('is-invalid')) {
									icon.css('right', '46px');
								} else {
									icon.css('right', '20px');
								}
							});
						}

						// Inisialisasi
						$('#registerForm button[type="submit"]').prop('disabled', true);
						adjustEyeIconPosition();
					});

					// end validation register


					// ajax request register

					$(document).ready(function () {
						$('#registerForm').on('submit', function (e) {
							e.preventDefault();

							const form = $(this)[0];
							const formData = new FormData(form);

							// Disable inputs & show spinner
							$('#submitSpinner').removeClass('d-none');
							$('#submitText').text('Memproses...');
							$('#registerForm :input').prop('disabled', true);

							$.ajax({
								url: '/register',
								type: 'POST',
								data: formData,
								contentType: false,
								processData: false,
								dataType: 'json',
								success: function (response) {
									if (response.status === 'success') {
										$('#registerBox').addClass('d-none');

										// Ambil data dari backend
										const email = response.email || '-';

										const successDetail = `
											Akun dengan email <strong>${email}</strong>
											telah berhasil didaftarkan.
										`;

										$('#successDetail').html(successDetail);
										$('#successMessage').removeClass('d-none');
									} else {
										handleError(response.messages || [response.message || 'Terjadi kesalahan tidak diketahui.']);
									}
								},

								error: function (xhr) {
									let messages = ['Respons tidak valid dari server.'];
									console.log('Raw responseText:', xhr.responseText); // ✅ Log respons mentah dari server

									try {
										const res = JSON.parse(xhr.responseText);
										messages = Array.isArray(res.messages) ? res.messages : [res.message || messages[0]];
									} catch (e) {
										console.log('JSON parse error:', e); // ✅ Log error parsing
									}

									handleError(messages);
								},
								complete: function () {
									$('#submitSpinner').addClass('d-none');
									$('#submitText').text('Daftar Sekarang');
									$('#registerForm :input').prop('disabled', false);
								}
							});
						});

						function handleError(errors) {
							let html = '<ul class="list-group shadow-none">';
							errors.forEach(function (msg) {
								html += `<li class="list-group-item border-0 p-0">${msg}</li>`;
							});
							html += '</ul>';
							$('#modalMessage').html(html);
							const modal = new bootstrap.Modal(document.getElementById('alertModal'));
							modal.show();
						}
					});

					// end ajax reister
					
				</script>