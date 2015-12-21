<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 20.12.2015
 * Time: 17:44
 */

namespace Course\Service;


use Course\Document\Courses;
use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Documents\CustomRepository\Repository;
use Zend\Cache\Storage\Adapter\Memcached;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Currency implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $_link = 'http://www.cbr.ru/scripts/XML_daily.asp';
    protected $_document = 'Course\Document\Courses';
    protected $_currencyConvert = 'USD';

    protected $_xml = null;
    /** @var DocumentManager */
    protected $_dm = null;
    /** @var Repository */
    protected $_repository = null;


    /**
     * Загрузка файла курсов валют с сайта ЦБ РФ
     * @return $this
     */
    public function download()
    {
        $downloadXml = file_get_contents($this->_link);

        $this->_xml = new \SimpleXMLElement($downloadXml);

        return $this;
    }

    /**
     * Разбор xml и сохранение в базу данных
     * @return $this
     */
    public function parse()
    {
        $this->_dm = $this->getServiceLocator()->get('doctrine-document');
        $this->_repository = $this->_dm->getRepository($this->_document);

        if(isset($this->_xml->Valute)) {
            /** @var \SimpleXMLElement $item */
            foreach ($this->_xml->Valute as $item) {;
                if(isset($item->CharCode))
                    $this->save((string) $item->CharCode, $item);
            }
        }

        $this->_dm->flush();

        return $this;
    }

    /**
     * Сохранение позиции в бд
     * @param $charCode
     * @param $item
     */
    protected function save($charCode, $item)
    {
        /** @var Courses $courses */
        $courses = $this->_repository->findOneBy(array('charCode' => $charCode));

        if(!$courses) {
            $courses = new Courses();
        }

        $document = $this->mergeFromArray($courses, (array) $item);

        $this->_dm->persist($document);
    }

    /**
     * Гидрация в Document
     * @param $document
     * @param array $data
     * @return object
     */
    public function mergeFromArray($document, array $data)
    {
        $hydrator = new DoctrineObject(
            $this->_dm,
            'Course\Document\Courses'
        );
        $data['Value'] = str_replace(',', '.', isset($data['Value']) ? $data['Value'] : '');
        return $hydrator->hydrate($data, $document);
    }

    /**
     * Обновление кэша
     */
    public function updateCache()
    {
        /** @var Memcached $cache */
        $cache = $this->getServiceLocator()->get('CacheAdapter');
        $courses = $this->_repository->findAll();
        if(!empty($courses)) {
            $currencies = array();
            /** @var Courses $item */
            foreach ($courses as $item) {
                $currencies[$item->getCharCode()] = $item;
            }
            $cache->setItem('currencies', null);
            $cache->setItem('currencies', $currencies);
        }
    }

    /**
     * Информации о курсе валюты
     * @param $post
     * @return array
     */
    public function course($post)
    {
        $cost = array_key_exists('cost', $post) ? floatval(str_replace(',', '.', $post['cost'])) : '';
        $currencyConvert = array_key_exists('currency', $post) ? addslashes($post['currency']) : '';

        if(empty($cost) || empty($currencyConvert)) return [];

        /** @var Memcached $cache */
        $cache = $this->getServiceLocator()->get('CacheAdapter');
        $currencies = $cache->getItem('currencies');
        $currency = $currencies && array_key_exists($currencyConvert, $currencies) ?
            $currencies[$currencyConvert] : null;
        $currencyUSD = $currencies && array_key_exists($this->_currencyConvert, $currencies) ?
            $currencies[$this->_currencyConvert] : null;

        if(!$currency || !$currencyUSD) { // Если значения есть в кэше
            /** @var DocumentManager $dm */
            $dm = $this->getServiceLocator()->get('doctrine-document');
            /** @var Repository $repository */
            $repository = $dm->getRepository($this->_document);

            $currency = $repository->findOneBy(['charCode' => $currencyConvert]);
            $currencyUSD = $repository->findOneBy(['charCode' => $this->_currencyConvert]);
        }

        if($currency instanceof Courses && $currency->getNominal() > 0 &&
            $currencyUSD instanceof Courses && $currencyUSD->getNominal() > 0 && $currencyUSD->getValue() > 0) {

            $rubUSD = $currencyUSD->getValue() / $currencyUSD->getNominal();
            $rub = $currency->getValue() / $currency->getNominal();

            $cost = $rub / $rubUSD * $cost;

        } else return [];

        return [
            'cost' => $cost,
            'currency' => $currencyConvert
        ];
    }
}