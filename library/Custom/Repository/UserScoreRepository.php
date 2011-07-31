<?php
/**
 * 
 * @author newloki
 */
use Doctrine\ORM\EntityRepository;

class Custom_Repository_UserScoreRepository extends EntityRepository
{
    /**
     * Get the newest scores for given user, limited by given limit
     * (default is 10)
     *
     * @param Custom_Entity_Account $_user
     * @param int $_limit
     * @return \Doctrine\Common\Collections\ArrayCollection|null
     */
    public function getNewestScores(Custom_Entity_Account $_user, $_limit = 10)
    {
        $dql = 'SELECT s
                FROM Custom_Entity_UserScore s
                WHERE s.user = ?1
                ORDER BY s.created_at DESC';

        $em = $this->getEntityManager();
        /* @var $query \Doctrine\ORM\Query */
        $query = $em->createQuery($dql);
        $query->setParameter(1, $_user);
        $query->setMaxResults((int) $_limit);

        /** @var $result Custom_Entity_UserScore */
        $results = $query->getResult();

        return $results;
    }

    /**
     * Get the best scores for given user, limited by given limit (default is 10)
     * @todo bring it to work
     *
     * @param Custom_Entity_Account $_user
     * @param int $_limit
     * @return \Doctrine\Common\Collections\ArrayCollection|null
     */
    public function getBestScores(Custom_Entity_Account $_user, $_limit = 10)
    {
        $dql = 'SELECT s
                FROM Custom_Entity_UserScore s
                WHERE s.user = ?1
                ORDER BY s.score DESC';

        $em = $this->getEntityManager();
        /* @var $query \Doctrine\ORM\Query */
        $query = $em->createQuery($dql);
        $query->setParameter(1, $_user);
        $query->setMaxResults((int) $_limit);

        /** @var $result Custom_Entity_UserScore */
        $results = $query->getResult();

        return $results;
    }
}
