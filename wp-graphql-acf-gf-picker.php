<?php

/**
 * Plugin Name: GF ACF Block Form Picker
 */



if (!defined('ABSPATH')) {
    exit;
}

add_filter('wpgraphql_acf_supported_fields', function ($supported_fields) {
    $supported_fields[] = 'forms';

    return $supported_fields;
});

add_filter('wpgraphql_acf_register_graphql_field', function ($field_config, $type_name, $field_name, $config) {
    
    $acf_field = isset($config['acf_field']) ? $config['acf_field'] : null;
    $acf_type  = isset($acf_field['type']) ? $acf_field['type'] : null;


    if (!$acf_field) {
        return $field_config;
    }

    // ignore all other field types
    if ($acf_type !== 'forms') {
        return $field_config;
    }

    // define data type
    $field_config['type'] = 'GfForm';

    


    // add resolver
    $field_config['resolve'] = function ($root, $args, \WPGraphQL\AppContext $context, $info) use ($acf_field) {


        // wp_send_json( [  $acf_field ] );
        
        // should I use a more dynamic value from $acf_field here?
        $value = $root['attributes']['data']["gf_acf_picker"];

        
        // if ( isset ( $root['attributes']['data']["gf_acf_picker"] ) ) {
        //     $value = $root[ $root['attributes']['data']["gf_acf_picker"] ];
        // }

        if (!empty($value)) {
            $form = $context->get_loader(\WPGraphQL\GF\Data\Loader\FormsLoader::$name)->load_deferred($value);
        }

        return !empty($form) ? $form : null;
    };

    

    return $field_config;

}, 10, 4);
