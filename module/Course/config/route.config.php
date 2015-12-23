<?php
return array(
    'router' => array(
        'routes' => array(
            'course' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/course[/:action][/:id][/page/:page][/limit/:limit]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page'     => '[0-9]+',
                        'limit'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Course\Controller\Index',
                        'action'     => 'index',
                        'page' => 1,
                        'limit' => 10
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
                        'route'    => 'currency download',
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