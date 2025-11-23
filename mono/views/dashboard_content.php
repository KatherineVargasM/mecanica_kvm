<?php 
require_once('../config/sesiones.php'); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mecánica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> 

        body { background-color: transparent !important; } 
        
        .logo-img {
            max-height: 250px;  
            width: auto;        
            max-width: 60%;     
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: block; 
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="container text-center mt-5">
        
        <h1 class="display-4">🔧<br>MECÁNICA</h1>
        
        <p class="lead">Bienvenido al Sistema de Gestión KVM.</p>
        <span class="text-muted small">by Katherine Vargas Mena</span>
        <hr class="my-4 w-50 mx-auto">
        
        <img src="../public/images/logo.jpeg" alt="Logo Mecánica" class="img-fluid logo-img">
    
    </div>
</body>
</html>