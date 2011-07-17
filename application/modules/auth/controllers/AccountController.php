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
        if(null != $accountId) {
            //get user
            $accountRepo = $this->_em->getRepository('Custom_Entity_Account');

            /** @var $account Custom_Entity_Account*/
            $account = $accountRepo->findOneById($accountId);
            $this->view->account = array(
                'id' => $account->getId(),
                'name' => $account->getName(),
                'created_at' => $account->getCreated_at()->format('d.m.Y H:M:s'),
            );

            //put user scores into view var

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