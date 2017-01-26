<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <title>NAI 2017</title>
<style type="text/css">
table td {
    width: 30px;
    overflow: hidden;
    display: inline-block;
    white-space: nowrap;
}
</style>

</head>

<body>

<?php
    
//INTERFEJS//---------------------------------------

$refresh = 0;
$cell = "cell";
    
echo("<form action='nai.php' method='post'>");
    
// Tabela z wartościami
echo("EDYTOR");
echo("<table border='1'>");
for($ti=0; $ti < 35; $ti++){
if($ti%5 == 0){echo("<tr>");}
echo("<td><input type='text' name='$cell$ti' size='1' value='15' /></td>");
if(($ti+1)%5 == 0){echo("</tr>");}    
}
echo("</table>");
//Koniec

echo("<br/><input type='submit' value='wyświetl'></form>");
    
//walidacja
    
//Tabela informacyjna
    
echo("<table border='1'>");
for($tn=0; $tn < 35; $tn++){
if($tn%5 == 0){echo("<tr>");}
echo("<td>".$_POST['cell'.$tn]."</td>");
    
if(($tn+1)%5 == 0){echo("</tr>");}    
}
echo("</table>");

// Tabela wyświetlająca
    
echo("<table border='1'>");
for($to=0; $to < 35; $to++){
if($to%5 == 0){echo("<tr>");}
echo("<td bgcolor=#".dechex($_POST['cell'.$to]).dechex($_POST['cell'.$to]).dechex($_POST['cell'.$to]).dechex($_POST['cell'.$to]).dechex($_POST['cell'.$to]).dechex($_POST['cell'.$to]).">&nbsp;</td>");
    
if(($to+1)%5 == 0){echo("</tr>");}    
}
echo("</table>");
    
echo("<br/>Rozpoznano:<br/>");
    
//INTERFEJS - KONIEC//--------------------------
    

    
$m = 35; //liczba wejść
$n = 1; //liczba neuronów
    
    
$U = Array(
    1, 1, 1, 1, 1,
    1, 1, 1, 1, 1,
    1, 1, 1, 1, 1,
    1, 1, 1, 1, 1,
    0, 0, 0, 0, 0,
    0, 0, 0, 0, 0,
    0, 0, 0, 0, 0
          ); //tablica ucząca
$W = Array();           //tablica wag


$d = 1;
$eta = 0.02; //współczynnik uczenia
$blad = 0.01; //poziom błędu

    
    
$UD = Array(
    0 => array(
    0,1,1,1,0,
    1,0,0,0,1,
    1,0,0,0,1,
    1,1,1,1,1,
    1,0,0,0,1,
    1,0,0,0,1,
    1,0,0,0,1
),   
    1 => array(1,1,1,1,0,1,0,0,0,1,1,0,0,0,1,1,1,1,1,0,1,0,0,0,1,1,0,0,0,1,1,1,1,1,0),   //B
    2 => array(0,1,1,1,0,1,0,0,0,1,1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1,0,0,0,1,0,1,1,1,0),   //C
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
    
    
    
echo("<pre>");
echo($UD[19][1]);
echo("</pre>");
    
    

    
//randomowe wagi od -0.5 do 0.5 co wynika z ilości wejść
for($r=0; $r < $m; $r++){
    $W[$r]= (rand(0,100)/100) - 0.5;
}
    
echo("<pre>");
print_r($U);
print_r($W);
echo("</pre>");
    
    
$e = 1;
$iteracja=0;
//--PĘTLA UCZĄCA

while($e > 0.01){
    
//-- SUMATOR
    $sumator = 0;
    
    for($j=0; $j < $m; $j++){

        $sumator = $sumator + $U[$j] * $W[$j];
    }
//-- SUMATOR KONIEC
    
    $iteracja++;
    echo("#: ".$iteracja." ");
    $y = sigmoidalna($sumator);
    echo("Wynik sigmoidalnej: ".$y." ");
    $e = 0.5 * pow(($y - $d),2);
    echo(" Błąd e: ".$e."<br/>");
    
    
//-- MODYFIKATOR WAG  
    for($j=0; $j < $m; $j++){
    
        $W[$j] = $W[$j] - $eta * ($y - $d) * $U[$j];
    }
//-- MODYFIKATOR WAG KONIEC
    
}
//-- PĘTLA UCZĄCA KONIEC
    
//-- FUNKCJA SIGMOIDALNA
    function sigmoidalna($S){

        $alfa = 0.5;
    
        return $y = 1/( 1 + exp(-$alfa * $S) );

    }
//-- FUNKCJA SIGMOIDALNA KONIEC
    
echo("<br/>");
echo("<pre>");
print_r($W);
echo("</pre>");
    
?>


</body>

</html>

