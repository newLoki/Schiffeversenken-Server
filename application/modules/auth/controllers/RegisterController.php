<?php
/**
 * Auth Register Controller
 *
 *
 * @author          Eddie Jaoude
 * @package       Auth Module
 *
 */
class Auth_RegisterController extends Auth_BaseController
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
        # if the user is logged in, they can not register again
        if (Zend_Auth::getInstance()->hasIdentity()) {
            # redirect login page
            $this->_helper->redirector('index', 'index', 'default');
        }
    }

    /**
     * initiates after any action is dispatched
     *
     * @param	void
     * @return	void
     */
    public function postDispatch() {
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
        # load form
        $form = new Auth_Form_Register;
        
        # attempt to save
        $save = $this->save($form);

        # send to view
        $this->view->registerForm = $save['form'];
        $this->view->alert = $save['alert'];
    }
    
     /**
     * successful method
     *
     * @author          Eddie Jaoude
     * @param           void
     * @return           void
     *
     */
    public function successfulAction() {
        # load form
        $form = new Auth_Form_Login;

        # send to view
        $this->view->loginForm = $form;
    }
    
    /**
     * save method
     *
     * @param	void
     * @return	void
     */
    private function save($form) {
        $message = null;
         if ($this->_request->isPost()) {
            # get params
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                # check for existing email
                $accountExist = $this->_em->getRepository('Custom_Entity_Account')->findBy(array('email' => (string) $data['email']));
                if (count($accountExist) == 0) {
                    # register account
                    $account = new Custom_Entity_Account;
                    $account->setNickname($data['nickname']);
                    $account->setFirstname($data['firstname']);
                    $account->setLastname($data['lastname']);
                    $account->setEmail($data['email']);
                    $account->setPassword($data['password'], $this->_registry->config->auth->hash);
                    $account->setCreated_at(new DateTime());
                    $this->_em->persist($account);
                    $this->_em->flush();

                    # send to login page
                    $this->_helper->redirector('successful', 'register', 'auth');
                } else {
                    $alert = 'Registration Failed: Email already exists'; // move to view
                }
            }
            # populate form
            $form->populate($data);
        }
        return array('form' => $form, 'alert' => empty($alert) ? null : $alert );
    }
    


}

