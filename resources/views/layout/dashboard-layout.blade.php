<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('../templates/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('../templates/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('../templates/css/sidebar.css') }}" rel="stylesheet">

    <!-- Tables -->
    <link href="{{ asset('../templates/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Icon -->
    <link rel="shortcut icon" href="{{ asset('../assets/logo-cekmeter.png') }}">
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('components.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('components.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('main-content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('components.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" jika sudah yakin untuk mengakhiri sesi ini.</div>
                <div class="modal-footer">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('../templates/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('../templates/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('../templates/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('../templates/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('../templates/vendor/chart.js/Chart.min.js') }}"></script>
    <!-- Page level tables -->
    <script src="{{ asset('../templates/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('../templates/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('../templates/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('../templates/js/demo/chart-pie-demo.js') }}"></script>
    <!-- Page level custom tables -->
    <script src="{{ asset('../templates/js/demo/datatables-demo.js') }}"></script>

    {{-- Alert --}}
    @include('sweetalert::alert')

    {{-- Script Konfirmasi Hapus Data Pelanggan --}}
    <script>
        function confirmDelete(no_sp) {
            console.log(no_sp);
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form delete
                document.getElementById('delete-form-' + encodeURIComponent(no_sp)).submit();
            }
        })
    }
    </script>

    {{-- Script Konfirmasi Hapus Data Staff --}}
    <script>
        function confirmDeleteStaff(nip) {
            console.log(nip);
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form delete
                document.getElementById('delete-form-' + encodeURIComponent(nip)).submit();
            }
        })
    }
    </script>

    <!-- JavaScript untuk menampilkan Nomor SP Lengkap dan Wilayah -->
    <script>
        function updateNoSP() {
        var kodeWilayah = document.getElementById('kode_wilayah').value;
        var noSpLain = document.getElementById('no_sp_lain').value;

        // Gabungkan kode wilayah dan nomor SP lainnya
        var fullNoSp = kodeWilayah + noSpLain;

        // Set nilai di span review_no_sp
        document.getElementById('review_no_sp').textContent = fullNoSp;

        // Jika kode wilayah sudah 2 digit, ambil nama wilayah
        if (kodeWilayah.length === 2) {
            getWilayah(kodeWilayah);
        } else {
            document.getElementById('review_wilayah').textContent = '';
        }

        // Tampilkan atau sembunyikan section review berdasarkan input
        if (fullNoSp.length > 0) {
            document.getElementById('reviewSection').style.display = 'block';
        } else {
            document.getElementById('reviewSection').style.display = 'none';
        }
    }

    function getWilayah(kode) {
        // Gunakan AJAX untuk mengambil nama wilayah berdasarkan kode wilayah
        fetch(`/get-wilayah/${kode}`)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Wilayah tidak ditemukan');
                }
            })
            .then(data => {
                // Tampilkan nama wilayah di span review_wilayah
                document.getElementById('review_wilayah').textContent = data.nama_wilayah;
            })
            .catch(error => {
                document.getElementById('review_wilayah').textContent = error.message;
            });
    }

    // Reset field ketika form direset
    function resetNoSP() {
        document.getElementById('review_no_sp').textContent = '';
        document.getElementById('review_wilayah').textContent = '';
        document.getElementById('reviewSection').style.display = 'none'; // Sembunyikan review section
    }
    </script>

    <!-- AJAX untuk Pencarian Data Pelanggan -->
    <script>
        $('#cari_pelanggan').click(function () {
        var no_sp = $('#no_sp_pelanggan').val();

        // AJAX untuk mencari pelanggan berdasarkan No SP
        $.ajax({
            url: '{{ route('pelanggan.search') }}',
            type: 'GET',
            data: { no_sp: no_sp },
            success: function (data) {
                if (data) {
                    // Jika pelanggan ditemukan, tampilkan data pelanggan
                    $('#pelanggan_info').html(`
                        <div class="alert alert-info">
                            <strong>Pelanggan Ditemukan:</strong> <br>
                            Nama: ${data.nama_pelanggan} <br>
                            Alamat: ${data.alamat} <br>
                            Wilayah: ${data.wilayah} <br>
                        </div>
                    `);
                    $('#pelanggan_id').val(data.no_sp); // Menyimpan ID pelanggan ke dalam hidden input
                } else {
                    // Jika pelanggan tidak ditemukan, tampilkan alert error
                    $('#pelanggan_info').html(`
                        <div class="alert alert-danger">
                            Pelanggan tidak ditemukan.
                        </div>
                    `);
                    $('#pelanggan_id').val(''); // Kosongkan input ID pelanggan jika tidak ditemukan
                }
            },
            error: function () {
                // Jika terjadi error dalam AJAX
                $('#pelanggan_info').html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan saat mencari pelanggan. Silakan coba lagi.
                    </div>
                `);
            }
        });
    });
    </script>


</body>

</html>
