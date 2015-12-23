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
use Course\Service\Logs;
use Doctrine\DBAL\Schema\View;
use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get('Course\Form\Courses');

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function logsAction()
    {
        $page = $this->params('page');
        $limit = $this->params('limit');

        $sm = $this->getServiceLocator();
        /** @var DocumentManager $dm */
        $dm = $sm->get('doctrine-document');

        $paginator = new Paginator(
            new DoctrinePaginator(
                    $dm->createQueryBuilder('Course\Document\LogsClient')
                        ->getQuery()->execute()
            )
        );
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage($limit);

        $content = $dm->createQueryBuilder('Course\Document\LogsClient')
            ->limit($limit)->skip(($page-1)*$limit)
            ->sort('id', 'desc')
            ->getQuery()->toArray();

        $this->layout()->setVariable('logs', true);

        return new ViewModel(array(
            'paginator' => $paginator,
            'content' => $content,
        ));
    }

    public function getCourseAction()
    {
        $request = $this->getRequest();

        $course = array();

        if($request->isPost()) {
            /** @var Currency $service */
            $service = $this->getServiceLocator()->get('serviceCurrency');

            $course = $service->course($request->getPost()->toArray());
        }

        return new JsonModel($course);
    }

    public function __destruct()
    {
        /** @var Logs $service */
        $service = $this->getServiceLocator()->get('Course\Service\Logs');
        $service->write($this->getRequest(), $this->getResponse());
    }
}
