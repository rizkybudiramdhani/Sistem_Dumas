<?php
// Cek apakah user punya akses (hanya ditresnarkoba)
if ($role != 'ditresnarkoba') {
    echo '<div class="alert alert-danger">Akses ditolak! Hanya Ditresnarkoba yang dapat mengakses halaman ini.</div>';
    exit;
}

// Proses form submit
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $tanggal_kegiatan = mysqli_real_escape_string($db, $_POST['tanggal_kegiatan']);
    $no_sprint = mysqli_real_escape_string($db, $_POST['no_sprint']);
    $jenis_kegiatan = mysqli_real_escape_string($db, $_POST['jenis_kegiatan']);
    $lokasi = mysqli_real_escape_string($db, $_POST['lokasi']);
    $nama_petugas = mysqli_real_escape_string($db, $_POST['nama_petugas']);
    $nrp_petugas = mysqli_real_escape_string($db, $_POST['nrp_petugas']);
    $pangkat_petugas = mysqli_real_escape_string($db, $_POST['pangkat_petugas']);
    $kronologi = mysqli_real_escape_string($db, $_POST['kronologi']);
    $jumlah_tersangka = mysqli_real_escape_string($db, $_POST['jumlah_tersangka']);
    $rincian_barang_bukti = mysqli_real_escape_string($db, $_POST['rincian_barang_bukti']);
    
    // Handle file upload
    $file_bukti = '';
    if (isset($_FILES['file_bukti']) && $_FILES['file_bukti']['error'] == 0) {
        $upload_dir = 'uploads/laporan_ditresnarkoba/';
        
        // Create directory if not exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = $_FILES['file_bukti']['name'];
        $file_tmp = $_FILES['file_bukti']['tmp_name'];
        $file_size = $_FILES['file_bukti']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Validasi extension
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx');
        if (in_array($file_ext, $allowed_ext)) {
            // Validasi size (max 10MB)
            if ($file_size <= 10485760) {
                $new_file_name = 'bukti_' . uniqid() . '_' . time() . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;
                
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $file_bukti = $upload_path;
                } else {
                    $error_message = 'Gagal mengupload file!';
                }
            } else {
                $error_message = 'Ukuran file terlalu besar (max 10MB)!';
            }
        } else {
            $error_message = 'Format file tidak diizinkan!';
        }
    }
    
    // Insert ke database (menggunakan tabel laporan_samapta karena strukturnya mirip)
    // Tapi bisa dibuat tabel baru laporan_ditresnarkoba jika diperlukan
    if (empty($error_message)) {
        $query = "INSERT INTO laporan_samapta 
                  (tanggal_lapor, nama_petugas, nrp_petugas, pangkat_petugas, jenis_kegiatan, kronologi, lokasi, jumlah_tersangka, rincian_barang_bukti, file_bukti, status_verifikasi, asal_laporan) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'baru', 'Ditresnarkoba Internal')";
        
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "sssssssis", $tanggal_kegiatan, $nama_petugas, $nrp_petugas, $pangkat_petugas, $jenis_kegiatan, $kronologi, $lokasi, $jumlah_tersangka, $rincian_barang_bukti, $file_bukti);
        
        if (mysqli_stmt_execute($stmt)) {
            $success_message = 'Laporan kegiatan berhasil disimpan!';
            
            // Redirect to prevent resubmit
            echo '<script>setTimeout(function(){ window.location.href = "dash.php?page=input-laporan-ditresnarkoba&success=1"; }, 2000);</script>';
        } else {
            $error_message = 'Gagal menyimpan laporan: ' . mysqli_error($db);
        }
        
        mysqli_stmt_close($stmt);
    }
}

// Show success message from redirect
if (isset($_GET['success'])) {
    $success_message = 'Laporan kegiatan berhasil disimpan!';
}

// Get petugas info from session
$nama_petugas_default = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
?>

