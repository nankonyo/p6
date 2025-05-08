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
                            <small class="text-muted">Ip : <?= htmlspecialchars($device['ip_address'] ?? '-') ?></small>
                            
                            <p class="text-muted text-center mt-3">Alamat email saat ini: <strong><?= htmlspecialchars($email) ?></strong></p>
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
                <div class="container my-5">
                    <div class="alert alert-warning text-center">
                        Data perangkat tidak ditemukan.
                    </div>
                </div>
            <?php endif; ?>
