<?php
// Get current page
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Get user role from session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User';

// Format role display
$role_display = ucfirst($role);
if ($role == 'ditresnarkoba') $role_display = 'Ditresnarkoba';
if ($role == 'ditsamapta') $role_display = 'Ditsamapta';
if ($role == 'ditbinmas') $role_display = 'Ditbinmas';
?>

<style>
    .brand-logo-custom {
        padding: 20px 25px;
        background: linear-gradient(135deg, #1E40AF 0%, #1E3A8A 100%);
        border-bottom: 3px solid #FFD700;
    }
    
    .brand-logo-custom a {
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    
    .logo-svg {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    
    .logo-svg:hover {
        transform: scale(1.1);
    }
    
    .brand-text {
        color: #FFD700;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-left: 12px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .user-info-sidebar {
        background: #f8f9fa;
        padding: 15px;
        margin: 15px;
        border-radius: 10px;
        border-left: 4px solid #667eea;
    }
    
    .user-info-sidebar .user-name {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        margin-bottom: 3px;
    }
    
    .user-info-sidebar .user-role {
        color: #6c757d;
        font-size: 0.8rem;
    }
    
    .sidebar-small-cap {
        color: #667eea !important;
        font-weight: 700 !important;
    }
    
    /* Active menu styling */
    .sidebar-menu ul li a.active {
        background: linear-gradient(135deg, #000000ff 0%, #242404ff 100%);
        color: white !important;
    }
    
    .sidebar-menu ul li a.active .micon,
    .sidebar-menu ul li a.active .mtext {
        color: white !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .brand-text {
            font-size: 14px;
        }
        
        .logo-svg {
            width: 40px;
            height: 40px;
        }
    }
</style>

<div class="left-side-bar">
    <div class="brand-logo brand-logo-custom">
        <a href="dash.php">
            <!-- Logo POLRI SVG -->
            <svg class="logo-svg" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="gold" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#FFD700"/>
                        <stop offset="100%" style="stop-color:#FFA500"/>
                    </linearGradient>
                    <linearGradient id="blue" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#1E40AF"/>
                        <stop offset="100%" style="stop-color:#1E3A8A"/>
                    </linearGradient>
                </defs>
                <circle cx="40" cy="40" r="38" fill="url(#blue)" stroke="url(#gold)" stroke-width="2"/>
                <path d="M 40 12 L 60 20 L 60 42 Q 60 55 40 65 Q 20 55 20 42 L 20 20 Z" 
                      fill="url(#gold)" stroke="#1E3A8A" stroke-width="1.5"/>
                <path d="M 40 16 L 56 22 L 56 40 Q 56 50 40 58 Q 24 50 24 40 L 24 22 Z" 
                      fill="url(#blue)" stroke="url(#gold)" stroke-width="1"/>
                <path d="M 40 28 L 42 34 L 48 34 L 43 38 L 45 44 L 40 40 L 35 44 L 37 38 L 32 34 L 38 34 Z" 
                      fill="#FFD700" stroke="#FFF" stroke-width="0.5"/>
                <path d="M 20 35 Q 12 32 10 38 Q 12 40 18 38 Z" fill="#FFD700" opacity="0.8"/>
                <path d="M 60 35 Q 68 32 70 38 Q 68 40 62 38 Z" fill="#FFD700" opacity="0.8"/>
                <text x="40" y="72" font-family="Arial" font-size="8" font-weight="bold" 
                      fill="#FFD700" text-anchor="middle">POLRI</text>
            </svg>
            
            <span class="brand-text">DITRESNARKOBA</span>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    

    
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                
                <!-- Dashboard -->
                <li>
                    <a href="dash.php?page=dashboard" class="dropdown-toggle no-arrow <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>">
                        <span class="micon dw dw-home"></span>
                        <span class="mtext">Dashboard</span>
                    </a>
                </li>

                <!-- Menu untuk Ditresnarkoba -->
                <?php if($role == 'ditresnarkoba'): ?>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">🚔 Ditresnarkoba</div>
                </li>
                <li>
                    <a href="dash.php?page=laporan-ditsamapta" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-analytics-21"></span>
                        <span class="mtext">Laporan Ditsamapta</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=laporan-ditbinmas" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-analytics-21"></span>
                        <span class="mtext">Laporan Ditbinmas</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=input-pengungkapan" class="dropdown-toggle no-arrow <?php echo $current_page == 'input-pengungkapan' ? 'active' : ''; ?>">
                        <span class="micon dw dw-file"></span>
                        <span class="mtext">Input Pengungkapan</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=input-laporan-ditresnarkoba" class="dropdown-toggle no-arrow <?php echo $current_page == 'input-laporan-ditresnarkoba' ? 'active' : ''; ?>">
                        <span class="micon dw dw-file-75"></span>
                        <span class="mtext">Input Laporan Kegiatan</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Menu untuk Ditsamapta -->
                <?php if($role == 'ditsamapta'): ?>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">🚨 Ditsamapta</div>
                </li>
                <li>
                    <a href="dash.php?page=laporan-ditbinmas" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-analytics-21"></span>
                        <span class="mtext">Laporan Ditbinmas</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=laporan-ditresnarkoba" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-analytics-21"></span>
                        <span class="mtext">Laporan Ditresnarkoba</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=laporan-ditsamapta" class="dropdown-toggle no-arrow <?php echo $current_page == 'laporan-ditsamapta' ? 'active' : ''; ?>">
                        <span class="micon dw dw-analytics-21"></span>
                        <span class="mtext">Laporan Ditsamapta</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=input-laporan-ditsamapta" class="dropdown-toggle no-arrow <?php echo $current_page == 'input-laporan-ditsamapta' ? 'active' : ''; ?>">
                        <span class="micon dw dw-add-file"></span>
                        <span class="mtext">Input Laporan</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Menu untuk Ditbinmas -->
                <?php if($role == 'ditbinmas'): ?>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                    <div class="sidebar-small-cap">👥 laporan tim</div>
                <li>
                    <a href="dash.php?page=laporan-ditsamapta" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-analytics-21"></span>
                        <span class="mtext">Laporan Ditsamapta</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=laporan-ditresnarkoba" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-analytics-21"></span>
                        <span class="mtext">Laporan Ditresnarkoba</span>
                    </a>
                </li>
                <li>
                    <div class="sidebar-small-cap">👥 Ditbinmas</div>
                </li>
                <li>
                    <a href="dash.php?page=laporan-ditbinmas" class="dropdown-toggle no-arrow <?php echo $current_page == 'laporan-ditbinmas' ? 'active' : ''; ?>">
                        <span class="micon dw dw-analytics-21"></span>
                        <span class="mtext">Laporan Ditbinmas</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=input-kegiatan" class="dropdown-toggle no-arrow <?php echo $current_page == 'input-kegiatan' ? 'active' : ''; ?>">
                        <span class="micon dw dw-add-file"></span>
                        <span class="mtext">Input Kegiatan</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Menu Umum (Semua Role) -->
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">📢 Pengaduan Masyarakat</div>
                </li>
                <li>
                    <a href="dash.php?page=input-pengaduan" class="dropdown-toggle no-arrow <?php echo $current_page == 'input-pengaduan' ? 'active' : ''; ?>">
                        <span class="micon dw dw-add-file"></span>
                        <span class="mtext">Input Pengaduan</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=lihat-pengaduan" class="dropdown-toggle no-arrow <?php echo ($current_page == 'lihat-pengaduan' || $current_page == 'detail-pengaduan') ? 'active' : ''; ?>">
                        <span class="micon dw dw-list"></span>
                        <span class="mtext">Lihat Pengaduan</span>
                    </a>
                </li>

                <!-- Menu Berita -->
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">📰 Berita & Informasi</div>
                </li>
                <li>
                    <a href="dash.php?page=input-berita" class="dropdown-toggle no-arrow <?php echo $current_page == 'input-berita' ? 'active' : ''; ?>">
                        <span class="micon dw dw-newspaper"></span>
                        <span class="mtext">Input Berita</span>
                    </a>
                </li>
                <li>
                    <a href="dash.php?page=lihat-berita" class="dropdown-toggle no-arrow <?php echo $current_page == 'lihat-berita' ? 'active' : ''; ?>">
                        <span class="micon dw dw-book"></span>
                        <span class="mtext">Lihat Berita</span>
                    </a>
                </li>

                <!-- Menu Settings & Logout -->
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a href="dash.php?page=profile" class="dropdown-toggle no-arrow <?php echo $current_page == 'profile' ? 'active' : ''; ?>">
                        <span class="micon dw dw-user1"></span>
                        <span class="mtext">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-logout"></span>
                        <span class="mtext">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>