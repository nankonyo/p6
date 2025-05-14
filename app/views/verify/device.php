            <?php if ($device): ?>
                <div class="container" style="margin-top:5rem;">
                    <div class="card shadow-sm mx-auto pb-3" style="max-width:400px;">
                        <div class="card-body">
                            <!-- Header Section -->
                            <div class="d-flex align-items-center mb-3">
                                <!-- Kondisi untuk menampilkan ikon perangkat -->
                                <?php if ($device['device'] == 'desktop'): ?>
                                    <i class="bi bi-laptop me-3" style="font-size:5rem;"></i>
                                <?php elseif ($device['device'] == 'mobile'): ?>
                                    <i class="bi bi-phone-fill me-3" style="font-size:5rem;"></i>
                                <?php else: ?>
                                    <i class="bi bi-device-unknown me-3" style="font-size:5rem;"></i> <!-- Ikon default untuk perangkat tidak dikenal -->
                                <?php endif; ?>

                                <div>
                                    <h6 class="mb-0"><?= htmlspecialchars(ucfirst($device['device'] ?? 'Unknown')) ?></h6>
                                    <h6 class="mb-0"><?= htmlspecialchars($device['os'] ?? 'Unknown') ?></h6>
                                    <small class="text-muted h7">
                                        <?= htmlspecialchars($device['location_city'] ?? '-') ?> 
                                        <?= htmlspecialchars($device['location_region'] ?? '-') ?>, 
                                        <?= htmlspecialchars($device['location_country'] ?? '-') ?>
                                    </small><br>
                                    <span class="badge bg-primary mt-1">
                                        <?= $device['stat'] == true ? 'Terverifikasi' : 'Baru' ?>
                                    </span>
                                    <small class="text-muted h8">
                                        Sign in Terakhir : <?= date('l, d M Y', strtotime($device['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                            <hr>

                            <!-- Browser Section -->
                            <h6 class="mb-2">Browsers, Apps, and Services</h6>
                            <small class="text-muted"><?= htmlspecialchars($device['browser'] ?? 'Unknown') ?></small><br>
                            <small class="text-muted">Host : <?= htmlspecialchars($device['host_name'] ?? '-') ?></small><br>
                            <small class="text-muted">Ipv4/Ipv6 : <?= htmlspecialchars($device['ip_address'] ?? '-') ?></small>
                            
                            <p class="text-muted text-center mt-3">Alamat email saat ini: <strong><?= htmlspecialchars($email) ?></strong></p>
                            <div class="text-center">
                                <span id="waitingText"></span>
                            </div>
                            <div class="d-grid gap-2 mt-3" id="verDevice">
                                <button class="btn btn-primary" type="button">Verifikasi perangakat</button>
                            </div>

                            <?php if (!$emailVerStat): ?>
                            <div class="d-grid gap-2 mt-3" id="changeEmail">
                                <button class="btn btn-primary" type="button">Ganti Alamat Email</button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php
                    if (!$data_perangkat) {
                        header("Location: /logout");
                        exit;
                    }
                    ?>
            <?php endif; ?>
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
                $(document).ready(function () {
                    const container = $('#verDevice');
                    const originalBtn = `<button id="btnVerifikasi" class="btn btn-primary w-100" type="button">Verifikasi perangkat</button>`;
                    const storageKey = 'verDeviceCountdownEnd';
                    let countdownInterval = null;
                    let backoffTimeout = null;
                    let dotInterval = null;

                    container.html(originalBtn);

                    function initCountdownIfExists() {
                        const storedTime = localStorage.getItem(storageKey);
                        if (storedTime) {
                            const endTime = parseInt(storedTime, 10);
                            const now = Math.floor(Date.now() / 1000);
                            const remaining = endTime - now;
                            if (remaining > 0) {
                                startCountdown(container, remaining);
                            } else {
                                localStorage.removeItem(storageKey);
                                container.html(originalBtn);
                            }
                        } else {
                            container.html(originalBtn);
                        }
                    }

                    function formatTime(seconds) {
                        const m = Math.floor(seconds / 60);
                        const s = seconds % 60;
                        return `${m}:${s.toString().padStart(2, '0')}`;
                    }

                    function startCountdown(container, seconds) {
                        let remaining = seconds;
                        let dotCount = 1;

                        container.html(`<button class="btn btn-secondary w-100" type="button" disabled>Sisa waktu: ${formatTime(remaining)}</button>`);

                        dotInterval = setInterval(() => {
                            dotCount = (dotCount % 3) + 1;
                            const dots = '.'.repeat(dotCount);
                            $('#waitingText').text(`Menunggu${dots}`);
                        }, 500);

                        countdownInterval = setInterval(() => {
                            remaining--;
                            if (remaining <= 0) {
                                clearInterval(countdownInterval);
                                clearInterval(dotInterval);
                                clearTimeout(backoffTimeout);
                                localStorage.removeItem(storageKey);
                                container.html(originalBtn);
                                $('#waitingText').text('');
                            } else {
                                container.find('button').text(`Sisa waktu: ${formatTime(remaining)}`);
                            }
                        }, 1000);

                        checkDeviceVerification(1000); // Mulai polling dengan delay awal 1 detik
                    }

                    function checkDeviceVerification(delay) {
                        backoffTimeout = setTimeout(() => {
                            fetch('/verify/device-status')
                                .then(res => res.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        location.reload();
                                    } else if (data.status === 'pending') {
                                        checkDeviceVerification(Math.min(delay * 2, 10000)); // max delay 10s
                                    } else {
                                        console.error('Status error:', data.message);
                                    }
                                })
                                .catch(err => {
                                    console.error('Fetch error:', err);
                                    checkDeviceVerification(Math.min(delay * 2, 10000));
                                });
                        }, delay);
                    }

                    function sendVerificationEmail() {
                        const btn = $('#btnVerifikasi');
                        btn.prop('disabled', true).text('Mengirim...');

                        fetch('/verify/send-email', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' }
                        })
                            .then(res => res.json())
                            .then(response => {
                                let messages = Array.isArray(response.message) ? response.message : [response.message];
                                let html = '<ul class="list-group shadow-none">';
                                messages.forEach(function (msg) {
                                    html += `<li class="list-group-item border-0 p-0">${msg}</li>`;
                                });
                                html += '</ul>';
                                $('#modalMessage').html(html);
                                const modal = new bootstrap.Modal(document.getElementById('alertModal'));
                                modal.show();

                                const duration = 120;
                                const endTime = Math.floor(Date.now() / 1000) + duration;
                                localStorage.setItem(storageKey, endTime);
                                startCountdown(container, duration);
                            })
                            .catch(() => {
                                $('#modalMessage').html('Terjadi kesalahan saat mengirim email.');
                                $('#alertModal').modal('show');
                                btn.prop('disabled', false).text('Verifikasi perangkat');
                            });
                    }

                    // Debounce tombol (prevent spam)
                    let debounceTimeout = null;
                    container.on('click', '#btnVerifikasi', function () {
                        if (debounceTimeout) return;
                        sendVerificationEmail();
                        debounceTimeout = setTimeout(() => {
                            debounceTimeout = null;
                        }, 1500); // 1.5 detik
                    });

                    initCountdownIfExists();
                });
            </script>