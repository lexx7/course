<?php
namespace Course;
use Zend\View\Helper\Doctype;

$route = include(__DIR__ . '/route.config.php');
$assetic = include(__DIR__ . '/assetic.config.php');

return array_merge($route, $assetic,
    array(
        'doctrine' => array(
            'driver' => array(
                'odm_driver' => array(
                    'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                    'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Document')
                ),
                'odm_default' => array(
                    'drivers' => array(
                        __NAMESPACE__ . '\Document' => 'odm_driver'
                    )
                )
            ),
        ),
        'controllers' => array(
            'invokables' => array(
                'Course\Controller\Index' => 'Course\Controller\IndexController',
                'Course\Controller\Console' => 'Course\Controller\ConsoleController'
            )
        ),
        'view_manager' => array(
            'template_path_stack' => array(
                __DIR__ . '/../view',
            ),
            'strategies' => array(
                'ViewJsonStrategy',
            ),
        ),
    ));
