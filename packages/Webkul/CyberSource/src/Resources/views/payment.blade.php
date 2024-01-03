<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CyberSource Payment Gateway Redirection.......</title>
</head>
<body>
        <form id="payment_form" action="{{ route('cyber_source.payment.confirmation') }}" method="post">
            @csrf
            <input type="hidden" name="access_key" value="4fa9085dd8223fbcbbaded7986528552">
            <input type="hidden" name="profile_id" value="C3035A2C-FEFD-4AA1-954E-F61742E51319">
            <input type="hidden" name="transaction_uuid" value="<?php echo uniqid(); ?>">
            <input type="hidden" name="payer_authentication_transaction_mode" value="S">
            <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,signed_date_time,locale,transaction_type,reference_number,amount,customer_cookies_accepted,skip_decision_manager,currency,unsigned_field_names,customer_ip_address,device_fingerprint_id,consumer_id">
            <input type="hidden" name="unsigned_field_names">
            <input type="hidden" name="signed_date_time" value="2023‑12‑22T15:37:57Z">
            <input type="hidden" name="locale" value="en">
            <input type="hidden" name="card_type" value="001">
            <input type="hidden" name="customer_cookies_accepted" value="true">
            <input type="hidden" name="skip_decision_manager" value="false">
            <input type="hidden" name="device_fingerprint_id" value="1081504">
            <input type="hidden" name="customer_ip_address" value="192.168.15.44">
            <input type="hidden" name="consumer_id" value="292">
            <fieldset>
                <legend>Payment Details</legend>
                <div id="paymentDetailsSection" class="section">
                    <span>transaction_type:</span><input type="text" name="transaction_type" size="25" value="authorization"><br/>
                    <span>reference_number:</span><input type="text" name="reference_number" size="25" value="123456"><br/>
                    <span>amount:</span><input type="text" name="amount" size="25" value="3200.00"><br/>
                    <span>currency:</span><input type="text" name="currency" size="25" value="TZS"><br/>
                </div>
            </fieldset>

            <input type="submit" id="submit" name="submit" value="Submit"/>
        </form>
</body>
</html>

