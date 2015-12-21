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
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();

        if($request->isPost()) {

        }

        return new ViewModel();
    }

    public function getCourseAction()
    {
        $request = $this->getRequest();

        $course = array();

        if($request->isGet()) {
            /** @var Currency $service */
            $service = $this->getServiceLocator()->get('serviceCurrency');

            $course = $service->course($request->getQuery()->toArray());
        }

        return new JsonModel($course);
    }
}
