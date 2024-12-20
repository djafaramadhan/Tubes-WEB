// Konfirmasi Sebelum Menghapus Data
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-btn");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            const confirmed = confirm("Apakah Anda yakin ingin menghapus data ini?");
            if (!confirmed) {
                e.preventDefault(); // Mencegah penghapusan jika pengguna membatalkan
            }
        });
    });
});
