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
             'key'    => 'AKIAJQGB62E3DRQJAALQ',
                'secret' => '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',
					'region' => 'us-west-2'
                
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
