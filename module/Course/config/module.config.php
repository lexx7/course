<?php
namespace Course;
use Zend\View\Helper\Doctype;

$route = include(__DIR__ . '/route.config.php');
$assetic = include(__DIR__ . '/assetic.config.php');

return array_merge($route, $assetic,
    array(
        'doctrine' => array(
            'driver' => array(
                'countyEntity' => array(
                    'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver', //PHPDriver
                    'cache' => 'array',
                    'paths' => __DIR__ . '/../src/Course/Entity',//'/doctrine',
                ),
                'orm_default' => array(
                    'drivers' => array(
                        'Course\Entity' => 'countyEntity'
                    ),
                ),
            ),
        ),
        'controllers' => array(
            'invokables' => array(
                'Course\Controller\Index' => 'Course\Controller\IndexController'
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