<style>
    .form-section {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-section h5 {
        color: #667eea;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control:focus, .form-control-file:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .info-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .info-box h4 {
        margin: 0 0 10px 0;
        font-weight: 700;
    }

    .info-box p {
        margin: 0;
        opacity: 0.9;
    }

    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .file-upload-label {
        display: block;
        padding: 15px 20px;
        background: #f8f9fa;
        border: 2px dashed #667eea;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-label:hover {
        background: #e9ecef;
        border-color: #764ba2;
    }

    .file-upload-label i {
        font-size: 2rem;
        color: #667eea;
        margin-bottom: 10px;
    }

    .file-info {
        margin-top: 10px;
        padding: 10px;
        background: #e7f3ff;
        border-left: 4px solid #667eea;
        border-radius: 5px;
        display: none;
    }

    .required-mark {
        color: #dc3545;
        font-weight: bold;
    }

    .input-group-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        font-weight: 600;
    }

    .jenis-kegiatan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 10px;
    }

    .jenis-item {
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .jenis-item:hover {
        border-color: #667eea;
        background: #f8f9ff;
    }

    .jenis-item input[type="radio"] {
        display: none;
    }

    .jenis-item input[type="radio"]:checked + label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
    }

    .jenis-item label {
        margin: 0;
        cursor: pointer;
        font-weight: 600;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Input Laporan Kegiatan Ditresnarkoba</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dash.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Input Laporan</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a class="btn btn-secondary" href="dash.php">
                <i class="icon-copy dw dw-left-arrow"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<?php if ($success_message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><i class="icon-copy dw dw-checked"></i> Berhasil!</strong> <?php echo $success_message; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($error_message): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="icon-copy dw dw-warning"></i> Error!</strong> <?php echo $error_message; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Info Box -->
<div class="info-box">
    <h4>📋 Laporan Kegiatan Internal</h4>
    <p>Form ini digunakan untuk melaporkan kegiatan internal Ditresnarkoba seperti penangkapan, pengungkapan kasus, pengawalan, dan kegiatan operasional lainnya.</p>
</div>

<!-- Form Input -->
<form method="POST" enctype="multipart/form-data" id="form-laporan">
    
    <!-- Section 1: Informasi Kegiatan -->
    <div class="form-section">
        <h5>📅 Informasi Kegiatan</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tanggal Kegiatan <span class="required-mark">*</span></label>
                    <input class="form-control" type="datetime-local" name="tanggal_kegiatan" required>
                    <small class="form-text text-muted">Tanggal dan waktu pelaksanaan kegiatan</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Sprint/Surat <span class="required-mark">*</span></label>
                    <input class="form-control" type="text" name="no_sprint" 
                           placeholder="Contoh: SPRINT-001/2025" 
                           required>
                    <small class="form-text text-muted">Nomor sprint atau nomor surat tugas</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Lokasi Kegiatan <span class="required-mark">*</span></label>
                    <input class="form-control" type="text" name="lokasi" 
                           placeholder="Alamat lengkap lokasi" 
                           required>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Jenis Kegiatan -->
    <div class="form-section">
        <h5>🎯 Jenis Kegiatan</h5>
        <p class="text-muted mb-3">Pilih salah satu jenis kegiatan yang dilakukan</p>
        
        <div class="jenis-kegiatan-grid">
            <div class="jenis-item">
                <input type="radio" name="jenis_kegiatan" value="Penangkapan" id="jenis1" required>
                <label for="jenis1">
                    <div class="mb-2"><i class="icon-copy dw dw-user1" style="font-size: 2rem;"></i></div>
                    Penangkapan
                </label>
            </div>
            <div class="jenis-item">
                <input type="radio" name="jenis_kegiatan" value="Pengungkapan" id="jenis2">
                <label for="jenis2">
                    <div class="mb-2"><i class="icon-copy dw dw-search" style="font-size: 2rem;"></i></div>
                    Pengungkapan
                </label>
            </div>
            <div class="jenis-item">
                <input type="radio" name="jenis_kegiatan" value="Pengawalan" id="jenis3">
                <label for="jenis3">
                    <div class="mb-2"><i class="icon-copy dw dw-shield" style="font-size: 2rem;"></i></div>
                    Pengawalan
                </label>
            </div>
            <div class="jenis-item">
                <input type="radio" name="jenis_kegiatan" value="Razia" id="jenis4">
                <label for="jenis4">
                    <div class="mb-2"><i class="icon-copy dw dw-analytics-21" style="font-size: 2rem;"></i></div>
                    Razia
                </label>
            </div>
            <div class="jenis-item">
                <input type="radio" name="jenis_kegiatan" value="Patroli" id="jenis5">
                <label for="jenis5">
                    <div class="mb-2"><i class="icon-copy dw dw-car" style="font-size: 2rem;"></i></div>
                    Patroli
                </label>
            </div>
            <div class="jenis-item">
                <input type="radio" name="jenis_kegiatan" value="Lainnya" id="jenis6">
                <label for="jenis6">
                    <div class="mb-2"><i class="icon-copy dw dw-more" style="font-size: 2rem;"></i></div>
                    Lainnya
                </label>
            </div>
        </div>
    </div>

    <!-- Section 3: Informasi Petugas -->
    <div class="form-section">
        <h5>👮 Informasi Petugas</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nama Petugas <span class="required-mark">*</span></label>
                    <input class="form-control" type="text" name="nama_petugas" 
                           value="<?php echo htmlspecialchars($nama_petugas_default); ?>"
                           placeholder="Nama lengkap petugas" 
                           required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>NRP <span class="required-mark">*</span></label>
                    <input class="form-control" type="text" name="nrp_petugas" 
                           placeholder="Contoh: 85010123" 
                           required>
                    <small class="form-text text-muted">Nomor Registrasi Pokok</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pangkat <span class="required-mark">*</span></label>
                    <select class="form-control" name="pangkat_petugas" required>
                        <option value="">-- Pilih Pangkat --</option>
                        <option value="AKBP">AKBP</option>
                        <option value="Kompol">Kompol</option>
                        <option value="AKP">AKP</option>
                        <option value="Iptu">Iptu</option>
                        <option value="Aiptu">Aiptu</option>
                        <option value="Ipda">Ipda</option>
                        <option value="Aipda">Aipda</option>
                        <option value="Bripka">Bripka</option>
                        <option value="Brigadir">Brigadir</option>
                        <option value="Abrip">Abrip</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 4: Kronologi & Detail -->
    <div class="form-section">
        <h5>📝 Kronologi & Detail Kegiatan</h5>
        
        <div class="form-group">
            <label>Kronologi Kegiatan <span class="required-mark">*</span></label>
            <textarea class="form-control" name="kronologi" rows="8" 
                      placeholder="Jelaskan secara detail kronologi kegiatan:&#10;- Waktu pelaksanaan&#10;- Proses kegiatan&#10;- Hasil yang dicapai&#10;- Kendala yang dihadapi (jika ada)&#10;- Informasi tambahan"
                      required></textarea>
            <small class="form-text text-muted">Jelaskan kronologi kegiatan secara lengkap dan detail</small>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Jumlah Tersangka <span class="required-mark">*</span></label>
                    <div class="input-group">
                        <input class="form-control" type="number" name="jumlah_tersangka" 
                               value="0" min="0" required>
                        <div class="input-group-append">
                            <span class="input-group-text">orang</span>
                        </div>
                    </div>
                    <small class="form-text text-muted">Jumlah tersangka yang diamankan (isi 0 jika tidak ada)</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Rincian Barang Bukti <span class="required-mark">*</span></label>
                    <input class="form-control" type="text" name="rincian_barang_bukti" 
                           placeholder="Contoh: 20 gram sabu-sabu, 5 butir ekstasi" 
                           required>
                    <small class="form-text text-muted">Sebutkan jenis dan jumlah barang bukti (isi '-' jika tidak ada)</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 5: Upload File -->
    <div class="form-section">
        <h5>📎 Upload File Bukti</h5>
        <p class="text-muted mb-3">Upload dokumentasi kegiatan (foto, dokumen, atau laporan). Maksimal 10MB.</p>
        
        <div class="file-upload-wrapper">
            <input type="file" name="file_bukti" id="file-input" accept="image/*,.pdf,.doc,.docx">
            <label for="file-input" class="file-upload-label">
                <i class="icon-copy dw dw-upload"></i>
                <div><strong>Klik untuk upload file</strong></div>
                <div class="small mt-2 text-muted">Format: JPG, PNG, PDF, DOC, DOCX | Max: 10MB</div>
            </label>
        </div>

        <div class="file-info" id="file-info">
            <strong>File terpilih:</strong> <span id="file-name"></span> (<span id="file-size"></span>)
        </div>
    </div>

    <!-- Submit Button -->
    <div class="form-section text-center">
        <button type="submit" class="btn btn-submit" id="submit-btn">
            <i class="icon-copy dw dw-diskette"></i> Simpan Laporan Kegiatan
        </button>
        <button type="reset" class="btn btn-secondary ml-2">
            <i class="icon-copy dw dw-refresh"></i> Reset Form
        </button>
    </div>

</form>

<!-- Recent Reports -->
<div class="card mt-4" style="border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
        <h5 class="mb-0">📋 Laporan Kegiatan Terbaru</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal</th>
                        <th>Jenis Kegiatan</th>
                        <th>Petugas</th>
                        <th>Lokasi</th>
                        <th width="100">Tersangka</th>
                        <th width="120">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get recent reports (from laporan_samapta with asal_laporan = 'Ditresnarkoba Internal')
                    $query_recent = "SELECT * FROM laporan_samapta 
                                    WHERE asal_laporan = 'Ditresnarkoba Internal'
                                    ORDER BY tanggal_lapor DESC 
                                    LIMIT 5";
                    $result_recent = mysqli_query($db, $query_recent);
                    
                    $no = 1;
                    if (mysqli_num_rows($result_recent) > 0):
                        while ($row = mysqli_fetch_assoc($result_recent)):
                            $status_class = 'secondary';
                            if ($row['status_verifikasi'] == 'baru') $status_class = 'warning';
                            elseif ($row['status_verifikasi'] == 'diproses') $status_class = 'info';
                            elseif ($row['status_verifikasi'] == 'selesai') $status_class = 'success';
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('d M Y', strtotime($row['tanggal_lapor'])); ?></td>
                            <td><strong><?php echo htmlspecialchars($row['jenis_kegiatan']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['pangkat_petugas'] . ' ' . $row['nama_petugas']); ?></td>
                            <td><?php echo htmlspecialchars($row['lokasi']); ?></td>
                            <td class="text-center"><?php echo $row['jumlah_tersangka']; ?> orang</td>
                            <td>
                                <span class="badge badge-<?php echo $status_class; ?>">
                                    <?php echo ucfirst($row['status_verifikasi']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="icon-copy dw dw-file" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="mb-0 mt-2">Belum ada laporan kegiatan</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // File input change handler
    document.getElementById('file-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileInfo = document.getElementById('file-info');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            fileInfo.style.display = 'block';
            
            // Validate file size
            if (file.size > 10485760) {
                alert('Ukuran file terlalu besar! Maksimal 10MB.');
                e.target.value = '';
                fileInfo.style.display = 'none';
            }
        }
    });

    // Form submit handler
    document.getElementById('form-laporan').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.innerHTML = '<i class="icon-copy dw dw-loading"></i> Menyimpan...';
        submitBtn.disabled = true;
    });

    // Jenis kegiatan selection effect
    document.querySelectorAll('.jenis-item').forEach(item => {
        item.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Remove active class from all items
            document.querySelectorAll('.jenis-item').forEach(i => {
                i.style.borderColor = '#e9ecef';
                i.style.background = 'white';
            });
            
            // Add active class to selected item
            this.style.borderColor = '#667eea';
            this.style.background = '#f8f9ff';
        });
    });

    // Auto dismiss alert
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Set default datetime to now
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.querySelector('input[name="tanggal_kegiatan"]').value = now.toISOString().slice(0, 16);
</script>