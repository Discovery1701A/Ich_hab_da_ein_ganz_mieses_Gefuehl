<?php
/**
 * view zu Aufgabe 3
 * @author  Anna Rieckmann
 * @ Formular
 */
class View
{
    function __construct($model,$controller)
    {
        $this->model = $model;
        $this->controller = $controller;
        #$this->titlename = $titlename;
    }
    function severInfomationen() # infomationen über den server
    {
        return "ServerSignature: " . $_SERVER['SERVER_SIGNATURE'] . "<br>
        ServerSoftware (ServerTokens): " . $_SERVER['SERVER_SOFTWARE'] . "<br>
        DocumentRoot: " . $_SERVER['DOCUMENT_ROOT'] . "<br><br><br><br></body>";
    }
    function titel()
    {
        return "<h1 align=\"center\"> $this->titlename </h1><br>"; # Überschrift ausrichtung center
    }
    private function eingabefelderband($bandAnzahl, $titelAnzahlliste) # erste seite input felder
    {
        for ($i = 1; $i <= $bandAnzahl; $i++) 
        { 
           $string.="<div align=\"center\">
            <label for=\"Band\">Band: </label><input type=\"text\" name=\"Veranstalltungsplan[$i" . "Band]\" 
            id=\"Veranstalltungsplan[$i" . "Band]\" value = \"" . $_SESSION["Veranstalltungsplan"][$i . "Band"] . "\" ></div>"
            .$this->senden("+", $i . "+")
            .$this->senden("-", $i . "-");
            $titelAnzahl = $titelAnzahlliste[$i . "Band"];
            for ($e = 1; $e <= $titelAnzahl; $e++) 
            {
                $stringzwei = "<div align=\"center\"><label for=\"Titel\">Titel: </label><input type=\"text\" name=\"Veranstalltungsplan[$e" . "Titel" . $i . "Band]\" id=\"Veranstalltungsplan[$e" . "Titel]\" value = \"" . $_SESSION["Veranstalltungsplan"][$e . "Titel" . $i . "Band"] . "\" >
                <label for=\"Länge\">Länge: </label><input type=\"number\" name=\"Veranstalltungsplan[$e" . "Minuten" . $i . "Band]\" id= \"Veranstalltungsplan[$e" . "Minuten" . $i . "Band]\"min=\"0\" max=\"59\" value = \"" . $_SESSION["Veranstalltungsplan"][$e . "Minuten" . $i . "Band"] . "\"> :
                <input type=\"number\" name=\"Veranstalltungsplan[$e" . "Sekunden" . $i . "Band]\" id= \"Veranstalltungsplan[$e" . "Sekunden" . $i . "Band]\" min=\"0\" max=\"59\" value = \"" . $_SESSION["Veranstalltungsplan"][$e . "Sekunden" . $i . "Band"] . "\" >
                <br><br></div>"; 
                $string .= $stringzwei;
            } 
        }
        return $string;
    }
    private function eingabefelder($was, $namepost, $typ, $inhalt)# variable eigabefelder
    {
        return "<div align=\"center\"><label for=\"$namepost\">$was: </label>        
        <input type=\"$typ\" name=\"$namepost\" id=\"$namepost\" value = \"$inhalt\"><br><br></div>"; 
    }
    private function datum($name, $was) # eingabefeld für start und end datum
    {
        return "<div align=\"center\"><label for=\"$name" . "[Datumfrom]\">$was: </label>  <input type=\"date\"name=\"$name" . "[Datumfrom]\"id=\"$name" . "[Datumfrom]\"></div> 
       <div align=\"center\"><label for=\"$name" . "[Datumto]\">$was: </label>  <input type=\"date\"name=\"$name" . "[Datumto]\"id=\"$name" . "[Datumto]\"></div> "; 
    }
    private function ausgabe($inhalt)# wiedergabe der Eintraege  
    {
        return "<div align=\"center\">$inhalt<br><br></div>"; 
    }
    private function textarea($was, $namepost, $inhalt) # erstellt eine textarea
    {
        return "<div align=\"center\"><label for=\"$namepost\">$was: </label>        
        <textarea name=\"$namepost\" rows=\"5\" cols=\"40\" value = \"$inhalt\"></textarea><br><br></div>"; 
    }
    private function senden($aktion, $name) #sende button
    {
        return "<div align=\"center\"><input type=\"submit\"name=\"$name\" value=\"$aktion\"style=\"background-color:#8df6ff;border-radius:12px;\"></div> ";
    }
    
    function formKopf($methode, $action) # form kopf
    {
        return "<form method=\"$methode\" action=\"$action\">";  
    }
    function festivalnamen()
    {
        $this->titlename = $_SESSION["Festivalname"];

    }
    function ersteSeite()
    {
        return $this->eingabefelder("Festivalname", "Festivalname", "text", "Emdival")
        .$this->senden("erstellen", "erstellen");;
    }
    function seiteEins() 
    {
        $this->controller->rechnerBand(); # anzahl der felder wird berechnet
        $this->controller->rechnerTitel($_SESSION["anzahl"]); # anzahl der felder wird berechnet
        $string = $this->eingabefelderband($_SESSION["anzahl"], $_SESSION["titelanzahl"])
        .$this->senden("speichern", "speichern")
        .$this->senden("Ausdruck", "Ausdruck")
        ."<div align=\"center\"><a href= index.php?add=1>Einzufügen</a><br><br></div> 
        <div align=\"center\"><a href= index.php?add=21>abziehen</a><br><br></div>"; 
        return $string;
    }
    function seiteZwei()
    {
        $string =$this->eingabefelder("Name", "Beschreibung[Name]", "text", "GuteFrage")
        .$this->eingabefelder("Ort", "Beschreibung[Ort]", "text", "Seattel")
        .$this->eingabefelder("Start", "Beschreibung[Zeit]", "time", "")
        .$this->datum("Beschreibung", "Datum")
        .$this->textarea("Beschreibung", "Beschreibung[Beschreibung]", "Huhuhuhuhuhuh")
        .$this->senden("weiter", "weiter");
        return $string;
    }
    function seiteDrei()
    {
        $string = $this->ausgabe("Name: " . $_SESSION["Beschreibung"]["Name"])
        .$this->ausgabe("Ort: " . $_SESSION["Beschreibung"]["Ort"])
        .$this->ausgabe("Start: " . $_SESSION["Beschreibung"]["Zeit"])
        .$this->ausgabe("Ende: " . $this->controller->endZeit())
        .$this->ausgabe($this->controller->datumausgabe())
        .$this->ausgabe("Beschreibung: " . $_SESSION["Beschreibung"]["Beschreibung"]);
        for ($i = 1; $i <= $_SESSION["anzahl"]; $i++) 
        {
            $string.= $this->ausgabe("Band: " . $_SESSION["Veranstalltungsplan"][$i . "Band"]);
            for ($e = 1; $e <= $_SESSION["titelanzahl"][$i . "Band"]; $e++) 
            {
                $stringzwei =$this->ausgabe(" Titel: " . $_SESSION["Veranstalltungsplan"][$e . "Titel" . $i . "Band"] . " Länge: " . $_SESSION["Veranstalltungsplan"][$e . "Minuten" . $i . "Band"] . " : " . $_SESSION["Veranstalltungsplan"][$e . "Sekunden" . $i . "Band"] . " min");
                $string.= $stringzwei;
            } 
        }
        $string = $string.$this->ausgabe("Spielzeit: ".$this->controller->rechnerZeit())
        .$this->ausgabe("Titelanzahl: ".$this->controller->titelzaehlen());
        return $string;
    }
}
?>