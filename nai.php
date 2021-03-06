<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <title>NAI 2017</title>
<style type="text/css">

    td.tdinternal {
        vertical-align: top;
        border: 1px;
    }
    table.main {
        border: 1px;
        border-spacing: 30px;
    }
    table.internal {
        border: 1px;
        width: 200px;
    }
        
</style>

</head>

<body>

<?php
    
//INTERFEJS//---------------------------------------

$refresh = 0;
$cell = "cell";

echo("<table class='main'><tr><td class='tdinternal'>");    
echo("<form action='nai.php' method='post'>");
    
// Tabela z wartościami
echo("<table class='internal'>");
for($ti=0; $ti < 35; $ti++){
if($ti%5 == 0){echo("<tr>");}
echo("<td><input type='text' name='$cell$ti' size='1' value='0' /></td>");
if(($ti+1)%5 == 0){echo("</tr>");}    
}
echo("</table>");
echo("<br/><input type='submit' value='wyświetl'></form>");
echo("</td><td class='internal'>");
    
//Tabela informacyjna    
echo("<table class='tdinternal'>");
for($tn=0; $tn < 35; $tn++){
if($tn%5 == 0){echo("<tr>");}
echo("<td>".$_POST['cell'.$tn]."</td>");
    
if(($tn+1)%5 == 0){echo("</tr>");}    
}
echo("</table>");
echo("</td><td class='tdinternal'>");

// Tabela wyświetlająca
echo("<table class='internal'>");
for($to=0; $to < 35; $to++){
if($to%5 == 0){echo("<tr>");}
echo("<td bgcolor=#".dechex(15 - ($_POST['cell'.$to])).dechex(15 - ($_POST['cell'.$to])).dechex(15 - ($_POST['cell'.$to])).dechex(15 - ($_POST['cell'.$to])).dechex(15 - ($_POST['cell'.$to])).dechex(15 - ($_POST['cell'.$to])).">&nbsp;</td>");
    
if(($to+1)%5 == 0){echo("</tr>");}    
}
echo("</table>");
echo("</td></tr></table>");

for($to=0; $to < 35; $to++){
    
    $INPUT[$to] = $_POST['cell'.$to];
    
    if($INPUT[$to] < 6){$INPUT[$to] = 0;}
    else{$INPUT[$to] = 1;}
}
    
/*
echo("Tablica wejściowa");
echo("<pre>");
print_r($INPUT);
echo("</pre>");
*/
  
    
//INTERFEJS - KONIEC//--------------------------
    
$m = 35; //liczba wejść na neuron
$n = 26; //liczba neuronów

