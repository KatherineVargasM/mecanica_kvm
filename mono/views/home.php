<?php
require_once('../config/sesiones.php');

?>
<!DOCTYPE html>
<html lang="es" class="light-style layout-menu-fixed" dir="ltr">

<head>
  <?php require_once('./html/head.php'); ?> 
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">


      <?php require_once('./html/menu.php'); ?>

      <div class="layout-page">


        <?php require_once('./html/header.php'); ?>

        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            

            <iframe
              height="800px"
              width="100%"
              src="dashboard_content.php" 
              name="base"
              frameborder="0"
              style="border-radius: 8px;"
            ></iframe>
            
          </div>

          <?php require_once('./html/footer.php'); ?>

          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
  </div>

  <?php require_once('./html/scripts.php'); ?>

</body>
</html>