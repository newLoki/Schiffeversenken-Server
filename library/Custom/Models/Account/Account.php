<?php
/**
 * 
 * @author newloki
 */
 
class Custom_Models_Account_Account
{
    const USER_SCORE_NEWEST = 'newest';
    const USER_SCORE_BEST   = 'best';
    const USER_IMAGE_SIZE_X = '150'; //@todo use smaller images
    const USER_IMAGE_SIZE_Y = '200'; //@todo see comment above
    const USER_IMAGE_TYPE   = 'jpg';
    const USER_IMAGE_DIRECTORY_NAME = 'accounts';
    const USER_DEFAULT_IMAGE = 'default.jpg';

    /**
     * Stores the account
     *
     * @var \Custom_Entity_Account $_account
     */
    protected $_account;

    /**
     * Stores the entity manager
     *
     * @var \Doctrine\ORM\EntityManager $_em
     */
    protected $_em;

    /**
     * Constructor
     *
     * @param Custom_Entity_Account $_account
     * @param Doctrine\ORM\EntityManager $_em
     * @return void
     */
    public function __construct(Custom_Entity_Account $_account,
                    \Doctrine\ORM\EntityManager $_em)
    {
        $this->_account = $_account;
        $this->_em = $_em;
    }

    /**
     * Get the best scores for given user, limited by given limit
     *
     * @param int $_limit
     * @return array
     */
    public function getBestUserScores($_limit = 10)
    {
        /** @var $scoreRepo \Custom_Repository_UserScoreRepository */
        $scoreRepo = $this->_em->getRepository('Custom_Entity_UserScore');
        $newestScores = $scoreRepo->getBestScores($this->_account, $_limit);

        $scores = array();
        /** @var $newScore \Custom_Entity_UserScore */
        foreach($newestScores as $newScore) {
            $newestScore = array(
                'id' => $newScore->getId(),
                'score' => $newScore->getScore()->getScore(),
                'created_at' => $newScore->getCreatedAt(),
                'changed_at' => $newScore->getChangedAt()
            );
            $scores[] = $newestScore;
         }

        return $scores;
    }

    /**
     * Get the newest scores for given user, limited by given limit
     *
     * @param int $_limit
     * @return array
     */
    public function getNewestUserScores($_limit = 10)
    {
        /** @var $scoreRepo \Custom_Repository_UserScoreRepository */
        $scoreRepo = $this->_em->getRepository('Custom_Entity_UserScore');
        $newestScores = $scoreRepo->getNewestScores($this->_account, $_limit);

        $scores = array();
        /** @var $newScore \Custom_Entity_UserScore */
        foreach($newestScores as $newScore) {
            $newestScore = array(
                'id' => $newScore->getId(),
                'score' => $newScore->getScore()->getScore(),
                'created_at' => $newScore->getCreatedAt(),
                'changed_at' => $newScore->getChangedAt()
            );
            $scores[] = $newestScore;
         }

        return $scores;
    }

    /**
     * Return array which have best and newest user scores inside
     *
     * @param int $_limit
     * @return array
     */
    public function getAllUserScores($_limit = 10)
    {
        $scores = array(
            self::USER_SCORE_NEWEST => $this->getNewestUserScores($_limit),
            self::USER_SCORE_BEST   => $this->getBestUserScores($_limit)
        );

        return $scores;
    }

    /**
     * Formatting account information as array
     * 
     * @return array
     */
    public function getAccountInformation()
    {
        $account = array(
                'id'         => $this->_account->getId(),
                'name'       => $this->_account->getNickname(),
                'created_at' => $this->_account->getCreated_at()
                                        ->format('d.m.Y H:M:s'),
                'image'      => $this->getProfileImage()
            );

        return $account;
    }

    /**
     * Return path to profile image or if not availeable to default image
     *
     * @return string
     */
    protected function getProfileImage()
    {
        $path = $this->_getImageBasePath() . $this->_getImageName();

        if(!file_exists($this->_getFullImagePath($path))) {
            //reszise and return path to new resized image
            //@todo resize
            $originImage = $this->_getImageName(false);
            if(file_exists($this->_getFullImagePath($originImage))) {
                //resize it and return path to resized image
                //if it can't resized, return default image
            } else {
                return $this->_getDefaultImage();
            }
        } else {
            return $path;
        }


    }

    /**
     * Return base path to profile image, including account name by default
     *
     * @param bool $_accountName
     * @return string
     */
    protected function _getImageBasePath($_accountName = true)
    {
        $registry = Zend_Registry::getInstance();
        /** @var $config Zend_Config */
        $config = $registry->get('config');
        $imageBasePath = $config->application->image->basePath;

        $basePath = $imageBasePath
                . DIRECTORY_SEPARATOR
                . self::USER_IMAGE_DIRECTORY_NAME
                . DIRECTORY_SEPARATOR;
        if($_accountName) {
            $basePath .= $this->_account->getNickname() . DIRECTORY_SEPARATOR;
        }

        return $basePath;
    }

    /**
     * Return the real and fully path from given image path
     *
     * @param string $_imagePath
     * @return string
     */
    protected function _getFullImagePath($_imagePath)
    {
       $fullPath = APPLICATION_PATH
                   . DIRECTORY_SEPARATOR
                   . '..'
                   . DIRECTORY_SEPARATOR
                   . 'public'
                   . DIRECTORY_SEPARATOR;

       return realpath($fullPath . $_imagePath);
    }

    /**
     * Return image name, including size string by default
     *
     * @param bool $_withSize
     * @return string
     */
    protected function _getImageName($_withSize = true)
    {
        $name = $this->_account->getImage();
        
        if($_withSize) {
            $name .=  '_' . self::USER_IMAGE_SIZE_X
                      . 'x' . self::USER_IMAGE_SIZE_Y;
        }

        $name .= '.' . self::USER_IMAGE_TYPE;

        return $name;
    }

    /**
     * Return path to default image
     *
     * @return string
     */
    protected function _getDefaultImage()
    {
        $path = $this->_getImageBasePath(false)
                . self::USER_DEFAULT_IMAGE;

        return $path;
    }
}
