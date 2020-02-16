<?php
class Security
{
    private static $seed = 'O8SPIZLDUqfBmStCXtc3';

    static public function getSeed() {
        return self::$seed;
    }

    public static function getCaptchaValidation($response)
    {
        // Paramètre renvoyé par le recaptcha : $response
        // Clé secrète du reCaptcha
        $secret = "6LdQyMEUAAAAAEFKnw_7Tfno9t2TkDv2BJp-LGwB";

        // On récupère l'IP de l'utilisateur
        $remoteip = $_SERVER['REMOTE_ADDR'];


        $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
            . $secret
            . "&response=" . $response
            . "&remoteip=" . $remoteip;

        //On effectue une requête sur l'API de reCaptcha avec file_get_content et on déserialize le JSON vers la variable decode
        $decode = json_decode(file_get_contents($api_url), true);

        //On retourne la réponse du serveur
        return $decode['success'];
    }

    public static function chiffrer($texte_en_clair)
    {
        $texte_chiffre = hash('sha256', $texte_en_clair . Security::getSeed());
        return $texte_chiffre;
    }

    public static function generateRandomHex() {
        // Generate a 32 digits hexadecimal number
        $numbytes = 16; // Because 32 digits hexadecimal = 16 bytes
        $bytes = openssl_random_pseudo_bytes($numbytes); 
        $hex   = bin2hex($bytes);
        return $hex;
      }
}
?>