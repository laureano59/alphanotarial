<!-- resources/views/progress.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barra de Progreso Circular</title>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <!-- jquery-circle-progress -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script>
  <!-- Estilos opcionales para personalizar la apariencia -->
  <style>
    .progress-circle {
      width: 200px;
      height: 200px;
      margin: 50px;
      position: relative;
    }

    .center-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 16px;
      color: #333;
    }
  </style>
</head>
<body>

<!-- Contenedor de la barra de progreso circular -->
<div class="progress-circle">
  <div class="center-text">OK</div>
</div>

<!-- Inicialización de jquery-circle-progress después de cargar jQuery -->
<script>
  $(document).ready(function() {
    var totalTime = 60;  // Duración total en segundos
    var increment = 1 / totalTime;

    $(".progress-circle").circleProgress({
      value: 0,  // Valor inicial (entre 0 y 1)
      size: 200,  // Tamaño del círculo
      fill: {
        color: "#66BB6A"  // Color de la barra de progreso
      },
      emptyFill: "#E0E0E0",  // Color del fondo
      thickness: 10  // Grosor de la barra de progreso
    });

    var currentValue = 0;
    var progressInterval = setInterval(function() {
      currentValue += increment;
      $(".progress-circle").circleProgress('value', currentValue);

      if (currentValue >= 1) {
        clearInterval(progressInterval);
      }
    }, 1000);
  });
</script>

</body>
</html>
