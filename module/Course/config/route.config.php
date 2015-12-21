<?php
return array(
    'router' => array(
        'routes' => array(
            'course' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/course[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Course\Controller\Index',
                        'action'     => 'index',
                    ),
                )
            ),
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'valute' => array(
                    'options' => array(
                        'route'    => 'valute download',
                        'defaults' => array(
                            'controller' => 'Course\Controller\Console',
                            'action'     => 'download'
                        )
                    )
                )
            )
        )
    )
);