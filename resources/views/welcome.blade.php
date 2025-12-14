<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST - Future Alumni & Student Tracker</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#1e40af', /* Blue 800 */
                        secondary: '#f59e0b', /* Amber 500 */
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Smooth Scrolling */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white shadow-md fixed w-full z-50 top-0 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="flex items-center gap-2">
                        <div class="bg-primary text-white p-2 rounded-lg font-bold text-xl">
                            FAST
                        </div>
                        <div class="hidden md:block">
                            <span class="block font-bold text-gray-900 leading-tight">Future Alumni</span>
                            <span class="block text-xs text-gray-500 font-medium tracking-wider">& Student Tracker</span>
                        </div>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-600 hover:text-primary font-medium transition">Beranda</a>
                    <a href="#fitur" class="text-gray-600 hover:text-primary font-medium transition">Fitur</a>
                    <a href="#statistik" class="text-gray-600 hover:text-primary font-medium transition">Statistik</a>
                    <a href="#faq" class="text-gray-600 hover:text-primary font-medium transition">FAQ</a>
                    <a href="/login" class="bg-primary hover:bg-blue-800 text-white px-5 py-2.5 rounded-full font-semibold transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Login Alumni
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-primary focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="md:hidden hidden bg-white border-t" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#home" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md">Beranda</a>
                <a href="#fitur" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md">Fitur</a>
                <a href="#statistik" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md">Statistik</a>
                <a href="/admin" class="block w-full text-center mt-4 bg-primary text-white px-4 py-3 rounded-lg font-bold">Login Alumni</a>
            </div>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100 opacity-50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-yellow-100 opacity-50 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-3xl mx-auto">
                <span class="bg-blue-50 text-primary px-4 py-1.5 rounded-full text-sm font-semibold tracking-wide uppercase mb-6 inline-block">
                    Sistem Tracer Study Terintegrasi
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6 leading-tight">
                    Jembatan Karir & <span class="text-primary">Jejak Alumni</span> Masa Depan
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-10 leading-relaxed">
                    FAST membantu Program Studi memetakan sebaran lulusan, memvalidasi prestasi, 
                    dan meningkatkan kualitas kurikulum berdasarkan data nyata dari dunia kerja.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#start" class="px-8 py-4 bg-primary text-white text-lg font-bold rounded-xl shadow-lg hover:bg-blue-800 transition transform hover:-translate-y-1">
                        Isi Tracer Study
                    </a>
                    <a href="#learn-more" class="px-8 py-4 bg-white text-gray-700 border border-gray-300 text-lg font-bold rounded-xl hover:bg-gray-50 transition">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="statistik" class="py-12 bg-white border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-4">
                    <p class="text-4xl font-bold text-primary mb-2">1,200+</p>
                    <p class="text-gray-500 font-medium">Alumni Terdata</p>
                </div>
                <div class="p-4">
                    <p class="text-4xl font-bold text-secondary mb-2">85%</p>
                    <p class="text-gray-500 font-medium">Bekerja < 6 Bulan</p>
                </div>
                <div class="p-4">
                    <p class="text-4xl font-bold text-primary mb-2">50+</p>
                    <p class="text-gray-500 font-medium">Mitra Perusahaan</p>
                </div>
                <div class="p-4">
                    <p class="text-4xl font-bold text-gray-800 mb-2">350+</p>
                    <p class="text-gray-500 font-medium">Prestasi Tercatat</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan FAST</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Sistem yang dirancang untuk memudahkan alumni memberikan umpan balik dan memudahkan prodi mengelola data.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 text-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tracer Study Digital</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kuesioner standar DIKTI yang mudah diisi, mencakup status pekerjaan, relevansi kurikulum, dan evaluasi fasilitas kampus.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-yellow-100 text-secondary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Rekam Prestasi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Alumni dapat mengunggah portofolio dan sertifikat prestasi (Nasional/Internasional) untuk divalidasi oleh prodi.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analisis Kesenjangan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Fitur <i>Gap Analysis</i> untuk membandingkan kompetensi yang diajarkan di kampus dengan kebutuhan nyata di industri.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Langkah Mudah Berpartisipasi</h2>
                    <div class="space-y-8">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-primary text-white font-bold text-xl">1</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Login Alumni</h4>
                                <p class="mt-1 text-gray-600">Gunakan NIM dan Tanggal Lahir (atau password yang diberikan) untuk masuk ke dashboard.</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-primary text-white font-bold text-xl">2</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Update Profil & Kuesioner</h4>
                                <p class="mt-1 text-gray-600">Lengkapi data pekerjaan saat ini dan isi kuesioner tracer study (hanya butuh 5-10 menit).</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-primary text-white font-bold text-xl">3</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Upload Prestasi</h4>
                                <p class="mt-1 text-gray-600">Punya pencapaian membanggakan? Upload sertifikatnya untuk database akreditasi prodi.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gray-100 rounded-3xl p-8 border-2 border-dashed border-gray-300 text-center min-h-[400px] flex flex-col items-center justify-center">
                        <svg class="w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <p class="text-gray-500 font-medium">Ilustrasi Dashboard FAST</p>
                        <p class="text-sm text-gray-400 mt-2">(Tempatkan screenshot aplikasi di sini)</p>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-secondary rounded-full opacity-20 blur-xl"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-primary py-16">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl font-bold text-white mb-4">Kontribusi Anda Sangat Berarti</h2>
            <p class="text-blue-100 text-lg mb-8">Data yang Anda berikan akan digunakan untuk pengembangan kurikulum dan peningkatan akreditasi Program Studi kita.</p>
            <a href="/admin" class="inline-block bg-white text-primary font-bold py-4 px-8 rounded-xl shadow-lg hover:bg-gray-100 transition duration-300">
                Masuk ke Dashboard
            </a>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-white text-xl font-bold mb-4">FAST System</h3>
                    <p class="text-sm leading-relaxed text-gray-400">
                        Sistem Informasi Tracer Study & Rekam Jejak Prestasi Alumni. <br>
                        Dikembangkan untuk memajukan kualitas pendidikan tinggi.
                    </p>
                </div>
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Panduan Pengisian</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak Admin Prodi</a></li>
                        <li><a href="#" class="hover:text-white transition">Website Utama Kampus</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            prodi@kampus.ac.id
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            (0761) 123456
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
                &copy; 2024 FAST - Future Alumni & Student Tracker. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>