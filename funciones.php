<?php
function concatenar($cadena, $cont, $i)
{
    $resultado = "";
    for ($t = 0; $t <= $cont; $t++) $resultado .= $cadena[$i + $t];
    return $resultado;
}

function analizarVariable($cadena, $i, $delimitador,$operadorLogico,$operadorMatematico)
{
    for ($cont = 1; $cont <= 30; $cont++) {
        if (in_array($cadena[$i + $cont], $delimitador)||in_array($cadena[$i + $cont], $operadorLogico)||in_array($cadena[$i + $cont], $operadorMatematico)||$cadena[$i+$cont] == " ") {
            $categoria = "Variable";
            $lexema = concatenar($cadena, $cont - 1, $i);
            $pos = $i + $cont - 1;
            return array($categoria, $lexema, $pos);
            break;
        }
    }
}
function analizarCaracter($cadena, $i, $caracter, $palabraReservada)
{
    if (in_array($cadena[$i], $caracter) && in_array($cadena[$i + 1], $caracter)) {
        for ($cont = 1; $cont <= 30; $cont++) {
            if (in_array($cadena[$i + $cont], $caracter)) {
                if (in_array(concatenar($cadena, $cont, $i), $palabraReservada)) {
                    $categoria = "Palabra reservada";
                    $lexema = concatenar($cadena, $cont, $i);
                    $pos = $i + $cont;
                    break;
                }
            } else {
                if (in_array($cadena[$i + $cont], $caracter) == false) {
                    $categoria = "Cadena";
                    $lexema = concatenar($cadena, $cont - 1, $i);
                    $pos = $i + $cont - 1;
                    break;
                }
            }
        }
    } else {
        $categoria = "Caracter";
        $lexema = $cadena[$i];
        $pos = $i;
    }
    return array($categoria, $lexema, $pos);
}
function analizarDelimitador($cadena, $i, $delimitador)
{
    if (in_array($cadena[$i], $delimitador)) {
        $categoria = "Delimitador";
    }
    return $categoria;
}
function analizarOperadorM($cadena, $i, $operadorMatematico)
{
    if (in_array($cadena[$i], $operadorMatematico)) {
        $categoria = "Operador matematico";
    }
    return $categoria;
}
function analizarOperadorL($cadena, $i, $operadorLogico)
{
    if (in_array($cadena[$i], $operadorLogico)) {
        $categoria = "Operador Logico";
    }
    return $categoria;
}

function analizarEntero($cadena, $i, $entero)
{
    if (in_array($cadena[$i], $entero) && in_array($cadena[$i + 1], $entero)) {
        for ($cont = 1; $cont <= 7; $cont++) {
            if (in_array($cadena[$i + $cont], $entero) == false) {
                $categoria = "Entero";
                $lexema = concatenar($cadena, $cont - 1, $i);
                $pos = $i + $cont - 1;
                break;
            }
        }
    } else {
        $categoria = "Entero";
        $lexema = $cadena[$i];
        $pos = $i;
    }
    return array($categoria, $lexema, $pos);
}

?>