<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Course\Controller;

use Course\Service\Currency;
use Zend\Mvc\Controller\AbstractActionController;

class ConsoleController extends AbstractActionController
{
    public function downloadAction()
    {
        /** @var Currency $service */
        $service = $this->getServiceLocator()->get('serviceCurrency');

        $service
            ->download()
            ->parse()
            ->updateCache();
    }
}
