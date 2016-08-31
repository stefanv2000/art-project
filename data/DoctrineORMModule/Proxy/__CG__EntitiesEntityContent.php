<?php

namespace DoctrineORMModule\Proxy\__CG__\Entities\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Content extends \Entities\Entity\Content implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'type', 'status', 'mimetype', 'caption', 'customfield1', 'customfield2', 'description', 'hashcode', 'extension', 'name', 'originalname', 'path', 'width', 'height', 'cover', 'section', 'sortorder', '' . "\0" . 'Entities\\Entity\\Content' . "\0" . 'created', '' . "\0" . 'Entities\\Entity\\Content' . "\0" . 'updated');
        }

        return array('__isInitialized__', 'id', 'type', 'status', 'mimetype', 'caption', 'customfield1', 'customfield2', 'description', 'hashcode', 'extension', 'name', 'originalname', 'path', 'width', 'height', 'cover', 'section', 'sortorder', '' . "\0" . 'Entities\\Entity\\Content' . "\0" . 'created', '' . "\0" . 'Entities\\Entity\\Content' . "\0" . 'updated');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Content $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function updated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'updated', array());

        return parent::updated();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getType', array());

        return parent::getType();
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function getMimetype()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMimetype', array());

        return parent::getMimetype();
    }

    /**
     * {@inheritDoc}
     */
    public function getCaption()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCaption', array());

        return parent::getCaption();
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', array());

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function getHashcode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHashcode', array());

        return parent::getHashcode();
    }

    /**
     * {@inheritDoc}
     */
    public function getExtension()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExtension', array());

        return parent::getExtension();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function getOriginalname()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOriginalname', array());

        return parent::getOriginalname();
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPath', array());

        return parent::getPath();
    }

    /**
     * {@inheritDoc}
     */
    public function getWidth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWidth', array());

        return parent::getWidth();
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHeight', array());

        return parent::getHeight();
    }

    /**
     * {@inheritDoc}
     */
    public function getCover()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCover', array());

        return parent::getCover();
    }

    /**
     * {@inheritDoc}
     */
    public function getSection()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSection', array());

        return parent::getSection();
    }

    /**
     * {@inheritDoc}
     */
    public function getSortorder()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSortorder', array());

        return parent::getSortorder();
    }

    /**
     * {@inheritDoc}
     */
    public function getCreated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreated', array());

        return parent::getCreated();
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdated', array());

        return parent::getUpdated();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', array($id));

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function setType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setType', array($type));

        return parent::setType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function setMimetype($mimetype)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMimetype', array($mimetype));

        return parent::setMimetype($mimetype);
    }

    /**
     * {@inheritDoc}
     */
    public function setCaption($caption)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCaption', array($caption));

        return parent::setCaption($caption);
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', array($description));

        return parent::setDescription($description);
    }

    /**
     * {@inheritDoc}
     */
    public function setHashcode($hashcode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHashcode', array($hashcode));

        return parent::setHashcode($hashcode);
    }

    /**
     * {@inheritDoc}
     */
    public function setExtension($extension)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExtension', array($extension));

        return parent::setExtension($extension);
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function setOriginalname($originalname)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOriginalname', array($originalname));

        return parent::setOriginalname($originalname);
    }

    /**
     * {@inheritDoc}
     */
    public function setPath($path)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPath', array($path));

        return parent::setPath($path);
    }

    /**
     * {@inheritDoc}
     */
    public function setWidth($width)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWidth', array($width));

        return parent::setWidth($width);
    }

    /**
     * {@inheritDoc}
     */
    public function setHeight($height)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHeight', array($height));

        return parent::setHeight($height);
    }

    /**
     * {@inheritDoc}
     */
    public function setCover($cover)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCover', array($cover));

        return parent::setCover($cover);
    }

    /**
     * {@inheritDoc}
     */
    public function setSection($section)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSection', array($section));

        return parent::setSection($section);
    }

    /**
     * {@inheritDoc}
     */
    public function setSortorder($sortorder)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSortorder', array($sortorder));

        return parent::setSortorder($sortorder);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreated($created)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreated', array($created));

        return parent::setCreated($created);
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdated($updated)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdated', array($updated));

        return parent::setUpdated($updated);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomfield1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCustomfield1', array());

        return parent::getCustomfield1();
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomfield1($customfield1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCustomfield1', array($customfield1));

        return parent::setCustomfield1($customfield1);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomfield2()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCustomfield2', array());

        return parent::getCustomfield2();
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomfield2($customfield2)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCustomfield2', array($customfield2));

        return parent::setCustomfield2($customfield2);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', array());

        return parent::toArray();
    }

}
