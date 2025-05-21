<!-- filepath: e:\Kelas-12\Joki\Okami\okami-dimsum\resources\views\about-us.blade.php -->
@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-cover bg-center h-[300px] md:h-[400px]" style="background-image: url('{{ asset('images/bannerhd.jpg') }}')">
        <div class="absolute inset-0 bg-dark bg-opacity-70"></div>
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Tentang Okami Dimsum</h1>
            <p class="text-lg text-light max-w-xl">
                Semangat untuk dimsum autentik dan komitmen terhadap bahan-bahan berkualitas
            </p>
        </div>
    </div>

    <!-- Our Story Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <img src="{{ asset('images/about-us.jpg') }}" alt="Cerita Kami" class="rounded-lg shadow-lg w-full h-auto object-cover">
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-accent rounded-xl flex items-center justify-center shadow-md hidden md:flex">
                        <span class="font-bold text-dark text-xl">Sejak<br>2019</span>
                    </div>
                </div>
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold text-dark">Cerita Kami</h2>
                    <div class="h-1 w-16 bg-primary rounded-full"></div>
                    <p class="text-gray-600">
                        Dimsum berasal dari wilayah selatan Tiongkok, terutama Guangdong (Kanton). Tradisi makan dimsum berawal dari kebiasaan para pedagang dan pelancong yang beristirahat di rumah teh di sepanjang Jalur Sutra. Rumah teh ini mulai menyajikan makanan kecil untuk Menemani minum teh, yang kemudian berkembang menjadi budaya "yum cha". Dimsum bukan sekadar makanan, tapi juga simbol kebersamaan dan tradisi sosial dalam budaya Tiongkok. Aktivitas "yum cha" yang menyertainya telah menjadi ritual penting dalam keluarga dan komunitas.                    </p>
                    <p class="text-gray-600">
                        Menjadi Pelopor di Kalangan dimsum daerah Purwokerto Okami Dimsum kedai dimsum yang baru berdiri pada tahun 2024, tapi sebelum itu kami aktiv menjual dimsum dengan metode "Open Pre-order" yang Dahulu kala Bernama "Ttitik Dimsum" Hingga membuka Kedai berubah Nama menjadi "Okami Dimsum" Kami menyediakan lebih dari 10 Variant dimsum yang bisa dinikmati setiap hari.                    </p>
                    <p class="text-gray-600">
                        Okami Dimsum bisa disajikan dengan Sauce Chili oil dan Bangkok Khas Okami agar lebih nikmat, Dimsum disajikan daloam keadaan hangat membuat dimsum terasa harum dan kenyal.                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="py-16 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-dark">Nilai-Nilai Kami</h2>
                <div class="h-1 w-16 bg-primary mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                    Prinsip-prinsip inti ini memandu semua yang kami lakukan di Okami Dimsum, mulai dari memilih bahan hingga melayani pelanggan kami.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-soft transform transition hover:-translate-y-1 hover:shadow-hover">
                    <div class="h-14 w-14 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-7 w-7 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Kualitas Utama</h3>
                    <p class="text-gray-600">
                        Kami tidak pernah berkompromi pada kualitas bahan-bahan kami. Dari tepung premium hingga sayuran musiman, kami mencari bahan-bahan terbaik untuk menciptakan dimsum khas kami.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-soft transform transition hover:-translate-y-1 hover:shadow-hover">
                    <div class="h-14 w-14 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-7 w-7 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Tradisi & Inovasi</h3>
                    <p class="text-gray-600">
                        Kami menghormati resep dimsum tradisional yang diturunkan dari generasi ke generasi sambil mengadopsi teknik inovatif dan kombinasi rasa yang unik.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-soft transform transition hover:-translate-y-1 hover:shadow-hover">
                    <div class="h-14 w-14 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-7 w-7 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Pelayanan Tulus</h3>
                    <p class="text-gray-600">
                        Kami percaya untuk memperlakukan setiap pelanggan seperti keluarga. Layanan kami bertujuan menciptakan pengalaman makan yang berkesan dengan perhatian terhadap detail dan keramahan yang hangat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet Our Team -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-dark">Kenali Tim Kami</h2>
                <div class="h-1 w-16 bg-primary mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                    Orang-orang berdedikasi yang membuat Okami Dimsum menjadi istimewa setiap hari.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="relative mb-4 inline-block">
                        <div class="h-48 w-48 rounded-full overflow-hidden border-4 border-accent mx-auto">
                            <img src="{{ asset('images/lulu.jpg') }}" alt="Lulu" class="h-full w-full object-cover">
                        </div>
                        <div class="absolute bottom-0 right-4 h-12 w-12 bg-primary rounded-full flex items-center justify-center shadow-lg">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-dark">Lulu</h3>
                    <p class="text-primary font-medium">Back End</p>
                </div>

                <div class="text-center">
                    <div class="relative mb-4 inline-block">
                        <div class="h-48 w-48 rounded-full overflow-hidden border-4 border-accent mx-auto">
                            <img src="{{ asset('images/mita.jpg') }}" alt="Budi Santoso" class="h-full w-full object-cover">
                        </div>
                        <div class="absolute bottom-0 right-4 h-12 w-12 bg-primary rounded-full flex items-center justify-center shadow-lg">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-dark">Mita</h3>
                    <p class="text-primary font-medium">Front End</p>

                </div>

                <div class="text-center">
                    <div class="relative mb-4 inline-block">
                        <div class="h-48 w-48 rounded-full overflow-hidden border-4 border-accent mx-auto">
                            <img src="{{ asset('images/veas.jpg') }}" alt="Maya Wijaya" class="h-full w-full object-cover">
                        </div>
                        <div class="absolute bottom-0 right-4 h-12 w-12 bg-primary rounded-full flex items-center justify-center shadow-lg">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-dark">Veas</h3>
                    <p class="text-primary font-medium">Hustler</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Restaurant -->
    <section class="py-16 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-dark">Restoran Kami</h2>
                <div class="h-1 w-16 bg-primary mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                    Suasana yang hangat dan nyaman yang dirancang untuk meningkatkan pengalaman dimsum Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="group rounded-xl overflow-hidden shadow-soft">
                    <div class="relative h-64">
                        <img src="{{ asset('images/okami-1.jpg') }}" alt="Restaurant Interior" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-white">
                        <h3 class="font-medium text-dark">Area Makan Modern</h3>
                    </div>
                </div>
                
                <div class="group rounded-xl overflow-hidden shadow-soft">
                    <div class="relative h-64">
                        <img src="{{ asset('images/okami-2.jpeg') }}" alt="Private Dining" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-white">
                        <h3 class="font-medium text-dark">Bersih dan nyaman</h3>
                    </div>
                </div>
                
                <div class="group rounded-xl overflow-hidden shadow-soft">
                    <div class="relative h-64">
                        <img src="{{ asset('images/open-kitchen.jpeg') }}" alt="Open Kitchen" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-white">
                        <h3 class="font-medium text-dark">Konsep Dapur Terbuka</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-primary py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Rasakan Dimsum Autentik Hari Ini</h2>
            <p class="text-white text-opacity-90 mb-8 max-w-3xl mx-auto">
                Bergabunglah dengan kami untuk pengalaman bersantap yang berkesan atau pesan online untuk diambil dan diantar.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('menu') }}" class="px-6 py-3 bg-white text-primary hover:bg-accent hover:text-dark font-medium rounded-lg transition-colors duration-300 shadow-md">
                    Lihat Menu Kami
                </a>
                <a href="{{ route('contact') }}" class="px-6 py-3 border border-white text-white hover:bg-white hover:text-primary font-medium rounded-lg transition-colors duration-300">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
@endsection