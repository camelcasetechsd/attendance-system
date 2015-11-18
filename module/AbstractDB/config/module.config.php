<?php
return array(
    'service_manager' => array(
        'aliases' => array(
            'basicQuery' => 'AbstractDB\Service\Query',
        ),
        'factories' => array(
            'AbstractDB\Service\Query' => 'AbstractDB\Service\Query\QueryFactory',
        )
    ),
);