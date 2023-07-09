<div class="sabai-row">
<?php foreach ($plans as $plan):?>
    <div class="sabai-col-md-<?php echo $span;?><?php if ($span < 6):?> sabai-col-sm-6<?php endif;?>">
        <div class="sabai-paidlistings-pricing-table<?php if ($plan['featured']):?> sabai-paidlistings-featured<?php endif;?><?php if (isset($color)):?> sabai-paidlistings-pricing-table-<?php Sabai::_h($color);?><?php endif;?>">
            <div class="sabai-paidlistings-pricing-table-header">
                <h2><?php Sabai::_h($plan['name']);?></h2>
                <span><?php Sabai::_h($plan['description']);?></span>
            </div>
            <div class="sabai-paidlistings-pricing-table-price">
                <span class="sabai-paidlistings-pricing-table-currency"><?php echo $plan['price']['symbol'];?></span>
                <strong><?php echo $plan['price']['value'];?></strong>
<?php   if ($plan['price']['decimals']):?>
                <sup><?php echo $plan['price']['decimals'];?></sup>
<?php   endif;?>
<?php   if ($plan['payment_type']):?>
                <span class="sabai-paidlistings-pricing-table-payment-type"><?php echo mb_strtolower($plan['payment_type']);?></span>
<?php   endif;?>
            </div>
            <div class="sabai-paidlistings-pricing-table-body">
<?php   if ($max_feature_count):?>
                <ul>
<?php     for ($i = 0; $i < $max_feature_count; $i++):?>
                    <li><?php if ($feature = array_shift($plan['features'])):?><?php if ($feature['icon']):?><i class="fa fa-fw fa-<?php Sabai::_h($feature['icon']);?>"></i> <?php endif;?><?php Sabai::_h($feature['label']);?><?php endif;?></li>
<?php     endfor;?>
<?php   endif;?>
                </ul>
            </div>
            <div class="sabai-paidlistings-pricing-table-footer">
<?php if (count($plan['buttons']) === 1):?>
                <?php echo $plan['buttons'][0];?>
<?php else:?>               
                <?php echo $this->SplitDropdownButtonLinks($plan['buttons'], array('success'), null, false);?>
<?php endif;?>
            </div>
        </div>
    </div>
<?php endforeach;?>
</div>   