$alfa = 1.0; //współczynnik alfa dla funkcji simoidalnej
$eta = 0.02; //współczynnik uczenia
$blad = 0.01; //poziom błędu

    
// TABLICA UCZĄCA
$U = Array(
    0 => array(
    0,1,1,1,0,
    1,0,0,0,1,
    1,0,0,0,1,
    1,1,1,1,1,
    1,0,0,0,1,
    1,0,0,0,1,
    1,0,0,0,1,
),    
    1 => array(
    1,1,1,1,0,
    1,0,0,0,1,
    1,0,0,0,1,
    1,1,1,1,0,
    1,0,0,0,1,
    1,0,0,0,1,
    1,1,1,1,0,
),
    2 => array(
    0,1,1,1,0,
    1,0,0,0,1,
    1,0,0,0,0,
    1,0,0,0,0,
    1,0,0,0,0,
    1,0,0,0,1,
    0,1,1,1,0
),  
    3 => array(1,1,1,1,0,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,1,1,1,0),   //D
    4 => array(1,1,1,1,1,1,0,0,0,0,1,0,0,0,0,1,1,1,1,0,1,0,0,0,0,1,0,0,0,0,1,1,1,1,1),   //E
    5 => array(1,1,1,1,1,1,0,0,0,0,1,0,0,0,0,1,1,1,1,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0),   //F
    6 => array(0,1,1,1,0,1,0,0,0,1,1,0,0,0,0,1,0,1,1,1,1,0,0,0,1,1,0,0,0,1,0,1,1,1,0),   //G
    7 => array(1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,1,1,1,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1),   //H
    8 => array(0,1,1,1,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,1,1,1,0),   //I
    9 => array(1,1,1,1,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,1,0,0,0,1,0,1,1,1,0),   //J
    10 => array(1,0,0,0,1,1,0,0,1,0,1,0,1,0,0,1,1,0,0,0,1,0,1,0,0,1,0,0,1,0,1,0,0,0,1),  //K
    11 => array(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,1,1,1,1),  //L
    12 => array(1,0,0,0,1,1,1,0,1,1,1,0,1,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1),  //M
    13 => array(1,0,0,0,1,1,0,0,0,1,1,1,0,0,1,1,0,1,0,1,1,0,0,1,1,1,0,0,0,1,1,0,0,0,1),  //N
    14 => array(0,1,1,1,0,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,0,1,1,1,0),  //O
    15 => array(1,1,1,1,0,1,0,0,0,1,1,0,0,0,1,1,1,1,1,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0),  //P
    16 => array(0,1,1,1,0,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,1,0,1,1,0,0,1,0,0,1,1,0,1),  //Q
    17 => array(1,1,1,1,0,1,0,0,0,1,1,0,0,0,1,1,1,1,1,0,1,0,1,0,0,1,0,0,1,0,1,0,0,0,1),  //R
    18 => array(0,1,1,1,0,1,0,0,0,1,1,0,0,0,0,0,1,1,1,0,0,0,0,0,1,1,0,0,0,1,0,1,1,1,0),  //S
    19 => array(1,1,1,1,1,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0),  //T
    20 => array(1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,0,1,1,1,0),  //U
    21 => array(1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,0,1,0,1,0,0,0,1,0,0),  //V
    22 => array(1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,1,0,1,1,0,1,0,1,0,1,0,1,0),  //W
    23 => array(1,0,0,0,1,1,0,0,0,1,0,1,0,1,0,0,0,1,0,0,0,1,0,1,0,1,0,0,0,1,1,0,0,0,1),  //X
    24 => array(1,0,0,0,1,1,0,0,0,1,0,1,0,1,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0),  //Y
    25 => array(1,1,1,1,1,0,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,0,1,1,1,1,1)   //Z
  );
 
// MACIERZ WZORÓW ODPOWIEDZI
$D = Array(
    0 => array(1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    1 => array(0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    2 => array(0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    3 => array(0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    4 => array(0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    5 => array(0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    6 => array(0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    7 => array(0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    8 => array(0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    9 => array(0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    10 => array(0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    11 => array(0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    12 => array(0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0),
    13 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0),
    14 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0),
    15 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0),
    16 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0),
    17 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    18 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0),
    19 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0),
    20 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0),
    21 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0),
    22 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0),
    23 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0),
    24 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),
    25 => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1)
  );

    
// PRZYDZIELANIE WAG - randomowe wagi od -1.00 do 0.00
for($i=0; $i < $n; $i++){
    
    for($j=0; $j < $m; $j++){
        $W[$i][$j] = ((rand(0,100)/100) - 1);
    }
}

/*
echo("Wagi wylosowane");
echo("<pre>");
print_r($W);
echo("</pre>");
*/
    
