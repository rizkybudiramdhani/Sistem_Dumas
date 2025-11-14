<?php
session_start();
require_once('../config/koneksi.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id == 0) {
    echo '<div class="alert alert-danger">ID tidak valid!</div>';
    exit;
}

$query = "SELECT * FROM laporan_samapta WHERE id_laporan = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo '<div class="alert alert-danger">Laporan tidak ditemukan!</div>';
    exit;
}

$row = mysqli_fetch_assoc($result);

// Status badge class
$status_class = 'primary';
if ($row['status_verifikasi'] == 'baru') $status_class = 'warning';
elseif ($row['status_verifikasi'] == 'diproses') $status_class = 'info';
elseif ($row['status_verifikasi'] == 'ditindaklanjuti') $status_class = 'orange';
elseif ($row['status_verifikasi'] == 'selesai') $status_class = 'success';
?>

<div class="row">
    <div class="col-md-6">
        <p><strong>📅 Tanggal Lapor:</strong><br><?php echo date('d F Y H:i', strtotime($row['tanggal_lapor'])); ?> WIB</p>
    </div>
    <div class="col-md-6">
        <p><strong>📊 Status:</strong><br>
            <span class="badge badge-<?php echo $status_class; ?> badge-pill" style="font-size: 0.9rem; padding: 8px 15px;">
                <?php echo ucfirst($row['status_verifikasi']); ?>
            </span>
        </p>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-4">
        <p><strong>👤 Nama Petugas:</strong><br>
            <?php echo htmlspecialchars($row['pangkat_petugas'] . ' ' . $row['nama_petugas']); ?>
        </p>
    </div>
    <div class="col-md-4">
        <p><strong>🔢 NRP:</strong><br><?php echo htmlspecialchars($row['nrp_petugas']); ?></p>
    </div>
    <div class="col-md-4">
        <p><strong>🎯 Jenis Kegiatan:</strong><br><?php echo htmlspecialchars($row['jenis_kegiatan']); ?></p>
    </div>
</div>

<hr>

<div class="mb-3">
    <strong>📍 Lokasi:</strong>
    <p class="mt-2"><?php echo htmlspecialchars($row['lokasi']); ?></p>
</div>

<div class="mb-3">
    <strong>📝 Kronologi:</strong>
    <p class="mt-2"><?php echo nl2br(htmlspecialchars($row['kronologi'])); ?></p>
</div>

<div class="row">
    <div class="col-md-6">
        <p><strong>👥 Jumlah Tersangka:</strong> <?php echo $row['jumlah_tersangka']; ?> orang</p>
    </div>
    <div class="col-md-6">
        <p><strong>📦 Barang Bukti:</strong><br><?php echo htmlspecialchars($row['rincian_barang_bukti']); ?></p>
    </div>
</div>

<?php if (!empty($row['file_bukti'])): ?>
<div class="mb-3">
    <strong>📎 File Bukti:</strong>
    <p class="mt-2">
        <?php 
        $file_ext = pathinfo($row['file_bukti'], PATHINFO_EXTENSION);
        if (in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png', 'gif'])):
        ?>
            <img src="uploads/bukti_ditsamapta/<?php echo htmlspecialchars($row['file_bukti']); ?>" 
                 class="img-fluid" style="max-height: 300px; border-radius: 8px;">
        <?php else: ?>
            <a href="uploads/bukti_ditsamapta/<?php echo htmlspecialchars($row['file_bukti']); ?>" 
               target="_blank" class="btn btn-sm btn-primary">
                <i class="fa fa-download"></i> Download File
            </a>
        <?php endif; ?>
    </p>
</div>
<?php endif; ?>

<?php if (!empty($row['tanggapan_resnarkoba'])): ?>
<hr>
<div class="mb-3" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
    <strong>💬 Tanggapan Ditresnarkoba:</strong>
    <p class="mt-2"><?php echo nl2br(htmlspecialchars($row['tanggapan_resnarkoba'])); ?></p>
    <small class="text-muted">
        Tanggal: <?php echo date('d F Y H:i', strtotime($row['tanggal_tangapan'])); ?> WIB
    </small>
</div>
<?php endif; ?>

<hr>
<small class="text-muted">
    <i class="dw dw-building"></i> Asal Laporan: <?php echo htmlspecialchars($row['asal_laporan']); ?>
</small>
