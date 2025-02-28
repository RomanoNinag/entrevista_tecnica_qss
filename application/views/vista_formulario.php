<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prueba técnica Backend</title>
    <script>
        // Actualizar nombre de ciudad al seleccionar en el select para guardarlo en la BD
        function ActualizarNombreCiudad() {
            var select = document.getElementById('selectCiudad');
            var selectedOption = select.options[select.selectedIndex];
            document.getElementById('nombreCiudad').value = selectedOption.getAttribute('data-nombre');
        }
    </script>
</head>
<body>
    <h1>Prueba técnica Backend QSS</h1><br>
    <hr>
    <h1>Cargar archivo CSV</h1>

    <form action="<?php echo site_url('DatosController/cargarArchivo'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo_csv" accept=".csv" required>
        <button type="submit">Cargar</button>
    </form>

   <?php if (isset($ciudades)): ?>
    <form action="<?php echo site_url('DatosController/guardarDatos'); ?>" method="post">
        <!-- Select que muestra ciudades -->
        <select name="ciudadId" id="selectCiudad" required onchange="ActualizarNombreCiudad()">
            <option value="">Seleccione una ciudad</option>
            <?php foreach ($ciudades as $ciudad): ?>
                <option value="<?php echo $ciudad['idCiudad']; ?>" data-nombre="<?php echo $ciudad['nombreCiudad']; ?>">
                    <?php echo $ciudad['nombreCiudad']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <!-- Select que muestra usuarios -->
        <select name="usuarioId" required>
            <option value="">Seleccione un usuario</option>
            <?php foreach ($listaUsuarios as $usuario): ?>
                <option value="<?php echo $usuario->IdUsuario; ?>">
                    <?php echo $usuario->Nombre; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="hidden" name="nombreCiudad" id="nombreCiudad"> 
        <button type="submit">Guardar</button>
    </form>
    <?php endif; ?>

<hr>
<!-- Verificar si se actualizó -->
<form method="post" action="<?php echo site_url('DatosController/listarCiudadesUsuarios'); ?>">
    <button type="submit">Mostrar Datos</button>
</form>

<!-- Verificamos si se presionó mostrar datos y si es así mostramos los registros -->
<?php if (isset($ciudadUsuarios) && !empty($ciudadUsuarios)): ?>
<table>
    <tr>
        <th>Id Usuario</th>
        <th>Nombre Usuario</th>
        <th>Id Ciudad</th>
        <th>Nombre Ciudad</th>
    </tr>
    <?php foreach ($ciudadUsuarios as $usuarioCiudad): ?>
    <tr>
        <td><?php echo $usuarioCiudad['IdUsuario']; ?></td>
        <td><?php echo $usuarioCiudad['NombreUsuario']; ?></td>
        <td><?php echo $usuarioCiudad['IdCiudad']; ?></td>
        <td><?php echo $usuarioCiudad['NombreCiudad']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>No hay datos disponibles.</p>
<?php endif; ?>

</body>
</html>