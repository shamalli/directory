<?php
$tables = array(
    'paidlistings_plan' => array(
        'fields' => array(
            'plan_name' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 255,
                'default' => '',
            ),
            'plan_description' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_TEXT,
                'notnull' => true,
            ),
            'plan_type' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 50,
                'default' => '',
            ),
            'plan_price' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_DECIMAL,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'scale' => 2,
                'default' => 0,
            ),
            'plan_features' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_TEXT,
                'notnull' => true,
            ),
            'plan_active' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_BOOLEAN,
                'notnull' => true,
                'default' => true,
            ),
            'plan_weight' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 3,
                'default' => 0,
            ),
            'plan_currency' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 3,
                'default' => '',
            ),
            'plan_entity_bundle_name' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 40,
                'default' => '',
            ),
            'plan_onetime' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_BOOLEAN,
                'notnull' => true,
                'default' => true,
            ),
            'plan_recurring' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_TEXT,
                'notnull' => true,
            ),
            'plan_id' => array(
                'autoincrement' => true,
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'plan_created' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'plan_updated' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
        ),
        'indexes' => array(
            'plan_id' => array(
                'primary' => true,
                'fields' => array(
                    'plan_id' => array('sorting' => 'ascending'),
                ),
            ),
            'plan_entity_bundle_name' => array(
                'fields' => array(
                    'plan_entity_bundle_name' => array(
                    ),
                ),
            ),
        ),
   	'initialization' => array(
            'insert' => array(
            ),
        ),
    ),
    'paidlistings_order' => array(
        'fields' => array(
            'order_entity_id' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'order_status' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 2,
                'default' => 0,
            ),
            'order_price' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_DECIMAL,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'scale' => 2,
                'default' => 0,
            ),
            'order_transaction_id' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 100,
                'default' => '',
            ),
            'order_currency' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 3,
                'default' => '',
            ),
            'order_gateway' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 30,
                'default' => '',
            ),
            'order_gateway_data' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_TEXT,
                'notnull' => true,
            ),
            'order_payment_type' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 10,
                'default' => '',
            ),
            'order_id' => array(
                'autoincrement' => true,
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'order_created' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'order_updated' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'order_plan_id' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'order_user_id' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
        ),
        'indexes' => array(
            'order_id' => array(
                'primary' => true,
                'fields' => array(
                    'order_id' => array('sorting' => 'ascending'),
                ),
            ),
            'order_entity_id' => array(
                'fields' => array(
                    'order_entity_id' => array(
                    ),
                ),
            ),
            'order_transaction_id' => array(
                'fields' => array(
                    'order_transaction_id' => array(
                    ),
                ),
            ),
            'order_plan_id' => array('fields' => array('order_plan_id' => array())),
            'order_user_id' => array('fields' => array('order_user_id' => array())),
        ),
   	'initialization' => array(
            'insert' => array(
            ),
        ),
    ),
    'paidlistings_orderitem' => array(
        'fields' => array(
            'orderitem_status' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 1,
                'default' => 0,
            ),
            'orderitem_feature_name' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 50,
                'default' => '',
            ),
            'orderitem_id' => array(
                'autoincrement' => true,
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderitem_created' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderitem_updated' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderitem_order_id' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
        ),
        'indexes' => array(
            'orderitem_id' => array(
                'primary' => true,
                'fields' => array(
                    'orderitem_id' => array('sorting' => 'ascending'),
                ),
            ),
            'orderitem_order_id' => array('fields' => array('orderitem_order_id' => array())),
        ),
   	'initialization' => array(
            'insert' => array(
            ),
        ),
    ),
    'paidlistings_orderitemmeta' => array(
        'fields' => array(
            'orderitemmeta_key' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 30,
                'default' => '',
            ),
            'orderitemmeta_value' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_TEXT,
                'notnull' => true,
            ),
            'orderitemmeta_id' => array(
                'autoincrement' => true,
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderitemmeta_created' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderitemmeta_updated' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderitemmeta_orderitem_id' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
        ),
        'indexes' => array(
            'orderitemmeta_id' => array(
                'primary' => true,
                'fields' => array(
                    'orderitemmeta_id' => array('sorting' => 'ascending'),
                ),
            ),
            'orderitemmeta_key' => array(
                'fields' => array(
                    'orderitemmeta_key' => array(
                    ),
                ),
            ),
            'orderitemmeta_orderitem_id' => array('fields' => array('orderitemmeta_orderitem_id' => array())),
        ),
   	'initialization' => array(
            'insert' => array(
            ),
        ),
    ),
    'paidlistings_orderlog' => array(
        'fields' => array(
            'orderlog_message' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                'notnull' => true,
                'length' => 255,
                'default' => '',
            ),
            'orderlog_status' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 2,
                'default' => 0,
            ),
            'orderlog_is_error' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_BOOLEAN,
                'notnull' => true,
                'default' => false,
            ),
            'orderlog_id' => array(
                'autoincrement' => true,
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderlog_created' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderlog_updated' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderlog_order_id' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
            'orderlog_orderitem_id' => array(
                'type' => Sabai_Addon_Field::COLUMN_TYPE_INTEGER,
                'unsigned' => true,
                'notnull' => true,
                'length' => 10,
                'default' => 0,
            ),
        ),
        'indexes' => array(
            'orderlog_id' => array(
                'primary' => true,
                'fields' => array(
                    'orderlog_id' => array('sorting' => 'ascending'),
                ),
            ),
            'orderlog_order_id' => array('fields' => array('orderlog_order_id' => array())),
            'orderlog_orderitem_id' => array('fields' => array('orderlog_orderitem_id' => array())),
        ),
   	'initialization' => array(
            'insert' => array(
            ),
        ),
    ),
);
return array(
    'charset' => '',
    'description' => '',
    'tables' => $tables,
);