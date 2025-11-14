<?php
// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_berita = (int)$_GET['id'];
    
    // Get file to delete
    $query_file = "SELECT gambar_berita FROM tabel_berita WHERE id_berita = ?";
    $stmt_file = mysqli_prepare($db, $query_file);
    mysqli_stmt_bind_param($stmt_file, "i", $id_berita);
    mysqli_stmt_execute($stmt_file);
    $result_file = mysqli_stmt_get_result($stmt_file);
    $file_data = mysqli_fetch_assoc($result_file);
    
    // Delete record
    $query_delete = "DELETE FROM tabel_berita WHERE id_berita = ?";
    $stmt_delete = mysqli_prepare($db, $query_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_berita);
    
    if (mysqli_stmt_execute($stmt_delete)) {
        // Delete file
        if ($file_data && !empty($file_data['gambar_berita'])) {
            $file_path = 'uploads/berita/' . $file_data['gambar_berita'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        echo '<script>alert("Berita berhasil dihapus!"); window.location.href="dash.php?page=lihat-berita";</script>';
    }
}
?>

<style>
    .news-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .news-card img {
        height: 250px;
        object-fit: cover;
        width: 100%;
    }

    .news-card .card-body {
        padding: 20px;
    }

    .news-card .card-title {
        font-weight: 700;
        color: #495057;
        margin-bottom: 10px;
        height: 50px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .news-card .card-text {
        color: #6c757d;
        height: 60px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .news-meta {
        font-size: 0.875rem;
        color: #6c757d;
        padding-top: 10px;
        border-top: 1px solid #e9ecef;
    }

    .filter-section {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .stats-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .stats-box h2 {
        font-size: 3rem;
        font-weight: 700;
        margin: 0;
    }

    .stats-box p {
        margin: 10px 0 0 0;
        opacity: 0.9;
    }

    .action-dropdown {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .action-dropdown .btn {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 5rem;
        opacity: 0.3;
        margin-bottom: 20px;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Lihat Berita</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dash.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lihat Berita</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a class="btn btn-primary" href="dash.php?page=input-berita">
                <i class="icon-copy dw dw-add"></i> Buat Berita Baru
            </a>
        </div>
    </div>
</div>

<!-- Stats Box -->
<div class="row">
    <div class="col-md-12">
        <div class="stats-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>
                        <?php 
                        $query_total = "SELECT COUNT(*) as total FROM tabel_berita";
                        $result_total = mysqli_query($db, $query_total);
                        echo mysqli_fetch_assoc($result_total)['total']; 
                        ?>
                    </h2>
                    <p class="mb-0">📰 Total Berita yang Dipublikasikan</p>
                </div>
                <div class="col-md-4 text-right">
                    <i class="icon-copy dw dw-newspaper" style="font-size: 5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <div class="row align-items-end">
        <div class="col-md-4">
            <label class="font-weight-600">Cari Berita:</label>
            <input type="text" class="form-control" id="search-input" placeholder="Cari judul berita...">
        </div>
        <div class="col-md-3">
            <label class="font-weight-600">Dari Tanggal:</label>
            <input type="date" class="form-control" id="filter-dari">
        </div>
        <div class="col-md-3">
            <label class="font-weight-600">Sampai Tanggal:</label>
            <input type="date" class="form-control" id="filter-sampai">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-block" onclick="filterBerita()">
                <i class="icon-copy dw dw-search"></i> Filter
            </button>
        </div>
    </div>
</div>

<!-- News Grid -->
<div class="row" id="news-container">
    <?php
    $query = "SELECT * FROM tabel_berita ORDER BY tanggal_upload DESC";
    $result = mysqli_query($db, $query);
    
    if (mysqli_num_rows($result) > 0):
        while ($row = mysqli_fetch_assoc($result)):
    ?>
        <div class="col-md-4 mb-30 news-item" 
             data-title="<?php echo strtolower($row['judul_berita']); ?>"
             data-date="<?php echo date('Y-m-d', strtotime($row['tanggal_upload'])); ?>">
            <div class="card news-card">
                <div class="position-relative">
                    <?php if ($row['gambar_berita']): ?>
                        <img src="uploads/berita/<?php echo htmlspecialchars($row['gambar_berita']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($row['judul_berita']); ?>">
                    <?php else: ?>
                        <img src="vendors/images/news-placeholder.jpg" 
                             class="card-img-top" 
                             alt="No Image">
                    <?php endif; ?>
                    
                    <div class="action-dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" onclick="viewDetail(<?php echo $row['id_berita']; ?>)">
                                    <i class="dw dw-eye"></i> Lihat Detail
                                </a>
                                <a class="dropdown-item" href="<?php echo htmlspecialchars($row['link_berita']); ?>" target="_blank">
                                    <i class="dw dw-share"></i> Buka Link
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" onclick="deleteBerita(<?php echo $row['id_berita']; ?>)">
                                    <i class="dw dw-delete-3"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['judul_berita']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['deskripsi_berita']); ?></p>
                    
                    <div class="news-meta">
                        <i class="icon-copy dw dw-calendar1"></i> 
                        <?php echo date('d M Y', strtotime($row['tanggal_upload'])); ?>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-top">
                    <button class="btn btn-sm btn-primary btn-block" onclick="viewDetail(<?php echo $row['id_berita']; ?>)">
                        <i class="dw dw-eye"></i> Lihat Selengkapnya
                    </button>
                </div>
            </div>
        </div>
    <?php 
        endwhile;
    else: 
    ?>
        <div class="col-12">
            <div class="empty-state">
                <i class="icon-copy dw dw-newspaper"></i>
                <h4>Belum Ada Berita</h4>
                <p class="text-muted">Mulai publikasikan berita pertama Anda!</p>
                <a href="dash.php?page=input-berita" class="btn btn-primary mt-3">
                    <i class="dw dw-add"></i> Buat Berita Baru
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<div id="no-results" style="display: none;">
    <div class="empty-state">
        <i class="icon-copy dw dw-search"></i>
        <h4>Tidak Ada Hasil</h4>
        <p class="text-muted">Tidak ditemukan berita yang sesuai dengan pencarian Anda</p>
    </div>
</div>

<!-- Modal Detail Berita -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Detail Berita</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img id="modal-image" src="" class="img-fluid mb-3 rounded" style="width: 100%; max-height: 400px; object-fit: cover;">
                <h4 id="modal-judul"></h4>
                <p class="text-muted" id="modal-tanggal"></p>
                <hr>
                <div id="modal-deskripsi"></div>
                <hr>
                <a id="modal-link" href="#" target="_blank" class="btn btn-primary">
                    <i class="dw dw-share"></i> Buka Link Lengkap
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Search functionality
    $('#search-input').on('keyup', function() {
        filterBerita();
    });

    // Filter berita
    function filterBerita() {
        var searchTerm = $('#search-input').val().toLowerCase();
        var dariTanggal = $('#filter-dari').val();
        var sampaiTanggal = $('#filter-sampai').val();
        
        var visibleCount = 0;
        
        $('.news-item').each(function() {
            var title = $(this).data('title');
            var date = $(this).data('date');
            
            var matchSearch = !searchTerm || title.includes(searchTerm);
            var matchDari = !dariTanggal || date >= dariTanggal;
            var matchSampai = !sampaiTanggal || date <= sampaiTanggal;
            
            if (matchSearch && matchDari && matchSampai) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });
        
        if (visibleCount === 0) {
            $('#no-results').show();
        } else {
            $('#no-results').hide();
        }
    }

    // View detail
    function viewDetail(id) {
        // Fetch berita data via AJAX or use data from page
        <?php
        $result2 = mysqli_query($db, "SELECT * FROM tabel_berita ORDER BY tanggal_upload DESC");
        while ($row2 = mysqli_fetch_assoc($result2)):
        ?>
        if (id === <?php echo $row2['id_berita']; ?>) {
            $('#modal-image').attr('src', 'uploads/berita/<?php echo htmlspecialchars($row2['gambar_berita']); ?>');
            $('#modal-judul').text('<?php echo addslashes($row2['judul_berita']); ?>');
            $('#modal-tanggal').html('<i class="dw dw-calendar1"></i> <?php echo date('d M Y, H:i', strtotime($row2['tanggal_upload'])); ?> WIB');
            $('#modal-deskripsi').html('<?php echo nl2br(addslashes($row2['deskripsi_berita'])); ?>');
            $('#modal-link').attr('href', '<?php echo htmlspecialchars($row2['link_berita']); ?>');
            $('#modalDetail').modal('show');
        }
        <?php endwhile; ?>
    }

    // Delete berita
    function deleteBerita(id) {
        if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
            window.location.href = 'dash.php?page=lihat-berita&action=delete&id=' + id;
        }
    }
</script>