<?php
return array(
    'assetic_configuration' => array(
        'controllers' => array(
            'Course\Controller\Index' => array(
                '@head_jquery',
                '@head_bootstrap_js',
                '@head_bootstrap_css',
                '@head_app_css',
                'actions' => array(
                    'index' => array(
                        '@course_js',
                        '@course_css',
                    )
                )
            )
        ),
        'modules' => array(
            'county' => array(
                'root_path' => __DIR__ . '/../assets',
                'collections' => array(
                    'course_js' => array(
                        'assets' => array(
                            'js/course.js',
                            'js/jquery.number.min.js'
                        ),
                    ),
                    'course_css' => array(
                        'assets' => array(
                            'css/course.css'
                        )
                    )
                )
            ),
        )
    ),
);