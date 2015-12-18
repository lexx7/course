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
);