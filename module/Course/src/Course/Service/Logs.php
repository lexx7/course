<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 22.12.2015
 * Time: 0:05
 */

namespace Course\Service;


use Course\Document\LogsClient;
use Doctrine\ODM\MongoDB\DocumentManager;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Logs implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $_patternRequestWriteLog = '/get-course/';

    /**
     * Запись логов
     * @param Request $request
     * @param Response $response
     */
    public function write($request, $response)
    {
        $serverOptions = $request->getServer()->toArray();

        $requestUri = isset($serverOptions['REQUEST_URI']) ? $serverOptions['REQUEST_URI'] : null;

        // Проверка на запись от правильного запроса
        if(is_null($requestUri) || !preg_match($this->_patternRequestWriteLog, $requestUri)) return;

        $remoteAddr = isset($serverOptions['REMOTE_ADDR']) ? $serverOptions['REMOTE_ADDR'] : '';
        $requestTime = isset($serverOptions['REQUEST_TIME']) ? $serverOptions['REQUEST_TIME'] : 0;
        $requestTimeFloat = isset($serverOptions['REQUEST_TIME_FLOAT']) ? $serverOptions['REQUEST_TIME_FLOAT'] : 0;

        /** @var DocumentManager $dm */
        $dm = $this->getServiceLocator()->get('doctrine-document');
        $logsClient = new LogsClient();

        $logsClient
            ->setDatetime((new \DateTime())->setTimestamp($requestTime))
            ->setHeaders($request->getHeaders()->toString())
            ->setRequest($request->getContent())
            ->setResponse($response->getContent())
            ->setIpAddress($remoteAddr)
            ->setDuration(round(microtime(true), 4) - $requestTimeFloat);

        $dm->persist($logsClient);
        $dm->flush();
    }
}