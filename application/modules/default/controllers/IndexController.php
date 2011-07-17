<?php
/**
 * Default Controller
 *
 * @author          Eddie Jaoude
 * @package       Default Module
 *
 */
class IndexController extends BaseController
{

    /**
     * Initialisation method
     *
     * @author          Eddie Jaoude
     * @param           void
     * @return           void
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * post dispatch method
     *
     * @author          Eddie Jaoude
     * @param           void
     * @return           void
     *
     */
    public function  postDispatch()
    {
        parent::postDispatch();
    }

    /**
     * default method
     *
     * @author          Eddie Jaoude
     * @param           void
     * @return           void
     *
     */
    public function indexAction()
    {

        /** @var $scoresRepo Custom_Repository_ScoreRepository */
        $scoresRepo = $this->_em->getRepository('Custom_Entity_Score');
        //new Custom_Repository_ScoreRepository($this->_em, 'Custom_Entity_Score');
        $scores = $scoresRepo->getNewestScores(50);

        $scoresForView = array();

        /** @var $score Custom_Entity_Score */
        foreach($scores as $score) {
            $scoresForView[$score->getId()] = array(
                'id' => $score->getId(),
                'score' => $score->getScore(),
                'created_at' => $score->getCreatedAt(),
                'changed_at' => $score->getChangedAt(),
                'created_by' => $score->getCreatedBy()->getId()
            );
        }

        $this->view->tableContent = $scoresForView;
    }

}

