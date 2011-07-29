<?php
/**
 * 
 * @author newloki
 */
use Doctrine\ORM\EntityRepository;
class Custom_Repository_ScoreRepository extends EntityRepository
{
    /**
     * Get the best reached scores, limited by given limit
     *
     * @param int $_limit
     * @return \Doctrine\Common\Collections\ArrayCollection|null
     */
    public function getBestScores($_limit = 1)
    {
        $dql = 'SELECT s
                FROM Custom_Entity_Score s
                ORDER BY s.score DESC';

        $em = $this->getEntityManager();
        $query = $em->createQuery($dql);
        $query->setMaxResults((int) $_limit);

        /** @var $result Custom_Entity_Score */
        $result = $query->getResult();

        return $result;
    }

    /**
     * Get the newest scores, limited by $_limit param
     *
     * @return \Doctrine\Common\Collections\ArrayCollection|null
     */
    public function getNewestScores($_limit = 10)
    {
        $dql = $dql = 'SELECT s
                FROM Custom_Entity_Score s
                ORDER BY s.created_at DESC';

        $em = $this->getEntityManager();
        $query = $em->createQuery($dql);
        $query->setMaxResults((int) $_limit);

        /** @var $result Custom_Entity_Score */
        $results = $query->getResult();

        return $results;
    }

    /**
     * Get all scores generated or changed at given date, limited by limit param
     *
     * @param datetime $_date
     * @param int $_limit
     * @return \Doctrine\Common\Collections\ArrayCollection|null
     */
    public function getScoresByDate(datetime $_date, $_limit = 100)
    {
        $dql = 'SELECT s
                FROM Custom_Entity_Score s
                WHERE (
                  (
                    year(s.created_at) = ?1 AND
                    month(s.created_at) = ?2 AND
                    day(s.created_at) = ?3
                  ) OR
                  (
                    year(s.changed_at) = ?1 AND
                    month(s.changed_at) = ?2 AND
                    day(s.changed_at) = ?3
                  )
                )';

        $em = $this->getEntityManager();
        /** @var $query \Doctrine\ORM\Query */
        $query = $em->createQuery($dql);
        $query->setParameters(
            array(
                1 => $_date->format('Y'), //year
                2 => $_date->format('m'), //month
                3 => $_date->format('d') //day
        ));
        $query->setMaxResults((int) $_limit);

        /** @var $result Custom_Entity_Score */
        $results = $query->getResult();

        return $results;
    }
}
