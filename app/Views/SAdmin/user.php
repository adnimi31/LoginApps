<?= $this->extend('layout/templatesadmin'); ?>

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
                <h6 class="m-0 font-weight-bold text-primary">Pendataan Users</h6>
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
                <!-- form input data -->
                <div id="formtambahdata">
                    <div class="card-body">
                        <form action="/users/save" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <center>
                                        <img src="img/default.png" alt="" class="fotopreview">
                                        <p>Preview</p>
                                    </center>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1">Foto</label>
                                        <div class="input-group input-group-joined">
                                            <input class="form-control pe-0" type="file" id="foto" name="foto" placeholder="Chose file..." onchange="previewimage();">
                                            <span class="input-group-text">
                                                <i class="fas fa-file-upload"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1">Username</label>
                                <input class="form-control" id="username" name="username" type="text" placeholder="username">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1">Password</label>
                                <input class="form-control" id="pasword" name="password" type="password" placeholder="pasword">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1">Hak Akses</label>
                                <select name="role" class="form-control" id="exampleFormControlSelect1">
                                    <option value="Admin">Admin</option>
                                    <option value="Users">Users</option>
                                </select>
                            </div>
                            <p></p>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </form>
                    </div>
                </div>

                <p></p>
                <div class="table-responsive" id="tabelview">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Foto</th>
                                <th>Username</th>
                                <th>Hak Akses</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($usersdata as $usr) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td>
                                        <center><img src="/img/<?= $usr['foto']; ?>" class="foto" alt=""></center>
                                    </td>
                                    <td><?= $usr['username']; ?></td>
                                    <td><?= $usr['role']; ?></td>
                                    <td><?= $usr['status']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-icon-split btn-sm" id="editdatabtn" data-toggle="modal" data-editid="<?= $usr['id']; ?>" data-editfotolama="<?= $usr['foto']; ?>" data-editfoto="/img/<?= $usr['foto']; ?>" data-editusername="<?= $usr['username']; ?>" data-edithakakses="<?= $usr['role']; ?>" data-editstatus="<?= $usr['status']; ?>" data-target="#editdata">
                                            <span class="icon text-white">
                                                <i class="fas fa-user-edit"></i>
                                            </span>
                                            <span class="text">Edit</span>
                                        </button>
                                        <form action="/users/<?= $usr['id']; ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="text" name="_method" value="DELETE" hidden>
                                            <button id="hapus" type="submit" class="btn btn-danger btn-icon-split btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                                                <span class="icon text-white">
                                                    <i class="fas fa-trash-alt"></i>
                                                </span>
                                                <span class="text">Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <!-- /.container-fluid -->

</div>


<!-- modal edit -->
<!-- Modal -->
<div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="editdataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/users/editsave" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <input type="text" class="form-control " id="editid" name="id" readonly hidden>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control " id="editfotolama" name="editfotolama" hidden>
                    </div>
                    <center>
                        <img src="" id="my_image" class="editfotopreview" alt="">
                        <br>
                        <label for="foto">Foto Sebelumnya/Preview</label>
                    </center>
                    <label for="foto">Foto</label>
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="editfoto" name="editfoto" onchange="previeweditimage();">
                        <label class="custom-file-label" id="editlabel" for="validatedCustomFile">Choose file...</label>
                    </div>
                    <div class="form-group">
                        <label for="nama">Username</label>
                        <input type="text" class="form-control " id="editusername" name="username" readonly>

                    </div>
                    <div class="form-group">
                        <label for="alamat">Password</label>
                        <input type="password" class="form-control " id="password" name="editpassword">
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1">Hak Akses (Sebelumnya, <input type="text" id="edithakakses" name='rolesebelumnya' class="inputtolabel" readonly>) </label>
                            <select name="editrole" class="form-control">
                                <option value=""></option>
                                <option value="Admin">Admin</option>
                                <option value="Users">Users</option>
                            </select>
                        </div>
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

<!-- script untuk preview image yg di puload (insert data) -->
<script>
    function previewimage() {
        const foto = document.querySelector('#foto');
        const fotopreview = document.querySelector('.fotopreview');

        const filefoto = new FileReader();
        filefoto.readAsDataURL(foto.files[0]);
        filefoto.onload = function(e) {
            fotopreview.src = e.target.result;
        }

    };
</script>

<script>
    function previeweditimage() {
        const editfoto = document.querySelector('#editfoto');
        const editfotolabel = document.querySelector('#editlabel');
        const editfotopreview = document.querySelector('.editfotopreview');
        // menganti tulisan chose file manjadi nama file
        editfotolabel.textContent = editfoto.files[0].name;

        const fileeditfoto = new FileReader();
        fileeditfoto.readAsDataURL(editfoto.files[0]);
        fileeditfoto.onload = function(e) {
            editfotopreview.src = e.target.result;
        }

    };
</script>

<!-- script untuk menampilkan data yg di klik ke modal -->
<script>
    $(document).on('click', '#editdatabtn', function() {
        $('#editid').val($(this).data('editid'));
        $('#editusername').val($(this).data('editusername'));
        $('#edithakakses').val($(this).data('edithakakses'));
        $('#editfotolama').val($(this).data('editfotolama'));
        $('#editstatus').val($(this).data('editstatus'));
        // pasing data gambar
        $('#my_image').attr('src', $(this).data('editfoto'));
    });
</script>
<?= $this->endSection(); ?>