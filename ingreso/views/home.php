<?php
require_once('../config/sesiones.php');
if ($_SESSION['Rol'] == 'ADMINISTRADOR') {
    $_SESSION['rutas'] = 'Dashboard'
?>


    <!DOCTYPE html>

    <html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

    <head>
        <?php require_once('./html/head.php') ?>
    </head>

    <body>

        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">

                <?php require_once('html/menu.php') ?>



                <div class="layout-page">


                    <?php require_once('html/header.php') ?>




                    <div class="content-wrapper">

                        <div class="container-xxl flex-grow-1 container-p-y">
                            <iframe name="base" id="base" src="graficos.php" style="border: none;" width="100%" height="1000px"></iframe>
                        </div>



                        <?php require_once('html/footer.php') ?>


                        <div class="content-backdrop fade"></div>
                    </div>

                </div>

            </div>


            <div class="layout-overlay layout-menu-toggle"></div>
        </div>



        <?php include_once('html/scripts.php') ?>


    </body>

    </html>

<?php
} else {
    header('Location:../login.php');
}

?>