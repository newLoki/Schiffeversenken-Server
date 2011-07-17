<?php
/**
 * 
 * @author newloki
 */
 
class LibraryCustomEntityAccountTest extends BaseTestCase
{
    /**
     * @var Custom_Entity_Account
     */
    protected $object = null;

    public function setUp()
    {
        require_once('Custom/Entity/Account.php');

        $this->object = new Custom_Entity_Account();
    }

    public function testPasswordHash()
    {
        $registry = Zend_Registry::getInstance();
        $hash = $registry->config->auth->hash;
        $password = 'foobar';
        $expectedHash = hash('SHA256', $hash . $password);

        $this->object->setPassword($password, $hash);

        $this->assertEquals($expectedHash, $this->object->getPassword());

    }
}
