<!-- filepath: e:\Kelas-12\Joki\Okami\okami-dimsum\resources\views\contact.blade.php -->
@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-cover bg-center h-64 md:h-80" style="background-image: url('{{ asset('images/bannerhd.jpg') }}')">
        <div class="absolute inset-0 bg-dark bg-opacity-70"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Hubungi Kami</h1>
            <p class="text-lg text-light max-w-xl">
                Kami senang mendengar dari Anda. Kirimkan pesan dan kami akan merespons secepat mungkin.
            </p>
        </div>
    </div>

    <!-- Contact Information Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-light rounded-xl p-8 text-center shadow-soft transform transition hover:-translate-y-1 hover:shadow-hover">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-6">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Kunjungi Kami</h3>
                    <p class="text-gray-600">
                        Jl. Kaliputih, Purwokerto Wetan<br>
                        Banyumas, Indonesia<br>
                        12345
                    </p>
                </div>

                <div class="bg-light rounded-xl p-8 text-center shadow-soft transform transition hover:-translate-y-1 hover:shadow-hover">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-6">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Hubungi Kami</h3>
                    <p class="text-gray-600">
                        Layanan Pelanggan:<br>
                        +62 812-3456-7890<br>
                        Senin - Minggu: 10:00 - 22:00
                    </p>
                </div>

                <div class="bg-light rounded-xl p-8 text-center shadow-soft transform transition hover:-translate-y-1 hover:shadow-hover">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-6">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13a3 3 0 100-6 3 3 0 000 6z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Instagram Kami</h3>
                    <p class="text-gray-600">
                        Kunjungi Instagram kami:<br>
                        <a href="https://instagram.com/okami.dimsum" class="text-primary hover:underline">@okami.dimsum</a><br>
                        Dapatkan update terbaru dan promo menarik!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form and Map Section -->
    <section class="py-16 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white rounded-xl shadow-soft p-8">
                    <h2 class="text-2xl font-bold text-dark mb-6">Kirim Pesan Kepada Kami</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-dark font-medium mb-2">Nama Anda</label>
                                <input type="text" id="name" name="name" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-dark font-medium mb-2">Email Anda</label>
                                <input type="email" id="email" name="email" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-dark font-medium mb-2">Subjek</label>
                            <input type="text" id="subject" name="subject" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary" value="{{ old('subject') }}" required>
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="message" class="block text-dark font-medium mb-2">Pesan Anda</label>
                            <textarea id="message" name="message" rows="5" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary" required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <button type="submit" class="px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-secondary transition-colors shadow-md flex items-center">
                                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Map -->
                <div class="rounded-xl overflow-hidden shadow-soft h-[500px]">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.341165086548!2d109.25312667476213!3d-7.427445592583202!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655f006d356ced%3A0x379bf52c90fd0af4!2sOKAMI%20DIMSUM!5e0!3m2!1sen!2sid!4v1747131745586!5m2!1sen!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Business Hours -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-dark">Jam Operasional</h2>
                <div class="h-1 w-24 bg-primary mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="max-w-3xl mx-auto bg-light rounded-xl shadow-soft p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-dark mb-4">Restoran</h3>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Setiap Hari</span>
                            <span class="font-medium">10:00 - 22:00</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-dark mb-4">Layanan Pengiriman</h3>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Setiap Hari</span>
                            <span class="font-medium">10:00 - 22:00</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        <span class="text-primary font-medium">Catatan:</span> Pesanan terakhir diterima 30 menit sebelum waktu tutup.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-16 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-dark">Pertanyaan yang Sering Diajukan</h2>
                <div class="h-1 w-24 bg-primary mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                    Temukan jawaban untuk pertanyaan yang paling umum tentang makanan, layanan, dan pengiriman kami.
                </p>
            </div>
            
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="bg-white rounded-xl shadow-soft overflow-hidden">
                    <button class="w-full text-left p-6 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" onclick="toggleFaq(this)">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-dark">Apakah Anda menyediakan layanan pengiriman?</h3>
                            <svg class="faq-icon h-5 w-5 text-primary transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer px-6 pb-6 hidden">
                        <p class="text-gray-600">
                            Ya, kami menyediakan layanan pengiriman dalam radius 10 km dari restoran kami. Pengiriman gratis untuk pesanan di atas Rp 200.000. Untuk pesanan yang lebih kecil, biaya pengiriman sebesar Rp 15.000 akan dikenakan.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-soft overflow-hidden">
                    <button class="w-full text-left p-6 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" onclick="toggleFaq(this)">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-dark">Bisakah saya menyesuaikan pesanan dimsum saya?</h3>
                            <svg class="faq-icon h-5 w-5 text-primary transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer px-6 pb-6 hidden">
                        <p class="text-gray-600">
                            Kami menawarkan beberapa pilihan penyesuaian untuk hidangan tertentu. Anda dapat meminta modifikasi seperti kurang pedas, tanpa bawang putih, dll. Harap perhatikan bahwa kami mungkin tidak dapat mengakomodasi semua permintaan karena standar resep autentik kami.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-soft overflow-hidden">
                    <button class="w-full text-left p-6 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" onclick="toggleFaq(this)">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-dark">Apakah Anda melayani katering untuk acara dan pesta?</h3>
                            <svg class="faq-icon h-5 w-5 text-primary transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer px-6 pb-6 hidden">
                        <p class="text-gray-600">
                            Ya, kami menyediakan layanan katering untuk acara dengan berbagai ukuran. Harap hubungi kami setidaknya 3 hari sebelumnya untuk acara kecil dan 1 minggu untuk acara besar. Menu dan paket khusus tersedia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="bg-primary py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Siap Menikmati Dimsum Autentik?</h2>
            <p class="text-white text-opacity-90 mb-8 max-w-3xl mx-auto">
                Kunjungi restoran kami atau pesan online sekarang untuk merasakan dimsum berkualitas premium yang dibuat dengan penuh perhatian.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('menu') }}" class="px-8 py-3 bg-white text-primary font-medium rounded-full hover:bg-accent hover:text-dark transition-colors duration-300 shadow-md">
                    Pesan Online
                </a>
                <a href="tel:+6281234567890" class="px-8 py-3 border-2 border-white text-white font-medium rounded-full hover:bg-white hover:text-primary transition-colors duration-300">
                    Telepon Sekarang
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function toggleFaq(button) {
        // Toggle answer visibility
        const answer = button.nextElementSibling;
        const icon = button.querySelector('.faq-icon');
        
        if (answer.classList.contains('hidden')) {
            answer.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            answer.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
@endpush