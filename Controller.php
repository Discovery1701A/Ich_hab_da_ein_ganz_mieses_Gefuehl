<?php
/**
 * Controller zu Aufgabe 3
 * @author  Anna Rieckmann
 * @ Formular
 */
class Controller
{
    function __construct($startanzahl)
    {
        $this->startanzahl = $startanzahl; 
    }
    function rechnerBand() # berechnet die anzahl der Band felder
    {
        if ($_SESSION["add"] == 1) 
        {
            $_SESSION["anzahl"] = intval($_SESSION["anzahl"]) + 1;
            $_SESSION["add"] = " ";
        }
        if (empty($_SESSION["add"]) ) 
        {
            $_SESSION["anzahl"] = $this->startanzahl;
        }
        if ($_SESSION["add"] == 21 && $_SESSION["anzahl"] > 1) 
        {
            $_SESSION["add"] = " ";
            $_SESSION["anzahl"] = intval($_SESSION["anzahl"]) - 1;
            array_pop($_SESSION["titelanzahl"]);
        }
    }
    function rechnerTitel($bandAnzahl) # bestimmt wie viele Titel eine Band hat
    {
        for ($i = 1; $i <= $bandAnzahl; $i++) {
            if (empty($_SESSION["titelanzahl"][$i . "Band"])) 
            {
                $_SESSION["titelanzahl"][$i . "Band"] = 1;
            }
            if (!empty($_POST[$i . "+"]) && $_POST[$i . "+"] == "+") 
            {
                $_SESSION["titelanzahl"][$i . "Band"] += 1;
            } elseif (!empty($_POST[$i . "-"]) && $_POST[$i . "-"] == "-" && 1 < $_SESSION["titelanzahl"][$i . "Band"]) 
            {
                $_SESSION["titelanzahl"][$i . "Band"] -= 1;
            }
        }
    }
    function rechnerZeit() # bestimmt die dauer aller Titel
    {
        for ($i = 1; $i <= $_SESSION["anzahl"]; $i++) 
        {
            for ($e = 1; $e <= $_SESSION["titelanzahl"][$i . "Band"]; $e++) 
            {
                $gesamtMinuten += intval($_SESSION["Veranstalltungsplan"][$e . "Minuten" . $i . "Band"]);
                $gesamtSekunden += intval($_SESSION["Veranstalltungsplan"][$e . "Sekunden" . $i . "Band"]);
            }
        }
        if ($gesamtSekunden > 59) 
        {
            if ($gesamtSekunden % 60 == 0) 
            {
                $gesamtMinuten += $gesamtSekunden / 60;
                $gesamtSekunden -= $gesamtSekunden;
            } 
            else 
            {
                $gesamtMinuten += ($gesamtSekunden - ($gesamtSekunden % 60)) / 60;
                $gesamtSekunden -= ($gesamtSekunden - ($gesamtSekunden % 60));
            }
        }
        if ($gesamtMinuten > 59) 
        {
            if ($gesamtMinuten % 60 == 0) 
            {
                $gesamtStunde += $gesamtMinuten / 60;
                $gesamtMinuten -= $gesamtMinuten;
            } 
            else 
            {
                $gesamtStunde += ($gesamtMinuten - ($gesamtMinuten % 60)) / 60;
                $gesamtMinuten -= ($gesamtMinuten - ($gesamtMinuten % 60));
            }
            $gesamtzeitausgabe = ($gesamtStunde . ":" . $gesamtMinuten . ":" . $gesamtSekunden) . " std.";
        } 
        else 
        {
            $gesamtzeitausgabe = ($gesamtMinuten . ":" . $gesamtSekunden) . " min.";
        }
        $this->gesamtMinuten = $gesamtMinuten;
        $this->gesamtStunde = $gesamtStunde;
        return $gesamtzeitausgabe;
    }
    function endZeit() # betimmt die zeit wann der letzte titel durch ist sekunden werden vernachlässigt
    {  
        $this->rechnerZeit();
        return date("H:i", strtotime($_SESSION["Beschreibung"]["Zeit"])+ ($this->gesamtMinuten*60+$this->gesamtStunde* 3600)); 
    }
    function titelzaehlen() # zählt die gesamtanzahl der Titel
    {
        foreach ($_SESSION["titelanzahl"] as $band => $zahl) 
        {
            $gesamtanzahl += $zahl;
        }
        return $gesamtanzahl;
    }
    function datumAusgabe() # bereitet den datums input auf
    {
        if (!empty($_SESSION["Beschreibung"]["Datumfrom"]) && !empty($_SESSION["Beschreibung"]["Datumto"])) 
        {
            $datums = "ab den " . $_SESSION["Beschreibung"]["Datumfrom"] . " bis zum " . $_SESSION["Beschreibung"]["Datumto"];
        } elseif (!empty($_SESSION["Beschreibung"]["Datumfrom"])) 
        {
            $datums = "den " . $_SESSION["Beschreibung"]["Datumfrom"];
        } elseif (!empty($$_SESSION["Beschreibung"]["Datumto"])) 
        {
            $datums = "den " . $_SESSION["Beschreibung"]["Datumto"];
        } 
        else 
        {
            $datums = "";
        }
        return $datums;
    }
    function schreiben()
    {
        $file = new SplFileObject("4sprint.json", "w");
        $js = json_encode( $_SESSION);
        $written = $file->fwrite(preg_quote($js));
        echo "Wrote $written bytes to file";
        echo"<div align=\"center\"><a href=http://wisem22006.medientechnik-emden.de/4sprint/4sprint.json>Click here</a><br><br></div>";
    }
}
?>