for($i=0; $i < $n ;$i++){
    
    $e = 1;
    $iteracja = 0;
    
//--PĘTLA UCZĄCA

    while($e > 0.01){
    
//-- SUMATOR
        $sumator = 0;
    
        for($j=0; $j < $m; $j++){

            $sumator = $sumator + $U[$i][$j] * $W[$i][$j];
            
            //if($i==0){echo("<br/>j =".$j.", mnożenie wagi ".$U[$i][$j]."*".$W[$i][$j]."<br/>");}
        }
//-- SUMATOR KONIEC
        
        $iteracja++;
        //echo("<br/><b>Neuron ".$i." #".$iteracja." ");
        //echo("Sumator: ".$sumator." ");

//-- FUNKCJA SIGMOIDALNA
        $y[$i] = 1/( 1 + exp(-$alfa * $sumator) );
        
       //echo("Sigmoidalna: ".$y[$i]." ");
//-- FUNKCJA SIMOIDALNA KONIEC        
        
//-- WYLICZENIE WSPÓŁCZYNNIKA BŁĘDU        
        $e = 0.5 * pow(($y[$i] - $D[$i][$i]),2);
        
        //echo(" Błąd e: ".$e."</b><br/>");
//-- WYLICZENIE WSPÓŁCZYNNIKA BŁĘDU KONIEC
        
//-- MODYFIKATOR WAG  
        for($j=0; $j < $m; $j++){
    
            $W[$i][$j] = $W[$i][$j] - $eta * ($y[$i] - $D[$i][$i]) * $U[$i][$j];
            if($U[$i][$j] == 0){$W[$i][$j] = $W[$i][$j] + $eta * ($y[$i] - $D[$i][$i]);}
            
            //if($i==0){echo("<br/>i=".$i.", j =".$j.", modyfikator wag W: ".$W[$i][$j]."=".$W[$i][$j]."-".$eta." * (".$y[$i]." - ".$D[$i][$i].") * ".$U[$i][$j]."<br/>");}
        }
//-- MODYFIKATOR WAG KONIEC
    
    }
}
//-- PĘTLA UCZĄCA KONIEC
    
/*
echo("Wagi nauczone");
echo("<pre>");
print_r($W);
echo("</pre>");  
*/
    
    
//-- ROZPOZNAWANIE
for($i=0; $i < $n ;$i++){
    
    $sumator = 0;
    
        for($j=0; $j < $m; $j++){

            $sumator = $sumator + $INPUT[$j] * $W[$i][$j];
        //if($i==0){echo("<br/>j =".$j.", mnożenie wagi ".$INPUT[$j]."*".$W[$i][$j]."<br/>");}
        }
    
    $wy[$i] = 1/( 1 + exp(-$alfa * $sumator) );
    //echo("Sigmoidalna: ".$wy[$i]."<br/>");
}


echo("Wyjścia neuronów");    
echo("<pre>");
print_r($wy);
echo("</pre>");


$max = max($wy);
if($max != 0.5 ){
    
for($i=0; $i < $n ; $i++){
    if($wy[$i] == $max){$z = $i;}
}
    
switch ($z) {
    case 0:
        $litera = 'A';
        break;
    case 1:
        $litera = 'B';
        break;
    case 2:
        $litera = 'C';
        break;
    case 3:
        $litera = 'D';
        break;
    case 4:
        $litera = 'E';
        break;
    case 5:
        $litera = 'F';
        break;
    case 6:
        $litera = 'G';
        break;
    case 7:
        $litera = 'H';
        break;
    case 8:
        $litera = 'I';
        break;
    case 9:
        $litera = 'J';
        break;
    case 10:
        $litera = 'K';
        break;
    case 11:
        $litera = 'L';
        break;
    case 12:
        $litera = 'M';
        break;
    case 13:
        $litera = 'N';
        break;
    case 14:
        $litera = 'O';
        break;
    case 15:
        $litera = 'P';
        break;
    case 16:
        $litera = 'Q';
        break;
    case 17:
        $litera = 'R';
        break;
    case 18:
        $litera = 'S';
        break;
    case 19:
        $litera = 'T';
        break;
    case 20:
        $litera = 'U';
        break;
    case 21:
        $litera = 'V';
        break;
    case 22:
        $litera = 'W';
        break;
    case 23:
        $litera = 'X';
        break;
    case 24:
        $litera = 'Y';
        break;
    case 25:
        $litera = 'Z';
        break;
    }
}
else{$litera = " ";}
    
echo("Rozpoznano: ".$litera);
    
//-- ROZPOZNAWANIE KONIEC

 
?>


</body>

</html>

