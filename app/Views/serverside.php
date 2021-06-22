<!DOCTYPE html>
<html>

<head>
    <title>Demo Serverside</title>
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style type="text/css">
        .tengah {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="tengah">
        <div class="container">
            <table id="myTable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Alamat</td>
                        <td>Email</td>
                        <td>No HP</td>
                        <td>Status</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#myTable').DataTable({

                "processing": true,
                "serverSide": true,
                "order": [],

                "ajax": {
                    "url": "<?php echo base_url('serverside/ajax_list') ?>",
                    "type": "POST"
                },

                //optional
                "lengthMenu": [
                    [5, 10, 25],
                    [5, 10, 25]
                ],

                "columnDefs": [{
                    "targets": [],
                    "orderable": false,
                }, ],

            });
            $.fn.dataTable.ext.errMode = 'throw';
        });
    </script>

</body>

</html>