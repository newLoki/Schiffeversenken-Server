<?php
/**
 * Account Repository
 *
 *
 * @author          Eddie Jaoude
 * @package       Auth Module
 *
 */

use Doctrine\ORM\EntityRepository;
class Custom_Repository_AccountRepository extends EntityRepository
{
    /**
     * Authenticate user
     *
     * @author          Eddie Jaoude
     * @param           void
     * @return           void
     *
     */
    public function authenticate($hash, $data)
    {
        # filter data
        if (empty($hash)) {
            throw new Exception('Hash required to Authenticate');
        }
        if (empty($data['nickname']) || empty($data['password'])) {
            throw new Exception('Email oder Nickname & Password required. You only supplied ' . $data);
        }

        # get data
        $result = $this->findOneBy(array(
                            'nickname' => (string) $data['nickname'],
                            'password' => (string) hash('SHA256', $hash . $data['password']) 
                         ));

        return $result;
    }

    
    /**
     * One place to generate a new password
     * The length of the password is pass from the configuration of the module.
     * 
     * @author Koen Huybrechts
     * @param int $length The length of the new password
     * @return string $password
     */
    
    public function generatePassword($length)
    {
    	return substr(md5(rand().rand()), 0, $length);
    }

}