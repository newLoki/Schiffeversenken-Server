<?php
/**
 * 
 * @author newloki
 */
 
class Custom_Models_Account_Account
{
    const USER_SCORE_NEWEST = 'newest';
    const USER_SCORE_BEST   = 'best';

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
            /*
             * @todo code below doesn't work, because error in user score repository
             * self::USER_SCORE_BEST   => $this->getBestUserScores($_limit)
             */
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
                'id' => $this->_account->getId(),
                'name' => $this->_account->getName(),
                'created_at' => $this->_account->getCreated_at()
                                        ->format('d.m.Y H:M:s'),
            );

        return $account;
    }
}
