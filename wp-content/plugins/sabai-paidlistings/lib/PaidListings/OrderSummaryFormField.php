<?php
class Sabai_Addon_PaidListings_OrderSummaryFormField extends Sabai_Addon_Form_Field_AbstractField
{    
    public function formFieldGetFormElement($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        if (!isset($data['#order_payment_type'])) return;
        
        if (!isset($data['#template']) && empty($data['#disable_template_override'])) {
            // Modify template slightly so that the field decription is displayed at the top of the table.
            $data['#template'] = '
<div<!-- BEGIN id --> id="{id}"<!-- END id --> class="sabai-form-field<!-- BEGIN class --> {class}<!-- END class -->">
  <!-- BEGIN label --><div class="sabai-form-field-label"><span>{label}</span><!-- BEGIN required --><span class="sabai-form-field-required">*</span><!-- END required --></div><!-- END label -->
  <!-- BEGIN label_2 --><div class="sabai-form-field-description">{label_2}</div><!-- END label_2 -->
  <!-- BEGIN field_prefix --><span class="sabai-form-field-prefix">{field_prefix}</span><!-- END field_prefix -->
  {element}
  <!-- BEGIN field_suffix --><span class="sabai-form-field-suffix">{field_suffix}</span><!-- END field_suffix -->
  <!-- BEGIN error_msg --><span class="sabai-form-field-error">{error}</span><!-- END error_msg -->
</div>                
';
        }
        if (isset($data['#order_plan'])) {
            $data += array(
                '#order_name' => $data['#order_plan']->name,
                '#order_description' => $data['#order_plan']->getDescription($data['#order_payment_type']),
                '#order_currency' => $data['#order_plan']->currency,
                '#order_price' => $data['#order_plan']->getPrice($data['#order_payment_type']),
            );
        }
        $markup = sprintf('
<table class="sabai-table sabai-paidlistings-order-summary">
    <thead>
        <tr>
            <th class="sabai-paidlistings-order-item-name">%s</th>
            <th class="sabai-paidlistings-order-item-price">%s</th>
            <th class="sabai-paidlistings-order-item-quantity">%s</th>
            <th class="sabai-paidlistings-order-item-amount">%s</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="sabai-paidlistings-order-item-name"><strong>%s</strong><div>%s</div></td>
            <td class="sabai-paidlistings-order-item-price">%s</td>
            <td class="sabai-paidlistings-order-item-quantity">%s</td>
            <td class="sabai-paidlistings-order-item-amount">%s</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="sabai-paidlistings-order-total">%s</td>
            <td class="sabai-paidlistings-order-total-price">%s</td>
        </tr>
    </tfoot>
</table>',
            __('Plan name', 'sabai-paidlistings'),
            __('Unit price', 'sabai-paidlistings'),
            __('Quantity', 'sabai-paidlistings'),
            __('Amount', 'sabai-paidlistings'),
            Sabai::h($data['#order_name']),
            Sabai::h($data['#order_description']),
            $formatted_price = $this->_addon->getApplication()->PaidListings_MoneyFormat($data['#order_price'], $data['#order_currency']),
            1,
            $formatted_price,
            __('Total:', 'sabai-paidlistings'),
            $formatted_price
        );
        
        return $form->createHTMLQuickformElement('static', $name, $data['#label'], $markup);
    }
    
    public function formFieldOnSubmitForm($name, &$value, array &$data, Sabai_Addon_Form_Form $form)
    {

    }

    public function formFieldOnCleanupForm($name, array &$data, Sabai_Addon_Form_Form $form)
    {

    }

    public function formFieldOnRenderForm($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        $form->renderElement($data);
    }
}