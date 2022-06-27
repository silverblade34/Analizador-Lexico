<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analizador lexico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <form action="index.php" method="POST">
        <div>
        <h3 class="text-center mb-3 mt-3 text-dark">Analizador lexico</h3>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Ingrese su texto</h4>
                    <textarea class="form-control text-start" name="cadena" id="" cols="30" rows="10"><?php if (isset($_POST['enviarDatos'])) {
                                                                                                            echo $_POST['cadena'];
                                                                                                        }elseif(isset($_POST['reiniciar'])){
                                                                                                            echo "";
                                                                                                        } ?></textarea><br>
                    <div class="text-center">
                        <input class="btn btn-dark" name="enviarDatos" type="submit" value="Analizar sintaxis">
                        <input class="btn btn-info" name="reiniciar" type="submit" value="Limpiar texto">
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4>Resultado</h4>
                    <table class="table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Lexema</th>
                            <th scope="col">Categoria</th>
                        </thead>
                        <tbody>
                            <?php
                            error_reporting(0);
                            include('funciones.php');
                            include('token.php');
                            if (isset($_POST['enviarDatos'])) {
                                $cadena = $_POST['cadena'];
                                //  $i: Posicion de la cadena desde donde se analiza
                                $i = 0;
                                $cantidad = 0;
                                $pos = 0;
                                while ($i < strlen($cadena)) {
                                    $categoria = "";
                                    $lexema = "";
                                    $cantidad++;
                                    if (in_array($cadena[$i], $caracter)) {
                                        //Usamos la funcion para analizar el caracter
                                        analizarCaracter($cadena, $i, $caracter, $palabraReservada);
                                        [$categoria, $lexema, $pos] = analizarCaracter($cadena, $i, $caracter, $palabraReservada);
                            ?>
                                        <tr>
                                            <th scope="row"><?php echo $cantidad; ?></th>
                                            <td>
                                                <?php
                                                echo $lexema . "<br>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $categoria . "<br>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    } elseif (in_array($cadena[$i], $variable) && in_array($cadena[$i + 1], $caracter)) {
                                        analizarVariable($cadena, $i, $delimitador, $operadorLogico, $operadorMatematico);
                                        [$categoria, $lexema, $pos] = analizarVariable($cadena, $i, $delimitador, $operadorLogico, $operadorMatematico);
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $cantidad; ?></th>
                                            <td>
                                                <?php
                                                echo $lexema . "<br>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $categoria . "<br>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    } elseif (in_array($cadena[$i], $delimitador)) {
                                        analizarDelimitador($cadena, $i, $delimitador);
                                        $categoria = analizarDelimitador($cadena, $i, $delimitador);
                                        $pos = $i;
                                        $lexema = $cadena[$i];
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $cantidad; ?></th>
                                            <td>
                                                <?php
                                                echo $lexema . "<br>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $categoria . "<br>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    } elseif (in_array($cadena[$i], $operadorMatematico)) {
                                        analizarOperadorM($cadena, $i, $operadorMatematico);
                                        $categoria = analizarOperadorM($cadena, $i, $operadorMatematico);
                                        $pos = $i;
                                        $lexema = $cadena[$i];
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $cantidad; ?></th>
                                            <td>
                                                <?php
                                                echo $lexema . "<br>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $categoria . "<br>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    } elseif (in_array($cadena[$i], $operadorLogico)) {
                                        analizarOperadorL($cadena, $i, $operadorLogico);
                                        $categoria = analizarOperadorL($cadena, $i, $operadorLogico);
                                        $pos = $i;
                                        $lexema = $cadena[$i];
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $cantidad; ?></th>
                                            <td>
                                                <?php
                                                echo $lexema . "<br>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $categoria . "<br>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    } elseif (in_array($cadena[$i], $entero)) {
                                        analizarEntero($cadena, $i, $entero);
                                        [$categoria, $lexema, $pos] = analizarEntero($cadena, $i, $entero);
                                    ?>
                                    
                                        <tr>
                                            <th scope="row"><?php echo $cantidad; ?></th>
                                            <td>
                                                <?php
                                                echo $lexema . "<br>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $categoria . "<br>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    } elseif ($cadena[$i] = " ") {
                                        $pos = $i;
                                    } else {
                                        $categoria = "No identificado";
                                        $lexema = $cadena[$i];
                                        $pos = $i;
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $cantidad; ?></th>
                                            <td>
                                                <?php
                                                echo $lexema . "<br>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $categoria . "<br>";
                                                ?>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                    $i = $pos + 1;
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>