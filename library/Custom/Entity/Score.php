<?php
/**
 * 
 * @author newloki
 * @Table(name="scores")
 * @Entity(repositoryClass="Custom_Repository_ScoreRepository")
 */
class Custom_Entity_Score
{
    /**
     * Score id
     *
     * @var integer $id
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * Associated account for this score (this is the first one who reach this
     * score)
     *
     * @ManyToOne(targetEntity="Custom_Entity_Account", fetch="LAZY", inversedBy="scores")
     * @JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     *
     * @var Custom_Entity_Account $created_by
     */
    private $created_by;

    /**
     * Points
     *
     * @Column(type="integer", name="score", nullable="false")
     * @var int
     */
    private $score;

    /**
     * First time when this score was reached
     *
     * @Column(type="datetime", name="created_at", nullable="true")
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * Last time this score was reached
     *
     * @Column(type="datetime", name="changed_at", nullable="true")
     * @var datetime $changed_at
     */
    private $changed_at;

    /**
     * @param \datetime $changed_at
     */
    public function setChangedAt($changed_at)
    {
        $this->changed_at = $changed_at;
    }

    /**
     * @return \datetime
     */
    public function getChangedAt()
    {
        return $this->changed_at;
    }

    /**
     * @param \datetime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \Custom_Entity_Account $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * @return \Custom_Entity_Account
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }
}
