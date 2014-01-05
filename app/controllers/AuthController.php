<?php

namespace Controllers;

class AuthController extends \Base\Controller
{
    public function beforeExecuteRoute()
    {
        $this->checkLoggedIn = FALSE;

        parent::beforeExecuteRoute();
    }

    /**
     * Accepts an email and password, attempts to log user in
     * and create a session. Returns a session ID.
     */
    public function loginAction()
    {
        $email = $this->request->getPost( 'email' );
        $password = $this->request->getPost( 'password' );

        // try to log in with credentials
        //
        $this->redirect = 'dashboard';
        $loggedIn = \Actions\Users\Auth::login(
            array(
                'email' => $email,
                'password' => $password
            ));

        if ( ! $loggedIn )
        {
            $this->redirect = 'login';
        }
    }

    /**
     * Kill the session and login cookie
     */
    public function logoutAction()
    {
        \Actions\Users\Auth::destroyToken();

        $this->redirect = 'login';
        $this->addMessage( "You've been logged out" ); 
    }
}