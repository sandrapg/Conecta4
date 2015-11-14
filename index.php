<?php
session_start();

$n_jugadores = 2;
$fichaRoja = '<div style="background: red none repeat scroll 0% 0%; border-radius: 50%; width:50px; height:50px; border: 1px solid black;"></div>';
$fichaAmarilla = '<div style="background: yellow none repeat scroll 0% 0%; border-radius: 50%; width:50px; height:50px; border: 1px solid black;"></div>';

if(!isset($_SESSION['tablero'])){
    $_SESSION['tablero'] = array();
    for($i=0; $i<7; $i++) array_push($_SESSION['tablero'], array(0,0,0,0,0,0));
}

if(!isset($_SESSION['turno'])) $_SESSION['turno'] = $turno = 0; 
elseif($_SESSION['turno'] == $n_jugadores) $_SESSION['turno'] = 0;
$ganador=0;
do{
    if(isset($_GET['columna'])){
        Tirar_ficha($_SESSION['turno'], $_GET['columna'], $_SESSION['tablero'], $fichaAmarilla, $fichaRoja);
        $ganador = Comprobar($_SESSION['tablero']);
        if($ganador==1){
            echo '<div style="position: absolute; top: 30px; width:100%; text-align:center;"><h1>Jugador 1 ha ganado!</h1></div>';
            break;
        }
        if ($ganador==2){
            echo '<div style="position: absolute; top: 30px; width:100%; text-align:center;"><h1>Jugador 2 ha ganado!</h1></div>';
            break;
        }
    }
     Crear_tablero($_SESSION['tablero'], $fichaAmarilla, $fichaRoja);

}while($ganador==1 || $ganador==2);
if($ganador==1 || $ganador==2) tableroSinLink($_SESSION['tablero'], $fichaAmarilla, $fichaRoja);

function Crear_tablero($tablero, $fichaAmarilla, $fichaRoja){
    if($_SESSION['turno']==0) echo '<div style="position: absolute; left: 204px; top: 254px; text-align: center;"><h1>Turno<br>Jugador 1</h1><br>'.$fichaRoja.'</div>';
    echo '<div style="position: absolute; top: 173px; left:500px; margin: 0 auto; width: 364px; height: 312px; border: 1px solid black;">';
    foreach($tablero as $i =>$columna){
        echo '<a style="color: black;" href="index.php?columna='.$i.'"><div style="background: blue; float:left;">';
        foreach($columna as $celda){
            if($celda==1){
                echo $fichaRoja;
            }
            elseif($celda==2){
                echo $fichaAmarilla;
            }
            else{
                echo '<div style="width:50px; height:50px; border: 1px solid black;"></div>';
            }
        }
        echo '</div></a>';
    }
    echo '</div>';
    
}

function Tirar_ficha(&$turno, $columna, &$tablero, $fichaAmarilla, $fichaRoja){
    for($i=5; $i>=0; $i--){
        if ($tablero[$columna][$i]==0){
            if ($turno==1) echo '<div style="position: absolute; left: 204px; top: 254px; text-align: center;"><h1>Turno<br>Jugador 1</h1><br>'.$fichaRoja.'</div>';
            if ($turno==0) echo '<div style="position: absolute; left: 204px; top: 254px; text-align: center;"><h1>Turno<br>Jugador 1</h1><br>'.$fichaAmarilla.'</div>';
            $turno++;
            $tablero[$columna][$i]= $turno;
            break;
        }
    }
    
}

function Comprobar($tablero){
    foreach($tablero as $i=>$columna){
        foreach($columna as $j=>$celda){
            //Comprobación vertical
            if($j>3){
                if($tablero[$i][$j]==1 && $tablero[$i][$j-1]==1 && $tablero[$i][$j-2]==1 && $tablero[$i][$j-3]==1){
                    $ganador= 1;
                    return $ganador;
                }
                if($tablero[$i][$j]==2 && $tablero[$i][$j-1]==2 && $tablero[$i][$j-2]==2 && $tablero[$i][$j-3]==2){
                    $ganador= 2;
                    return $ganador;
                }
            }
            //Comprobación horizontal
            if($i>=0 && $i<4){
                if($tablero[$i][$j]==1 && $tablero[$i+1][$j]==1 && $tablero[$i+2][$j]==1 && $tablero[$i+3][$j]==1){
                    $ganador= 1;
                    return $ganador;
                }
                if($tablero[$i][$j]==2 && $tablero[$i+1][$j]==2 && $tablero[$i+2][$j]==2 && $tablero[$i+3][$j]==2){
                    $ganador= 2;
                    return $ganador;
                }
            }
            //Comprobación diagonal derecha
            if($i>=0 && $i<4 && $j>2){
                if($tablero[$i][$j]==1 && $tablero[$i+1][$j-1]==1 && $tablero[$i+2][$j-2]==1 && $tablero[$i+3][$j-3]==1){
                    $ganador= 1;
                    return $ganador;
                }
                if($tablero[$i][$j]==2 && $tablero[$i+1][$j-1]==-2 && $tablero[$i+2][$j-2]==2 && $tablero[$i+3][$j-3]==2){
                    $ganador= 2;
                    return $ganador;
                }
            }
            //Comprobación diagonal izquierda
            if($i>2 && $j>2){
                if($tablero[$i][$j]==1 && $tablero[$i-1][$j-1]==1 && $tablero[$i-2][$j-2]==1 && $tablero[$i-3][$j-3]==1){
                    $ganador= 1;
                    return $ganador;
                }
                if($tablero[$i][$j]==2 && $tablero[$i-1][$j-1]==2 && $tablero[$i-2][$j-2]==2 && $tablero[$i-3][$j-3]==2){
                    $ganador= 2;
                    return $ganador;
                }
            }
            
        }
    }
}

function tableroSinLink($tablero, $fichaAmarilla, $fichaRoja){
    echo '<div style="position: absolute; top: 173px; left:500px; margin: 0 auto; width: 364px; height: 312px; border: 1px solid black;">';
    foreach($tablero as $i =>$columna){
        echo '<div style="background: blue; float:left;">';
        foreach($columna as $celda){
            if($celda==1){
                echo $fichaRoja;
            }
            elseif($celda==2){
                echo $fichaAmarilla;
            }
            else{
                echo '<div style="width:50px; height:50px; border: 1px solid black;"></div>';
            }
        }
        echo '</div>';
    }
    echo '</div>';
}
?>