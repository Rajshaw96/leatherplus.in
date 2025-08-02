<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Job Opening - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?= $url->baseUrl("views/assets/vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= $url->baseUrl("views/assets/css/sb-admin-2.min.css") ?>" rel="stylesheet">

    <script src="<?= $url->baseUrl("views/assets/vendor/tinymce/js/tinymce/tinymce.min.js") ?>"></script>

    <script>
        tinymce.init({
            selector: '#shortdescription, #description',
            plugins: 'lists advlist',
            menubar: false,
            toolbar: 'undo redo | styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist',
        });
    </script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- sidebar -->
        <?php include('../../views/admin/includes/sidebar.inc.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- topbar -->
                <?php include('../../views/admin/includes/topbar.inc.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Job Opening</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Job Opening Details</h6>
                        </div>

                        <div class="card-body">

                            <form action="<?= $url->baseUrl('models/admin/job-openings/edit.php') ?>" method="POST" enctype="multipart/form-data">
                                <?php

                                $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                ?>

                                <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key" id="key">

                                <input type="hidden" value="<?= $_GET['q'] ?>" name="id">


                                <div class="form-group">
                                    <label for="">Job Title</label>
                                    <input type="text" class="form-control" value="<?= $title ?>" name="title" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Job Experience</label>
                                    <input type="text" class="form-control" value="<?= $experience ?>" name="experience" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Job Qualifications</label>
                                    <input type="text" class="form-control" value="<?= $qualification ?>" name="qualifications" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Preferred Candidates</label>
                                    <input type="text" class="form-control" value="<?= $pref_candidates ?>" name="pref_candidates" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Job Responsiblities</label>
                                    <textarea type="text" class="form-control" id="description" name="responsibilities" style="min-height:350px !important"><?= $responsibilities ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Get Applications On</label>
                                    <input type="email" class="form-control" placeholder="Email" value="<?= $email ?>" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="0" <?php if($status == 0){ echo "selected"; } ?>>Draft</option>
                                        <option value="1" <?php if($status == 1){ echo "selected"; } ?>>Published</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>

                            </form>
                        </div>
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- footer -->
                <?php include('../../views/admin/includes/footer.inc.php'); ?>

                <script>
                    function isNumberKey(evt) {
                        var charCode = (evt.which) ? evt.which : evt.keyCode;
                        if (charCode != 46 && charCode > 31 &&
                            (charCode < 48 || charCode > 57))
                            return false;

                        return true;
                    }
                </script>

                <script>
                    $('#uploadFeaturedBtn').on('click', function() {

                        document.getElementById("featuredimageresponse").src = "<?= $url->baseUrl('views/assets/img/loading.gif') ?>";

                        var file_data = $('#featuredimage').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('file', file_data);
                        form_data.append('key', document.getElementById('key').value);

                        $.ajax({
                            url: '<?= $url->baseUrl('models/admin/ajax/blog-image-upload.php') ?>', // <-- point to server-side PHP script 
                            dataType: 'html', // <-- what to expect back from the PHP script, if anything
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            type: 'post',
                            success: function(php_script_response) {
                                //alert(php_script_response); // <-- display response from the PHP script, if any
                                document.getElementById("featuredimageresponse").src = "<?= $url->baseUrl('uploads/blog-images/') ?>" + php_script_response;

                                document.getElementById("featuredimageresponsehidden").value = php_script_response;
                            }
                        });
                    });
                </script>
                <script type="text/javascript">
                    $('#featuredimage').on('change', function() {

                        const size = (this.files[0].size / 1024).toFixed(2);

                        if (size > 1000) {
                            alert("File must be between the size of 20 KB -500 KB");
                            document.getElementById("featuredimage").value = null;
                        } else {
                            $("#output").html('<b>' +
                                'This file size is: ' + size + " KB" + '</b>');
                        }
                    });
                </script>

</body>

</html>