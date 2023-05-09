
<?php
/**
* Datei zu Aufgabe 3
* @author  Anna Rieckmann
* @ Formular
*/
#require_once('sprint3klassen.php');
require_once('View.php');
require_once('Controller.php');
require_once('Model.php');
session_start();
$debug="ja"; 
 if ($debug==="ja") 
 {
     error_reporting (-1);
     echo "POST/GET <br>";
     print_r($_REQUEST);        
     echo "<hr>";
     echo "SESSION <br>";
     print_r($_SESSION);  
 } else 
 {
     error_reporting (0);  
 }
 //-------Hauptprogramm--------------------------------------------------
$model = New Model();
$controller = New Controller (3);
$view =New View($model,$controller);
$view->model->transferpost("Veranstalltungsplan");
$view->model->transferget("add");
$view->model->transferpost("Beschreibung");
$view->model->transferpost("Festivalname");
$view->festivalnamen();
echo $view->titel();
echo $view->formKopf("POST", 'index.php'); # transfer der daten in die Session

if ($_POST["Ausdruck"] === "Ausdruck") #seite 2 die beschreibung des festivials
{
    echo $view->seiteZwei();
} elseif ($_POST["weiter"] === "weiter") #seite 3 ausgabe der daten
{
    echo $view->seiteDrei();
    session_destroy();
} elseif(!empty($_POST)||!empty($_GET)&& !($_POST["weiter"] === "weiter")&& !($_POST["Ausdruck"] === "Ausdruck") )  #seite 1
{
    echo $view->seiteEins();
}
else{
    echo $view->ersteSeite();
}
$controller->schreiben();
echo '</form>';
echo "<br> <hr> <br>";
echo $view->severInfomationen();
$debug="ja"; 
 if ($debug==="ja") 
 {
     error_reporting (-1);
     echo "POST/GET <br>";
     print_r($_REQUEST);        
     echo "<hr>";
     echo "SESSION <br>";
     print_r($_SESSION);  
 } else 
 {
     error_reporting (0);  
 }
?>