<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Course;

use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;


class Module implements ConsoleUsageProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'serviceCurrency' => 'Course\Service\Currency',
                'Course\Service\Logs' => 'Course\Service\Logs',
            ),
            'factories' => array(
                'CacheAdapter' =>function($serviceManager) {
                    $config = $serviceManager->get('config');

                    $host = isset($config['memcached']['host']) ? $config['memcached']['host'] : 'localhost';
                    $port = isset($config['memcached']['port']) ? $config['memcached']['port'] : '11211';

                    $cache  = new \Zend\Cache\Storage\Adapter\Memcached();
                    $cache->setOptions(array(
                        'servers'   => array(
                            array(
                                $host,
                                $port
                            )
                        ),
                        'namespace'  => 'MYMEMCACHEDNAMESPACE',
                        'liboptions' => array (
                            'COMPRESSION' => true,
                            'binary_protocol' => true,
                            'no_block' => true,
                            'connect_timeout' => 100
                        )
                    ));

                    $plugin = new \Zend\Cache\Storage\Plugin\ExceptionHandler();
                    $plugin->getOptions()->setThrowExceptions(false);
                    $cache->addPlugin($plugin);

                    return $cache;
                }
            )
        );
    }

    /**
     * This method is defined in ConsoleUsageProviderInterface
     */
    public function getConsoleUsage(Console $console)
    {
        return array(
            'currency download' => 'Download courses currency',
        );
    }
}
