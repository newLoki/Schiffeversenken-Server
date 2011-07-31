<?php
/**
 * 
 * @author newloki
 */
 
class Custom_Models_Account_Account
{
    const USER_SCORE_NEWEST = 'newest';
    const USER_SCORE_BEST   = 'best';

    protected $_account;

    /**
     * @var $_em \Doctrine\ORM\EntityManager
     */
    protected $_em;

    public function __construct(Custom_Entity_Account $_account,
                    \Doctrine\ORM\EntityManager $_em)
    {
        $this->_account = $_account;
        $this->_em = $_em;
    }

    public function getBestUSerScores($_limit = 10)
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

     //@todo move to model
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

    public function getAllUserScores($_limit = 10)
    {
        $scores = array(
            self::USER_SCORE_NEWEST => $this->getNewestUserScores($_limit),
            /*
             * @todo code below doesn't work, because error in user score repository
             * self::USER_SCORE_BEST   => $this->getBestUSerScores($_limit)
             */
        );

        return $scores;
    }
}
