<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de Fecha de Regreso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }
        .container {
            text-align: center;
            background: white;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cálculo de Fecha de Regreso</h1>
        <form method="POST">
            <label for="inicio">Fecha de Inicio de Vacaciones:</label>
            <input type="date" id="inicio" name="inicio" required>

            <label for="dias">Días Hábiles Autorizados:</label>
            <input type="number" id="dias" name="dias" min="1" required>

            <button type="submit">Calcular Fecha</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $inicio = $_POST['inicio'];
            $dias_habiles = intval($_POST['dias']);

            // Validar fecha
            if (!$inicio || $dias_habiles <= 0) {
                echo "<p class='error'>Por favor, ingresa valores válidos.</p>";
            } else {
                // Convertir la fecha inicial a un objeto DateTime
                $fecha_actual = new DateTime($inicio);

                // Fechas no laborables (feriados)
                $feriados = [
                    '2024-12-25', // Navidad
                    '2025-01-01'  // Año Nuevo
                ];

                // Contar días hábiles
                $dias_contados = 0;
                while ($dias_contados < $dias_habiles) {
                    $fecha_actual->modify('+1 day');
                    $es_fin_de_semana = in_array($fecha_actual->format('N'), [6, 7]); // 6 = Sábado, 7 = Domingo
                    $es_feriado = in_array($fecha_actual->format('Y-m-d'), $feriados);

                    if (!$es_fin_de_semana && !$es_feriado) {
                        $dias_contados++;
                    }
                }

                // Mostrar la fecha de regreso en formato dd-mm-yyyy
                echo "<p class='result'>La fecha de regreso a labores es: <strong>" . $fecha_actual->format('d-m-Y') . "</strong></p>";
            }
        }
        ?>
    </div>
</body>
</html>
