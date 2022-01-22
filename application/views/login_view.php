<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISG COFFEE & EATERY </title>
</head>

<style>
    body {
        background: url('<?php echo base_url("assets/img/login-bg.jpg"); ?>') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        background-size: cover;
        -o-background-size: cover;
    }

    #logindiv {
        margin-top: 100px;
        border-radius: 20px;
        z-index: 99;
        /* opacity: .5; */
        background: rgba(0, 0, 255, 0.2);


    }

    #sisteminfo {
        font-size: 1em;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("vuexy"); ?>/app-assets/vendors/css/vendors.min.css">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("vuexy"); ?>/app-assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("vuexy"); ?>/app-assets/css/bootstrap-extended.css">
<script src="<?php echo base_url("vuexy"); ?>/app-assets/vendors/js/vendors.min.js"></script>


<link href="<?php echo base_url() ?>/assets/vendors/sweetalert2/sweetalert2.css" rel="stylesheet">

<script src="<?php echo base_url() ?>/assets/vendors/sweetalert2/sweetalert2.all.js"></script>

<body>

    <div class="row justify-content-center">

        <div id="logindiv" class="col-md-4">
            <div class="row mb-4 isilogin">
                <div class="col-md-12 text-center">
                    <img height="150" class="rounded-circle" src=" <?php echo base_url("assets/img/isg.jpeg"); ?>" />
                </div>
            </div>
            <div class="row mt-5  isilogin ml-2 mr-2">

                <div class="input-container col-md-12 mt-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa fa-user"></i></span>
                        </div>
                        <input name="user_username" id="user_username" type="text" placeholder="Nama pengguna" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>

                <div class="input-container col-md-12 mt-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa fa-key"></i></span>
                        </div>
                        <input name="user_password" id="user_password" type="password" placeholder="Kata sandi" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
            </div>
            <div class="row mt-2 isilogin ml-2 mr-2">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <button id="tombollogin" class="btn btn-block btn-success"> Masuk <i class="fas fa-arrow-alt-circle-right"></i></button>
                </div>

            </div>
            <div class="row ml-2 mr-2 mt-3">
                <div class="col-md-12">
                    <strong>
                        <p id="sisteminfo" class="text-center text-white text-bold">
                            ISG - COFFEE & EATERY
                        </p>
                    </strong>
                </div>
            </div>

        </div>
    </div>

    </div>

</body>
<script>
    $(document).ready(function() {
        console.log('madafakaa..');


        $("#tombollogin").click(function() {
            $.ajax({
                url: '<?php echo site_url("Login/ceklogin"); ?>',
                beforeSend: function() {
                    swal.fire({
                        html: '<h5>Loading...</h5>',
                        showConfirmButton: false,
                        onRender: function() {
                            // there will only ever be one sweet alert open.
                            $('.swal2-content').prepend(sweet_loader);
                        }
                    });
                },
                data: {
                    username: $("#user_username").val(),
                    password: $("#user_password").val()
                },
                type: 'post',
                dataType: 'json',
                success: function(obj) {
                    if (obj.error == true) {
                        swal.fire('Error', obj.message, 'error');
                    } else {
                        swal.fire('Info', obj.message, 'success');
                        location.href = ('<?php echo site_url("Homepage"); ?>');
                    }
                }
            });
        });
    });
</script>


</html>