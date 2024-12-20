// Array untuk gambar slideshow
const images = [
    "WEB/1723094678-1200x675.webp",
    "WEB/download (16).jpg",
    "WEB/download (17).jpg",
    "WEB/download (18).jpg"
];

// Target elemen img untuk slideshow
const slideshow = document.getElementById("slideshow");

let currentImageIndex = 0;

// Fungsi untuk mengganti gambar dengan transisi
function changeImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length; // Ganti indeks gambar
    slideshow.style.transition = "opacity 0.5s ease-out"; // Menambahkan transisi animasi
    slideshow.style.opacity = 0; // Hilangkan gambar sejenak

    setTimeout(() => {
        slideshow.src = images[currentImageIndex]; // Ganti gambar
        slideshow.style.opacity = 1; // Munculkan gambar baru
    }, 500); // Tunggu 500ms untuk transisi
}

// Set interval untuk mengganti gambar setiap 3 detik
setInterval(changeImage, 3000);


// Event listener untuk memutar audio ketika lagu diklik
document.addEventListener('DOMContentLoaded', function() {
    const songItems = document.querySelectorAll('.song-item'); // Semua elemen lagu
    const audioPlayer = document.getElementById('audioPlayer'); // Elemen audio
    const audioSource = document.getElementById('audioSource'); // Elemen source audio
    const audioContainer = document.getElementById('audio-container'); // Kontainer untuk player

    // Menambahkan event listener pada setiap item lagu
    songItems.forEach(item => {
        item.addEventListener('click', function() {
            const audioPath = item.getAttribute('data-audio'); // Ambil URL audio dari data-audio

            if (audioPath) {
                // Set src audio ke path yang dipilih
                audioSource.setAttribute('src', audioPath);
                
                // Muat ulang dan putar audio
                audioPlayer.load();
                audioPlayer.play();
                
                // Tampilkan audio player jika sebelumnya tersembunyi
                audioContainer.style.display = 'block';
            } else {
                console.error('Path audio tidak ditemukan');
            }
        });
    });
});
