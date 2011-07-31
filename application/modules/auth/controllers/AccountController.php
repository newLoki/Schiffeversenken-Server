<?php
/**
 * Auth Login Controller
 *
 *
 * @author          Eddie Jaoude
 * @package       Auth Module
 *
 */
class Auth_AccountController extends Auth_BaseController
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
     * initiates before any action is dispatched
     *
     * @param	void
     * @return	void
     */
    public function preDispatch() {
        # if the user is not logged in, they can not access secure pages
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            # redirect login page
            $this->_helper->redirector('denied', 'index', 'auth');
        }
    }

    /**
     * post dispatch method
     *
     * @author          Eddie Jaoude
     * @param           void
     * @return           void
     *
     */
    public function  postDispatch() {
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
    public function indexAction() {
        
    }

    public function profileAction()
    {
        $accountId = $this->getRequest()->getParam('id', null);

        //@todo if no id where given, use id of logged in user.
        // if there is no one logged in, throw a new exception,
        // but this needs a implemented session handling
        if(null != $accountId) {
            //get user
            $accountRepo = $this->_em->getRepository('Custom_Entity_Account');

            /** @var $account Custom_Entity_Account*/
            $account = $accountRepo->findOneById($accountId);
            $accountModel = new Custom_Models_Account_Account($account,
                                                            $this->_em);
            $this->view->account = $accountModel->getAccountInformation();

            //put user scores into view var
            $this->view->scores = $accountModel->getAllUserScores();

        } else {
            throw new Zend_Exception('No id where given');
        }
    }

    /**
     * history method
     *
     * @author          Eddie Jaoude
     * @param           void
     * @return           void
     *
     */
    public function eventAction() {
        # get account events
        $events = $this->_em->getRepository('Custom_Entity_AccountEvent')->findBy(array('account_id' => Zend_Auth::getInstance()->getIdentity()->getId()));

        # send to view
        $this->view->events = $events;
    }
}