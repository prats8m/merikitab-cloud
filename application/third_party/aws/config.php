<?php

return array(
    // Bootstrap the configuration file with AWS specific features
    'includes' => array('_aws'),
    'services' => array(
        // All AWS clients extend from 'default_settings'. Here we are
        // overriding 'default_settings' with our default credentials and
        // providing a default region setting.
        'default_settings' => array(
            'params' => array(
             'key'    => 'AKIAIF5UAD4WFUBLWFUQ',
                'secret' => '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',
                'region' => 'us-east-1'
            )
        )
    )
);



/*
Access Key ID:
AKIAIGXWQLASWLXZHZ5A
Secret Access Key:
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
*/
