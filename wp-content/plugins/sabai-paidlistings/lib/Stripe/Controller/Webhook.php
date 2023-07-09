<?php
class Sabai_Addon_Stripe_Controller_Webhook extends Sabai_Controller
{    
    protected function _doExecute(Sabai_Context $context)
    {        
        if (!$input = @file_get_contents('php://input')) {
            $this->LogError('Failed reading Stripe webhook');
            return;
        }
        
        if (!$event_json = json_decode($input)) {
            $this->LogError('Failed parsing Stripe webhook: ' . $input);
            return;
        }
        
        $this->getAddon('Stripe')->initStripe();
        
        try {
            // for extra security, retrieve from the Stripe API
            $event = Stripe_Event::retrieve($event_json->id);
        } catch (Exception $e) {
            $this->LogError('Failed retrieving Stripe webhook: ' . $e->getMessage());
            return;
        }

        //customer.subscription.updated
        $this->Action('stripe_webhook_received', array($event));

        SabaiFramework_Application_HttpResponse::sendStatusHeader(200);
    }    
}