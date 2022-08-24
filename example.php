<?php 

// Add field-resolver
add_filter('wpgraphql_acf_register_graphql_field', function ($fieldConfig, 
    $typeName, $fieldName, $config) {
        $getValue = $fieldConfig['resolve'];

        if ('table' == $config['acf_field']['type']) {
            return [
                'type'    => 'Table',
                'resolve' => function ($root, $args, \WPGraphQL\AppContext $context, $info) use ($getValue) {
                    $value = $getValue($root, $args, $context, $info);

                    return [
                        'header'  => 1 == $value['p']['o']['uh'] ? array_map(function ($th) {
                            return $th['c'];
                        }, $value['h']) : [],
                        'body'    => array_map(function ($row) {
                            return array_map(function ($cell) {
                                return $cell['c'];
                            }, $row);
                        }, $value['b']),
                        'caption' => $value['p']['ca'] ?? '',
                    ];
                },
            ];
        }

        return $fieldConfig;
    }, 10, 4);

// Add to supported fields
add_filter('wpgraphql_acf_supported_fields', function ($fields) {
    $fields[] = 'table';
    return $fields;
});

// Add Table-Type
add_action('graphql_register_types', function () {
    register_graphql_object_type('Table', [
        'fields' => [
            'header'  => ['type' => ['list_of' => 'String']],
            'body'    => ['type' => ['list_of' => ['list_of' => 'String']]],
            'caption' => ['type' => 'String'],
        ],
    ]);
});