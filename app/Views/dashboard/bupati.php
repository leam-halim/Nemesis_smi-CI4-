<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="grid animate-fade">
    <div class="card">
        <h3>Total Paket di Wilayah Anda</h3>
        <div class="value"><?= number_format($region['total_packages'] ?? 0) ?></div>
    </div>
    <div class="card">
        <h3>Paket Prioritas (Anggaran Utama)</h3>
        <div class="value"><?= number_format($region['total_priority_packages'] ?? 0) ?></div>
        <div class="trend up"><i class="fas fa-bullseye"></i> Fokus Utama</div>
    </div>
    <div class="card">
        <h3>Potensi Efisiensi</h3>
        <div class="value">Rp <?= number_format(($region['total_potential_waste'] ?? 0) / 1000000, 2) ?> jt</div>
        <div class="trend down"><i class="fas fa-triangle-exclamation"></i> Perlu Review</div>
    </div>
    <div class="card">
        <h3>Total Anggaran Daerah</h3>
        <div class="value">Rp <?= number_format(($region['total_budget'] ?? 0) / 1000000000, 2) ?> M</div>
    </div>
</div>

<div class="animate-fade" style="animation-delay: 0.2s;">
    <h2 style="margin-bottom: 1.5rem;">Daftar Anggaran Prioritas</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Paket</th>
                    <th>Satuan Kerja</th>
                    <th>Pagu Anggaran</th>
                    <th>Metode Pengadaan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($priority_packages as $package): ?>
                <tr>
                    <td>
                        <div style="font-weight: 600;"><?= $package['package_name'] ?></div>
                        <div style="font-size: 0.75rem; color: var(--secondary);">ID: <?= $package['source_id'] ?></div>
                    </td>
                    <td><?= $package['satker'] ?></td>
                    <td>Rp <?= number_format($package['budget']) ?></td>
                    <td><?= $package['procurement_method'] ?></td>
                    <td>
                        <span class="badge badge-priority">Prioritas</span>
                        <?php if($package['is_flagged']): ?>
                            <span class="badge badge-danger">Mencurigakan</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($priority_packages)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: var(--secondary);">Tidak ada paket prioritas yang ditemukan untuk wilayah ini.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
