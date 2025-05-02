            	<style>
					.role-card {
						cursor: pointer;
						border: 2px solid transparent;
						transition: border 0.2s;
					}
					.role-card:hover {
						border-color: #ccc;
					}
					.role-card.border-primary {
						border-color: #0d6efd !important;
					}
				</style>
				<div class="container my-3 card pt-2 pb-5 px-4" style="max-width:550px;">

					<h3 class="my-3 text-primary">
						Pndaftaran Akun
						<a href="#" ><i class="bi bi-info-circle h6 position-absolute ms-2"></i></a>
					</h3>
					
					<form method="POST" enctype="multipart/form-data" class="row g-3" id="registerForm">
						<!-- Role Selection Section -->
						<div class="mb-4 mt-4">
							<div class="row g-2">
								<h6 class="text-primary">Pilih Type akun</h6>
								<div class="col-6">
									<div class="card role-card h-100 border-primary" data-role="1" role="button" tabindex="0">
										<div class="card-body text-center text-primary">
											<i class="bi bi-person-fill" style="font-size:3rem;"></i>
											<h6 class="mt-2">Pengguna</h6>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="card role-card h-100" data-role="2" role="button" tabindex="0">
										<div class="card-body text-center text-primary">
											<i class="bi bi-person-fill-gear" style="font-size:3rem;"></i>
											<h6 class="mt-2">Staff</h6>
										</div>
									</div>
								</div>
							</div>
							<input class="is-valid" type="hidden" name="id_role" id="id_role" value="1">
						</div>

						<!-- Email Field -->
						<div class="col-md-6">
							<label for="email" class="form-label text-primary">Email</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="contoh@email.com" autocomplete="off">
							<div class="valid-feedback"></div>
							<div class="invalid-feedback"></div>
						</div>

						<!-- Phone Field -->
						<div class="col-md-6">
							<label for="phone" class="form-label text-primary">Nomor Ponsel</label>
							<input type="tel" class="form-control" id="phone" name="phone" placeholder="081112345678" autocomplete="off">
							<div class="valid-feedback"></div>
							<div class="invalid-feedback"></div>
						</div>

						<!-- Password Field -->
						<div class="col-md-6 position-relative">
							<label for="password" class="form-label text-primary">Kata Sandi</label>
							<input type="password" class="form-control pe-5" id="password" name="password" placeholder="Masukan Kata Sandi" autocomplete="off">
							<div class="valid-feedback"></div>
							<div class="invalid-feedback"></div>
							<i class="bi bi-eye-slash toggle-eye text-muted" data-target="#password" style="position:absolute; right:20px; top:38px; cursor:pointer; font-size:1.2rem;"></i>
						</div>

						<!-- Password Confirm Field -->
						<div class="col-md-6 mb-3 position-relative">
							<label for="password_confirm" class="form-label text-primary">Ulangi Kata Sandi</label>
							<input type="password" class="form-control pe-5" id="password_confirm" name="password_confirm" placeholder="Ulangi Kata Sandi" autocomplete="off">
							<div class="valid-feedback"></div>
							<div class="invalid-feedback"></div>
							<i class="bi bi-eye-slash toggle-eye text-muted" data-target="#password_confirm" style="position:absolute; right:20px; top:38px; cursor:pointer; font-size:1.2rem;"></i>
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
							<span id="submitText">Register</span>
						</button>
					</form>

					<div id="successMessage" class="d-none text-center mt-4">
						<div class="alert alert-success p-5 rounded shadow-sm">
							<i class="bi bi-check-circle-fill text-success mb-3" style="font-size:3rem;"></i>
							<h4 class="mb-3">Pendaftaran Berhasil!</h4>
							<p id="successDetail" class="mb-3"></p>
							<a href="/auth">Ke Halaman Masuk</a>
						</div>
					</div>

				</div>

				<!-- Modal Bootstrap untuk pesan -->
				<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-warning text-white">
								<h6 class="modal-title" id="alertModalLabel">Perhatian</h6>
								<button type="button" class="btn-close white" data-bs-dismiss="modal"></button>
							</div>
							<div class="d-flex d-flex justify-content-center mt-3">
								<i class="bi bi-exclamation-triangle-fill text-warning" style="font-size:4.5rem;"></i>
							</div>
							<div class="modal-body" id="modalMessage"></div>
						</div>
					</div>
				</div>
				
				<script>

					// select role

					document.querySelectorAll('.role-card').forEach(card => {
						card.addEventListener('click', function () {
							document.querySelectorAll('.role-card').forEach(c => c.classList.remove('border-primary'));
							this.classList.add('border-primary');
							document.getElementById('id_role').value = this.dataset.role;
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

						function adjustEyeIconPosition() {
							$('#password, #password_confirm').each(function () {
								const icon = $(this).siblings('.toggle-eye');
								if ($(this).hasClass('is-valid') || $(this).hasClass('is-invalid')) {
									icon.css('right', '42px');
								} else {
									icon.css('right', '20px');
								}
							});
						}


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

						// Phone field restrictions
						$('#phone').on('input', function () {
							let phoneValue = $(this).val();

							// Allow only numbers
							phoneValue = phoneValue.replace(/[^0-9]/g, '');

							// Limit to 15 characters
							if (phoneValue.length > 14) {
								phoneValue = phoneValue.slice(0, 14);
							}

							$(this).val(phoneValue);
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

						// Validasi Nomor Ponsel
						$('#phone').on('input', function () {
							var phone = $(this).val();
							var startWith08Regex = /^08/;
							var lengthValidRegex = /^[0-9]{10,13}$/;

							if (!startWith08Regex.test(phone)) {
								setInvalid($(this), 'Nomor ponsel harus dimulai dengan 08.');
							} else if (!lengthValidRegex.test(phone)) {
								setInvalid($(this), 'Nomor ponsel harus antara 10 hingga 13 digit.');
							} else {
								setValid($(this), 'Nomor ponsel valid.');
							}
							validateForm();
						});

						// Gabung Validasi Password & Konfirmasi
						$('#password, #password_confirm').on('input', function () {
							validatePasswordFields();
						});

						// Validasi Checkbox Terms
						$('#terms').on('change', function () {
							if ($(this).is(':checked')) {
								setValid($(this), 'Anda telah menyetujui syarat dan ketentuan.');
							} else {
								setInvalid($(this), 'Anda harus menyetujui syarat dan ketentuan.');
							}
							validateForm();
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
									icon.css('right', '42px');
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
										$('#registerForm').addClass('d-none');

										// Ambil data dari backend
										const email = response.email || '-';
										const phone = response.phone || '-';

										const successDetail = `
											Akun dengan email <strong>${email}</strong> dan nomor ponsel <strong>${phone}</strong>
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
									try {
										const res = JSON.parse(xhr.responseText);
										messages = Array.isArray(res.messages) ? res.messages : [res.message || messages[0]];
									} catch (e) {}
									handleError(messages);
								},
								complete: function () {
									$('#submitSpinner').addClass('d-none');
									$('#submitText').text('Register');
									$('#registerForm :input').prop('disabled', false);
								}
							});
						});

						function handleError(errors) {
							let html = '<ul>';
							errors.forEach(function (msg) {
								html += `<li>${msg}</li>`;
							});
							html += '</ul>';
							$('#modalMessage').html(html);
							const modal = new bootstrap.Modal(document.getElementById('alertModal'));
							modal.show();
						}
					});

					// end ajax reister
					
				</script>