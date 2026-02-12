<!-- Bootstrap Bundle (sudah termasuk Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Perfect Scrollbar -->
<script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/dist/perfect-scrollbar.min.js"></script>

<!-- Material Dashboard -->
<script src="https://demos.creative-tim.com/material-dashboard/assets/js/material-dashboard.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmLogout() {
    Swal.fire({
        title: '⚠️ Logout!',
        html: `
            <div class="cry-emoji">
                😢
                <div class="tear"></div>
            </div>
            <p>Kok keluar, emang kerjanya udh selesai?</p>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '✅ Ya, logout',
        cancelButtonText: '❌ Batal',
        showClass: { popup: 'animate__animated animate__fadeInDown' },
        hideClass: { popup: 'animate__animated animate__fadeOutUp' }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}
</script>

<style>
/* Emoji menangis animatif */
.cry-emoji {
    position: relative;
    font-size: 4rem; /* ukuran emoji */
    display: inline-block;
}

.tear {
    position: absolute;
    top: 2.5rem;  /* posisi air mata relatif ke emoji */
    left: 1.5rem;
    width: 0.5rem;
    height: 1rem;
    background-color: #00f; /* warna biru air mata */
    border-radius: 50%;
    animation: drop 1s infinite;
    opacity: 0.8;
}

/* Animasi jatuh */
@keyframes drop {
    0% { transform: translateY(0) scaleY(1); opacity: 0.8; }
    50% { transform: translateY(15px) scaleY(1.2); opacity: 1; }
    100% { transform: translateY(30px) scaleY(1); opacity: 0; }
}
</style>

