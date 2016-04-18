<?php
/**
 * Created by PhpStorm.
 * User: fabio
 * Date: 17/04/2016
 * Time: 17:25
 */

namespace login;
include_once "class.utils.php";
use utils\utils;



class login
{
    protected $licenza;
    protected $user;
    protected $codici;
    protected $tabella;
    protected $numeroAttivazioni;

    function __construct()
    {
        $u = new utils();
        $u->connect();
        $this->licenza = (isset($_REQUEST['NL'])) ? $u->anti_injection($_REQUEST['NL']) : null;
        $this->user = (isset($_REQUEST['NU'])) ? $u->anti_injection($_REQUEST['NU']) : null;
        $this->user = (isset($_REQUEST['NU'])) ? $u->anti_injection($_REQUEST['NU']) : null;
        $this->feature = (isset($_REQUEST['feature'])) ? $u->anti_injection($_REQUEST['feature']) : null;

        $this->codici = "";
        $this->tabella = "ab_licenze";

        if (!empty($this->feature)) {
            switch($this->feature){
                case "generaCodici":
                    login::generaCodici();
                break;
                case "eliminaLicenza":
                    login::eliminaLicenza($this->licenza);
                break;
                case "checkLicenza":
                    login::checkLicenza($this->licenza);
                break;
                case "attivaLicenza":
                    login::attivaLicenza($this->licenza);
                break;
                case "disattivaLicenza":
                    login::disattivaLicenza($this->licenza);
                break;
            }
        }

        if (!empty($this->licenza) AND !empty($this->user)) {
            $this->doLogin($this->licenza,$this->user);
        } else {
            login::loginForm();
        }

        //$this->doLogin($this->licenza,$this->user);
    }

    public function doLogin($licenza,$user){
       // echo __CLASS__ . "/" . __FUNCTION__;
        $dati = array();
        $numrec = 0;
       utils::SelectTabelle("ab_licenze",array("*"),"where NL = '" . $licenza . "' AND NU= '". $user ."'", null, null,$numrec,$dati);
        // caso 0 dati -> inserisco
        if (count($dati) == 0){
            $ut = array();
            // controllo che non ci sia già un altro username
            utils::SelectTabelle("ab_licenze",array("NU"),"where NL = '" . $licenza . "'", null, null,$numrec,$ut);
            //utils::trace($ut);
            if (empty($ut[0]["NU"])){
                utils::UpdateTabella("ab_licenze", array("NU" => $user, "NA" => 1),"NL = '".$licenza."'");
            } else {
                echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><errore>codice già assegnato</errore>";
            }
        } else {
            if ($dati[0]["NA"] < $dati[0]["NAMAX"]){
                utils::UpdateTabella("ab_licenze", array("NU" => $user, "NA" => $dati[0]["NA"]+1),"NL = '".$licenza."'");
            } else {
                echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><errore>Limite licenze raggiunto</errore>";
            }
        }

    }

    public static function loginForm(){
        $html = '<form action="">
                <input type="text" name="NL">
                <input type="text" name="NU">
                <button type="submit">LOGIN</button>
                </form>';
        echo $html;
    }

    public function generaCodici($quanti=1){
        //echo __FUNCTION__;
        for($i=1;$i<=$quanti;$i++){
            $codice = utils::SessioneCasuale(8);
            utils::InsertTabella($this->tabella,array("NL" => $codice));
        }
        //utils::trace("IL TUO CODICE GENERATO: <strong>" . $codice . "</strong>");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><codice>$codice</codice>";
    }

    public function eliminaLicenza($licenza){
        utils::DeleteTabella($this->tabella,"where NL = '".$licenza."'");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Licenza cancellata</messaggio>";
    }

    public function checkLicenza($licenza){
        $dati = array();
        utils::SelectTabelle("ab_licenze",array("*"),"where NL = '" . $licenza . "'", null, null,$numrec,$dati);
        utils::trace($dati);
    }

    public function attivaLicenza($licenza){
        utils::UpdateTabella("ab_licenze", array("attivo" => 1),"NL = '".$licenza."'");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Licenza attivata</messaggio>";
    }

    public function disattivaLicenza($licenza){
        utils::UpdateTabella("ab_licenze", array("attivo" => -1),"NL = '".$licenza."'");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Licenza disattivata</messaggio>";
    }

}


$n = new login();