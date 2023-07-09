<?php
interface Sabai_Addon_PaidListings_IGateway
{
    public function paidListingsGatewayGetInfo();
    public function paidListingsGatewayGetCheckoutForm(array $formStorage, Sabai_Addon_PaidListings_Model_Plan $plan);
    public function paidListingsGatewayCheckout(Sabai_Addon_Form_Form $form, Sabai_Addon_PaidListings_Model_Order $order, $returnUrl, $cancelUrl);
    public function paidListingsGatewayGetPostCheckoutNotice(Sabai_Addon_PaidListings_Model_Order $order);
}