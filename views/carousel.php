<div id="header-carousel" class="carousel slide" data-bs-ride="false">
    <div class="carousel-inner">
        <!-- Slide 1: Ditresnarkoba -->
        <div class="carousel-item active" data-team="ditresnarkoba">
            <video class="w-100 carousel-video" muted playsinline preload="auto" data-video-index="0">
                <source src="video/ditbinmas.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-overlay"></div>

            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="title mx-5 px-5 animated slideInDown">
                    <div class="title-center">
                        <h5 class="team-subtitle">Team</h5>
                        <h1 class="display-1 team-title">Ditresnarkoba</h1>
                    </div>
                </div>
                <p class="fs-5 mb-5 team-description animated slideInDown">
                    Melawan peredaran narkoba di Indonesia.<br>
                    Bersama menjaga masa depan yang lebih baik.
                </p>
                <button class="btn btn-outline-primary border-2 py-3 px-5  btn-lapor-hero">
                    <i class="bi bi-megaphone-fill"></i> LAPOR SEKARANG!
                </button>
            </div>
        </div>
        <!-- Slide 2: Ditsamapta -->
        <div class="carousel-item" data-team="ditsamapta">
            <video class="w-100 carousel-video" muted playsinline preload="auto" data-video-index="1">
                <source src="video/ditsamapta.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <!-- Overlay gelap untuk readability -->
            <div class="video-overlay"></div>

            <!-- Caption khusus Ditsamapta -->
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="title mx-5 px-5 animated slideInDown">
                    <div class="title-center">
                        <h5 class="team-subtitle">Team</h5>
                        <h1 class="display-1 team-title">Ditsamapta</h1>
                    </div>
                </div>
                <p class="fs-5 mb-5 team-description animated slideInDown">
                    Mendorong kemandirian masyarakat.<br>
                    Bersama membangun keamanan bersama.
                </p>
                <button class="btn btn-outline-primary border-2 py-3 px-5  btn-lapor-hero">
                    <i class="bi bi-megaphone-fill"></i> LAPOR SEKARANG!
                </button>
            </div>
        </div>

        <!-- Slide 3: Ditbinmas -->
        <div class="carousel-item" data-team="ditbinmas">
            <video class="w-100 carousel-video" muted playsinline preload="auto" data-video-index="2">
                <source src="video/ditbinmas.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <!-- Overlay gelap untuk readability -->
            <div class="video-overlay"></div>

            <!-- Caption khusus Ditbinmas -->
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="title mx-5 px-5 animated slideInDown">
                    <div class="title-center">
                        <h5 class="team-subtitle">Team</h5>
                        <h1 class="display-1 team-title">Ditbinmas</h1>
                    </div>
                </div>
                <p class="fs-5 mb-5 team-description animated slideInDown">
                    Meningkatkan kesejahteraan masyarakat.<br>
                    Bersama menciptakan lingkungan yang aman.
                </p>
                <button class="btn btn-outline-primary border-2 py-3 px-5 btn-lapor-hero">
                    <i class="bi bi-megaphone-fill"></i> LAPOR SEKARANG!
                </button>
            </div>
        </div>

        <!-- Carousel Indicators -->
        <div class="carousel-indicators">

        </div>
    </div>

    <style>
        /* Video Carousel Styling */
        .carousel-video {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            display: block;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.3) 0%,
                    rgba(0, 0, 0, 0.5) 50%,
                    rgba(0, 0, 0, 0.7) 100%);
            z-index: 1;
        }

        .carousel-caption {
            z-index: 10;
            padding: 30px;
            border-radius: 15px;
            background: transparent !important;
        }

        .team-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .team-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #fff;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
            line-height: 1.2;
        }

        .team-description {
            font-size: 1.3rem;
            line-height: 1.8;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            max-width: 700px;
        }

        .carousel-caption .btn {
            font-size: 1.1rem;
            padding: 12px 40px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .carousel-caption .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        .btn-lapor-hero {
            animation: pulseButton 2s infinite;
        }

        @keyframes pulseButton {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
            }
        }

        .btn-lapor-hero:hover {
            animation: none;
        }

        .carousel-item {
            transition: transform 0.6s ease-in-out;
        }

        .animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        @keyframes slideInDown {
            from {
                transform: translate3d(0, -100%, 0);
                opacity: 0;
            }

            to {
                transform: translate3d(0, 0, 0);
                opacity: 1;
            }
        }

        .slideInDown {
            animation-name: slideInDown;
        }

        .carousel-indicators {
            bottom: 30px;
            z-index: 15;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 8px;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid #fff;
            transition: all 0.3s ease;
        }

        .carousel-indicators button.active {
            background-color: #fff;
            transform: scale(1.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .carousel-video {
                height: 70vh;
            }

            .team-title {
                font-size: 2.5rem !important;
            }

            .team-subtitle {
                font-size: 1rem;
            }

            .team-description {
                font-size: 1rem;
                padding: 0 20px;
            }

            .carousel-caption {
                padding: 15px;
            }

            .carousel-caption .btn {
                font-size: 0.9rem;
                padding: 10px 30px;
            }
        }

        @media (max-width: 576px) {
            .carousel-video {
                height: 60vh;
            }

            .team-title {
                font-size: 2rem !important;
            }

            .team-description {
                font-size: 0.9rem;
            }
        }

        .carousel-video:not([src]) {
            background: #0d1217;
        }

        .carousel-item:not(.active) .carousel-caption {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .carousel-item.active .carousel-caption {
            opacity: 1;
            transition: opacity 0.3s ease 0.3s;
        }

        .carousel-item {
            opacity: 0;
            transition: opacity 0.6s ease;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .carousel-item.active {
            opacity: 1;
            position: relative;
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        .fade-out {
            animation: fadeOut 0.6s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('header-carousel');
            const carouselInstance = new bootstrap.Carousel(carousel, {
                interval: false,
                ride: false,
                pause: false
            });

            const videos = document.querySelectorAll('.carousel-video');
            const carouselItems = document.querySelectorAll('.carousel-item');
            let currentVideoIndex = 0;
            let transitioning = false; // pindahkan ke atas agar variabel tersedia lebih awal



            // === Fungsi utama ===
            function playActiveVideo() {
                videos.forEach((video, index) => {
                    if (index === currentVideoIndex) {
                        const teamName = carouselItems[index].dataset.team;

                        video.currentTime = 0;
                        const playPromise = video.play();

                        if (playPromise !== undefined) {
                            playPromise.catch(() => {

                                document.addEventListener('click', function playOnClick() {
                                    video.play();
                                    document.removeEventListener('click', playOnClick);
                                }, {
                                    once: true
                                });
                            });
                        }
                    } else {
                        video.pause();
                        video.currentTime = 0;
                    }
                });
            }

            function pauseAllVideos() {
                videos.forEach(video => video.pause());
            }

            function animateCaption(index) {
                const caption = carouselItems[index].querySelector('.carousel-caption');
                if (!caption) return;
                const animatedElements = caption.querySelectorAll('.animated');
                animatedElements.forEach(el => el.classList.remove('slideInDown'));
                void caption.offsetWidth;
                setTimeout(() => {
                    animatedElements.forEach(el => el.classList.add('slideInDown'));
                }, 50);
            }

            // === Transisi halus antar video ===
            function smoothTransition(toIndex) {
                if (transitioning) return;
                transitioning = true;

                const currentItem = carouselItems[currentVideoIndex];
                const nextItem = carouselItems[toIndex];

                currentItem.classList.add('fade-out');
                nextItem.classList.add('fade-in', 'active');
                currentItem.classList.remove('active');

                setTimeout(() => {
                    currentItem.classList.remove('fade-out');
                    nextItem.classList.remove('fade-in');
                    currentVideoIndex = toIndex;
                    transitioning = false;
                    playActiveVideo();
                    animateCaption(toIndex);
                }, 600);
            }

            // === Event saat video selesai ===
            videos.forEach((video, index) => {
                video.addEventListener('ended', () => {
                    const nextIndex = (index + 1) % videos.length;
                    smoothTransition(nextIndex);
                });

                video.addEventListener('play', () => {

                });

                video.addEventListener('error', e => {
                    console.error(`❌ Error loading video ${index}:`, e);
                });
            });

            // === Pause saat tab tidak aktif ===
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    pauseAllVideos();
                } else {
                    playActiveVideo();
                }
            });

            // === Auto-play video pertama ===
            playActiveVideo();
            animateCaption(0);

            // === Tombol LAPOR SEKARANG ===
            const btnLaporHero = document.querySelectorAll('.btn-lapor-hero');
            btnLaporHero.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

                    if (isLoggedIn) {

                        const modal = new bootstrap.Modal(document.getElementById('modalLaporan'));
                        modal.show();
                    } else {

                        const modal = new bootstrap.Modal(document.getElementById('modalLogin'));
                        modal.show();
                    }
                });
            });
        });
    </script>