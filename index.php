<?php
//Comment this two lines if you are in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Consider that the main website is www.mydomaine.ci

// required libs
require_once __DIR__ . '/src/cinetpay.php';
require_once __DIR__ . '/commande.php';

// This class manage "Commande" table in DB
$commande = new Commande();
try {
    //transaction id
    $id_transaction = date("YmdHis"); // or $id_transaction = Cinetpay::generateTransId()
    // Payment description
    $description_du_paiement = "Mon produit de ref: $id_transaction";
    // Payment Date must be on date format
    $date_transaction = date("Y-m-d H:i:s");
    // Amount
    $montant_a_payer = 100;
    
    $devise = 'XAF';

    // put a value that you can use to identify the buyer in your system
    $identifiant_du_payeur = 'contacts@trapyourtrip.com';

    //Veuillez entrer votre apiKey
    $apiKey = "14805067945e0b6eb3374f47.48751476";
    //Veuillez entrer votre siteId
    $site_id = "962769";

    //platform ,  utiliser PROD si vous avez créé votre compte sur www.cinetpay.com  ou TEST si vous avez créé votre compte sur www.sandbox.cinetpay.com
    $plateform = "PROD";

    //la version ,  utilisé V1 si vous voulez utiliser la version 1 de l'api
    $version = "V2";

    // nom du formulaire CinetPay
    $formName = "goCinetPay";
    // notify url
    $notify_url = 'www.petit-commercant.fr/notify/';
    // return url
    $return_url = 'www.petit-commercant.fr/return/';
    // cancel url
    $cancel_url = 'www.petit-commercant.fr';

    // cinetpay button type, must be 1, 2, 3, 4 or 5
    $btnType = 2;
    // button size, can be 'small' , 'large' or 'larger'
    $btnSize = 'large';
    // fill command class
    $commande->setTransId($id_transaction);
    $commande->setMontant($montant_a_payer);

    // save transaction in db
    $commande->create();

    // create html form for your basket
    $CinetPay = new CinetPay($site_id, $apiKey, $plateform, $version);
    $CinetPay->setTransId($id_transaction)
        ->setDesignation($description_du_paiement)
        ->setTransDate($date_transaction)
        ->setCurrency($devise)
        ->setAmount($montant_a_payer)
        ->setDebug(true)// put it on true, if you want to activate debug
        ->setCustom($identifiant_du_payeur)// optional
        ->setNotifyUrl($notify_url)// optional
        ->setReturnUrl($return_url)// optional
        ->setCancelUrl($cancel_url)// optional
        ->displayPayButton($formName, $btnType, $btnSize);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>