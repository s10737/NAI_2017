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

    
?>


</body>

</html>

