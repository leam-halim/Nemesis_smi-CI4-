<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="grid animate-fade">
    <div class="card">
        <h3>Total Paket</h3>
        <div class="value"><?= number_format($summary['total_packages'] ?? 0) ?></div>
        <div class="trend up"><i class="fas fa-arrow-up"></i> 12% dari bulan lalu</div>
    </div>
    <div class="card">
        <h3>Anggaran Prioritas</h3>
        <div class="value"><?= number_format($summary['total_priority_packages'] ?? 0) ?></div>
        <div class="trend up"><i class="fas fa-arrow-up"></i> 5% dari bulan lalu</div>
    </div>
    <div class="card">
        <h3>Potensi Pemborosan</h3>
        <div class="value">Rp <?= number_format(($summary['total_potential_waste'] ?? 0) / 1000000000, 2) ?> M</div>
        <div class="trend down"><i class="fas fa-arrow-down"></i> 3% dari bulan lalu</div>
    </div>
    <div class="card">
        <h3>Total Anggaran</h3>
        <div class="value">Rp <?= number_format(($summary['total_budget'] ?? 0) / 1000000000, 2) ?> M</div>
    </div>
</div>

<div class="animate-fade" style="animation-delay: 0.2s;">
    <h2 style="margin-bottom: 1.5rem;">Statistik Wilayah</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Wilayah</th>
                    <th>Total Paket</th>
                    <th>Prioritas</th>
                    <th>Pemborosan</th>
                    <th>Skor Risiko (Avg)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($regions as $region): ?>
                <tr>
                    <td>
                        <div style="font-weight: 600;"><?= $region['display_name'] ?></div>
                        <div style="font-size: 0.75rem; color: var(--secondary);"><?= $region['province_name'] ?></div>
                    </td>
                    <td><?= number_format($region['total_packages']) ?></td>
                    <td><span class="badge badge-priority"><?= number_format($region['total_priority_packages']) ?></span></td>
                    <td>Rp <?= number_format($region['total_potential_waste'] / 1000000, 1) ?> jt</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="flex: 1; height: 6px; background: rgba(255,255,255,0.05); border-radius: 3px;">
                                <div style="width: <?= $region['avg_risk_score'] * 10 ?>%; height: 100%; background: var(--primary); border-radius: 3px;"></div>
                            </div>
                            <span><?= $region['avg_risk_score'] ?></span>
                        </div>
                    </td>
                    <td>
                        <button style="background: transparent; border: 1px solid rgba(255,255,255,0.1); color: var(--light); padding: 0.25rem 0.5rem; border-radius: 0.5rem; cursor: pointer;">Detail</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
