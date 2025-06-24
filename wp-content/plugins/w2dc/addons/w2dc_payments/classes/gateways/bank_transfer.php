<?php

class w2dc_bank_transfer extends w2dc_payment_gateway
{
	public function __construct()
	{
        parent::__construct();
        
        $this->logIpn = FALSE;
	}

    public function name() {
    	return esc_html__('Bank transfer', 'w2dc');
    }

    public function description() {
    	return esc_html__('Print invoice and transfer the payment (bank transfer information included)', 'w2dc');
    }
    
    public function buy_button()
    {
    	return '<img src="' . W2DC_PAYMENTS_RESOURCES_URL . 'images/bank.png" />';
    }
    
    public function submitPayment($invoice) {
    	w2dc_addMessage(esc_html__('You chose bank transfer payment gateway, now print invoice and transfer the payment', 'w2dc'));
    }
}
