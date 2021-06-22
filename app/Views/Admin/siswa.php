<?= $this->extend('layout/templateadmin'); ?>

<?= $this->section('content'); ?>
<div id="content">

    <!-- Begian Page Content -->
    <div class="container-fluid">
        <!-- bagian pesan -->
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <?php $session = session(); ?>
            <h1 class="h3 mb-0 text-gray-800">Selamat datang,.<?= $session->get('username'); ?></h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pendataan Siswa</h6>
            </div>

            <!-- penampil error -->
            <?= $validation->listErrors(); ?>

            <div class="card-body">
                <button id="tambahdata" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus-square"></i>
                    </span>
                    <span class="text">Tambah Data</span>
                </button>
                <a href="/siswaclientside" class="btn btn-warning">Contoh Cliet Side Load Data</a>
                <!-- form input data -->
                <div id="formtambahdata">
                    <div class="card-body">
                        <form action="/siswa/save" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1">Nama</label>
                                <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama...">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1">Email</label>
                                <input class="form-control" id="email" name="email" type="email" placeholder="Email...">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1">No HP</label>
                                <input class="form-control" id="nohp" name="nohp" type="number" placeholder="No HP...">
                            </div>
                    </div>
                    <p></p>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>


                <p></p>
                <div class="table-responsive" id="tabelview">
                    <table class="table table-bordered" id="myTable" style="width:100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>NoHP</th>
                                <th>Status</th>
                                <th>Kelas</th>
                                <th>Pembimbing</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- nanti disi ajax dipanggil -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<!-- modal edit -->
<!-- Modal -->
<div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="editdataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/siswa/editsave" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <input type="text" class="form-control " id="editid" name="id" readonly hidden>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control " id="editnama" name="editnama">

                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="editalamat" name="editalamat" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Email</label>
                        <input type="text" class="form-control " id="editemail" name="editemail">
                    </div>
                    <div class="form-group">
                        <label for="alamat">No HP</label>
                        <input type="text" class="form-control " id="editnohp" name="editnohp">
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1">Status (Sebelumnya, <input type="text" id="editstatus" name='statusebelumnya' class="inputtolabel2" readonly>) </label>
                            <select name="status" class="form-control">
                                <option value=""></option>
                                <option value="Active">Active</option>
                                <option value="NonActive">NonActive</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- akhir modal edit -->

<!-- ajax untuk memanggil serverside data -->
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#myTable').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?php echo base_url('siswa/listsiswa') ?>",
                "type": "POST"
            },

            //optional, menentukan berapa data yg akan diload
            "lengthMenu": [
                [5, 10, 25, 50],
                [5, 10, 25, 50]
            ],

            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }],

        });
        $.fn.dataTable.ext.errMode = 'throw';
    });
</script>

<!-- script untuk hide and show form tambah -->
<script>
    const Forminput = document.getElementById("formtambahdata");
    const Tabelview = document.getElementById("tabelview");
    const btn = document.getElementById("tambahdata");
    Forminput.style.display = 'none';
    btn.onclick = function() {
        if (Forminput.style.display !== "none") {
            Forminput.style.display = "none";
            Tabelview.style.display = "block";
        } else {
            Forminput.style.display = "block";
            Tabelview.style.display = "none";
        }
    };
</script>


<!-- script untuk menampilkan data yg di klik ke modal -->
<script>
    $(document).on('click', '#editdatabtn', function() {
        $('#editid').val($(this).data('editid'));
        $('#editnama').val($(this).data('editnama'));
        $('#editalamat').val($(this).data('editalamat'));
        $('#editemail').val($(this).data('editemail'));
        $('#editnohp').val($(this).data('editnohp'));
        $('#editstatus').val($(this).data('editstatus'));
    });
</script>
<?= $this->endSection(); ?>