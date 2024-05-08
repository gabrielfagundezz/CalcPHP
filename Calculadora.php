<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            text-align: center;
        }
        input[type="text"], select, button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }
        button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .history {
            margin-top: 20px;
        }
        .history p {
            border-bottom: 1px solid #ccc;
            padding: 5px 0;
        }
        .history p:last-child {
            border: none;
        }
        .btn-group {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Calculadora PHP</h2>

    <form action="" method="post">
        <input type="text" name="numero1" placeholder="Digite o primeiro número" value="<?php echo isset($_POST['ultimoCalculo']) ? explode(' ', $_POST['ultimoCalculo'])[0] : ''; ?>" required>
        <select name="operacao">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="text" name="numero2" placeholder="Digite o segundo número" value="<?php echo isset($_POST['ultimoCalculo']) ? explode(' ', $_POST['ultimoCalculo'])[2] : ''; ?>" required>
        <button type="submit" name="calcular">Calcular</button>
    </form>

    <?php
        session_start();
        function calcular($numero1, $numero2, $operacao) {
            switch ($operacao) {
                case '+':
                    return $numero1 + $numero2;
                case '-':
                    return $numero1 - $numero2;
                case '*':
                    return $numero1 * $numero2;
                case '/':
                    if ($numero2 == 0) {
                        return "Erro: Divisão por zero";
                    } else {
                        return $numero1 / $numero2;
                    }
            }
        }

        if (isset($_POST['calcular'])) {
            $numero1 = $_POST['numero1'];
            $numero2 = $_POST['numero2'];
            $operacao = $_POST['operacao'];
            $resultado = calcular($numero1, $numero2, $operacao);
            
            echo "<p>O resultado de $numero1 $operacao $numero2 é: $resultado</p>";

            if (!isset($_SESSION['historico'])) {
                $_SESSION['historico'] = array();
            }
            array_push($_SESSION['historico'], "$numero1 $operacao $numero2 = $resultado");
        }

        if (isset($_POST['limpar'])) {
            unset($_SESSION['historico']);
        }

        if (isset($_SESSION['historico']) && !empty($_SESSION['historico'])) {
            $ultimoCalculo = end($_SESSION['historico']);
            echo '<form action="" method="post">';
            echo '<input type="hidden" name="ultimoCalculo" value="' . htmlspecialchars($ultimoCalculo) . '">';
            echo '<button type="submit" name="recuperar">Recuperar Último Cálculo</button>';
            echo '</form>';
        }
    ?>

    <div class="btn-group">
        <form action="" method="post">
            <button type="submit" name="limpar">Limpar Histórico</button>
        </form>
    </div>

    <div class="history">
        <?php
            if (isset($_SESSION['historico'])) {
                echo "<h3>Histórico de Cálculos:</h3>";
                foreach ($_SESSION['historico'] as $calculo) {
                    echo "<p>$calculo</p>";
                }
            }
        ?>
    </div>
</div>

</body>
</html>