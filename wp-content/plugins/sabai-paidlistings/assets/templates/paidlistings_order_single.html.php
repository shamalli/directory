<table class="sabai-table sabai-paidlistings-order">
    <thead>
        <tr>
            <th><?php echo __('Field', 'sabai-paidlistings');?></th>
            <th><?php echo __('Value', 'sabai-paidlistings');?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong><?php echo __('Order ID', 'sabai-paidlistings');?></strong></td>
            <td><?php Sabai::_h($order->getLabel());?></td>
        </tr>
        <tr>
            <td><strong><?php echo __('Order Date', 'sabai-paidlistings');?></strong></td>
            <td><?php echo $this->Date($order->created);?></td>
        </tr>
<?php if ($order->Entity):?>
        <tr>
            <td><strong><?php echo $this->Entity_BundleLabel($this->Entity_Bundle($order->Entity), true);?></strong></td>
            <td><?php echo $order->Entity->isPublished() ? $this->Entity_Link($order->Entity) : Sabai::h($order->Entity->getTitle());?></td>
        </tr>
<?php endif;?>
        <tr>
            <td><strong><?php echo __('User', 'sabai-paidlistings');?></strong></td>
            <td><?php echo $this->UserIdentityLinkWithThumbnailSmall($order->User);?></td>
        </tr>
        <tr>
            <td><strong><?php echo __('Price', 'sabai-paidlistings');?></strong></td>
            <td><?php echo $order->getFormattedPrice();?></td>
        </tr>
        <tr>
            <td><strong><?php echo __('Payment Method', 'sabai-paidlistings');?></strong></td>
            <td><?php echo $order->gateway;?></td>
        </tr>
<?php if ($order->transaction_id):?>
        <tr>
            <td><strong><?php echo __('Transaction ID', 'sabai-paidlistings');?></strong></td>
            <td><?php echo $order->transaction_id;?></td>
        </tr>
<?php endif;?>
        <tr>
            <td><strong><?php echo __('Status', 'sabai-paidlistings');?></strong></td>
            <td><span class="sabai-label <?php echo $order->getStatusLabelClass();?>"><?php echo $order->getStatusLabel();?></span></td>
        </tr>
    </tbody>
</table>
<br />
<ul class="sabai-nav sabai-nav-tabs" id="sabai-paidlistings-order-tabs">
    <li<?php if ($tab !== 'logs'):?> class="sabai-active"<?php endif;?>><?php echo $this->LinkToRemote(__('Order Items', 'sabai-paidlistings'), $CURRENT_CONTAINER, $this->Url($CURRENT_ROUTE, array('order_id' => $order->id), 'sabai-paidlistings-order-tabs'), array('scroll' => false, 'width' => 0));?></li>
    <li<?php if ($tab === 'logs'):?> class="sabai-active"<?php endif;?>><?php echo $this->LinkToRemote(__('Order Logs', 'sabai-paidlistings'), $CURRENT_CONTAINER, $this->Url($CURRENT_ROUTE, array('order_id' => $order->id, 'tab' => 'logs'), 'sabai-paidlistings-order-tabs'), array('scroll' => false, 'width' => 0));?></li>
</ul>
<div style="margin-top:1em;">
    <?php echo $this->Form_Render($form);?>
</div>