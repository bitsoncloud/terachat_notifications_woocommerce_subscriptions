<?php

add_filter("sam_order_statuses", "insert_teranotif_sub_stats");
function insert_teranotif_sub_stats($stats){
    $new_stats = [
        "actives" => "Suscripción Activa",
        "cancelleds" => "Suscripción Cancelada",
        "trialends" => "Suscripción de prueba expirada",
        "pcancels" => "Suscripción Pendiente de cancelación"
    ];

    $stats = array_merge($stats, $new_stats);
    return $stats;
}

add_action('woocommerce_subscription_status_active', 'teranotif_sub_start', 10, 1);
add_action('woocommerce_subscription_status_cancelled', 'teranotif_sub_cancelled', 10, 1);
add_action('woocommerce_scheduled_subscription_trial_end', 'teranotif_sub_trial_end', 10, 1);
add_action('woocommerce_subscription_status_pending-cancel', 'teranotif_sub_pending_cancel', 10, 1);

function teranotif_sub_start($sub_id){
    $suscripcion = new WC_Subscription($sub_id);
    $orden = new WC_Order($suscripcion->get_last_order());
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("sam_order_actives");
    $suscripcion->add_order_note($msg." ".$phoneFormatted." ".$suscripcion->get_last_order());
    $msg = parseMSG($msg, $orden->get_id());
    $suscripcion->add_order_note($msg." ".$phoneFormatted." ".$orden->get_id());
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}

function teranotif_sub_cancelled($sub_id){
    $suscripcion = new WC_Subscription($sub_id);
    $orden = new WC_Order($suscripcion->get_last_order());
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("sam_order_cancelleds");
    $msg = parseMSG($msg, $orden->get_id());
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}

function teranotif_sub_trial_end($sub_id){
    $suscripcion = new WC_Subscription($sub_id);
    $orden = new WC_Order($suscripcion->get_last_order());
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("sam_order_trialends");
    $msg = parseMSG($msg, $orden->get_id());
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}

function teranotif_sub_pending_cancel($sub_id){
    $suscripcion = new WC_Subscription($sub_id);
    $orden = new WC_Order($suscripcion->get_last_order());
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("sam_order_pcancels");
    $msg = parseMSG($msg, $orden->get_id());
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}