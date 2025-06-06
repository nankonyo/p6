
				<div class="container">
					<div class="text-center mx-auto my-3 mb-5 px-3 py-5" style="max-width:400px;">
						<div class="mb-3 signin-logo"><img src="/assets/img/logo.png" width="80"></div>
						<h5 class="mb-3">Sign in</h5>
						<p class="mb-4">Masuk ke Akun kamu!</p>
						<form method="POST" enctype="multipart/form-data" id="signinForm">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="emailInput" placeholder="Email, Username atau Nomor Ponsel" maxlength="254" autocomplete="off">
								<label for="emailInput">Email, Username atau Nomor Ponsel</label>
							</div>

							<div class="form-floating mb-1">
								<input type="password" class="form-control" id="passwordInput" placeholder="Masukan Kata Sandi" maxlength="254" autocomplete="off">
								<label for="emailInput">Kata Sandi</label>
							</div>

							<div class="mb-3 form-check ms-1">
								<input type="checkbox" class="form-check-input" id="showPassword">
								<label class="form-check-label float-start" for="showPassword">Tampilkan Kata Sandi</label>
							</div>

							<div class="text-start mb-3 text-end">
								<a href="/auth/forgotpassword" class="text-decoration-none">Lupa Kata Sandi ?</a>
							</div>

							<div class="d-flex justify-content-between align-items-center">
								<a href="/register" class="text-decoration-none">Daftarkan akun</a>
								<button type="submit" class="btn btn-primary" id="submitBtn">
								<span class="spinner-border me-2 d-none spinner-border-sm border-2" role="status" aria-hidden="true" id="submitSpinner"></span>
									Masuk <i class="bi bi-arrow-right ms-1"></i>
								</button>
							</div>
						</form>
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

					// JavaScript to toggle password visibility
					document.getElementById('showPassword').addEventListener('change', function() {
						var passwordInput = document.getElementById('passwordInput');
						if (this.checked) {
							passwordInput.type = 'text';
						} else {
							passwordInput.type = 'password';
						}
					});
					

					// request signin

					$(document).ready(function () {
						$('#signinForm').on('submit', function (e) {
							e.preventDefault();

							const form = $(this)[0];
							const formData = new FormData(form);

							formData.append('email', $('#emailInput').val());
							formData.append('password', $('#passwordInput').val());

							const urlParams = new URLSearchParams(window.location.search);
							const redir = urlParams.get('redir') || '';
							formData.append('redir', redir);

							// Disable form inputs and show spinner
							$('#submitSpinner').removeClass('d-none');
							$('#submitBtn').prop('disabled', true);
							$('#signinForm :input').prop('disabled', true);

							let shouldRedirect = false;

							$.ajax({
								url: '/auth',
								type: 'POST',
								data: formData,
								contentType: false,
								processData: false,
								dataType: 'json',
								success: function (response) {
									if (response.status === 'success') {
										console.log(response.message);
										shouldRedirect = true;
										// Redirect cepat tanpa tambah entri histori
										location.replace(response.redirect);
									} else {
										handleError(response.messages || [response.message || 'Terjadi kesalahan saat login.']);
									}
								},
								error: function (xhr) {
									let messages = ['Respons tidak valid dari server.'];
									console.log('Raw responseText:', xhr.responseText);

									try {
										const res = JSON.parse(xhr.responseText);
										messages = Array.isArray(res.messages) ? res.messages : [res.message || messages[0]];
									} catch (e) {
										console.log('JSON parse error:', e);
									}

									handleError(messages);
								},
								complete: function () {
									$('#submitSpinner').addClass('d-none');

									// Jangan aktifkan kembali input jika akan redirect
									if (!shouldRedirect) {
										$('#submitBtn').prop('disabled', false);
										$('#signinForm :input').prop('disabled', false);
									}
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

					// end request signin

				</script>