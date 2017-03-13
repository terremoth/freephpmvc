<?php

/**
 * UserLogin - Realizes Login/Logout, verifies permissions and redirects to user logged area
 */
class UserLogin {

    /**
     * Verifies if user is logged
     * @access public
     */
    var $isLogged;

    /**
     * User DataInformation
     * @access public
     * @var array
     */
    var $userData;

    /**
     * Error Message for form
     * @access public
     * @var string
     */
    var $loginError;

    /**
     * Verifies and configures user log inout and configures $userData informations
     */
    function checkUserLogin() {

        // Verifies if a session exists in the userData
        // Must be an array ant cannot be the $_POST itself
        if (      isset($_SESSION['userData']) 
            &&   !empty($_SESSION['userData']) 
            && is_array($_SESSION['userData'])) {
            
            // Configures user data from session
            $aUserData = $_SESSION['userData'];

            // must not be http post
            $aUserData['post'] = false;
        }

        // Verifies if a POST exists in the userData
        // Must be an array
        if (isset($_POST['userData']) && !empty($_POST['userData']) && is_array($_POST['userData'])
        ) {
            // Instances user data POST
            $aUserData = $_POST['userData'];

            // Guarantee POST
            $aUserData['post'] = true;
        }

        // Verifies if there is no userData anymore to log out
        if (!isset($aUserData) || !is_array($aUserData)) {

            // Removes any user session 
            $this->logout();

            return true;
        }

        // Instances POST in a new var
        if ($aUserData['post'] === true) {
            $aPost = true;
        } else {
            $aPost = false;
        }

        // Removes POST from userData
        unset($aUserData['post']);

        // Logging Out
        if (empty($aUserData)) {
            $this->isLogged = false;
            $this->loginError = null;
            $this->logout();

            return true;
        }

        // Extrai from user data
        extract($aUserData);

        // VErifies if exists user and password
        if (!isset($user) || !isset($userPassword)) {
            $this->isLogged = false;
            $this->loginError = null;

            // Remove qualquer sessão que possa existir sobre o usuário
            $this->logout();

            return false;
        }

        // Verifies if user exists in database
        $sQuery = $this->db->query('SELECT * FROM users WHERE user = ? LIMIT 1', array($user));

        // Verifies query
        if (!$sQuery) {
            $this->isLogged = false;
            $this->loginError = 'Internal database query error.';

            // Logs out the application
            $this->logout();

            return false;
        }

        // Get user data from database
        $aFetch = $sQuery->fetch(PDO::FETCH_ASSOC);

        // Get user ID
        $iUserId = (int) $aFetch['user_id'];

        // Verifies if Id exists
        if (empty($iUserId)) {
            $this->isLogged = false;
            $this->loginError = 'User does not exists.';

            // Logs out, because there is no user
            $this->logout();

            return false;
        }

        // Checks if password is equal database hash
        if ($this->phpass->CheckPassword($userPassword, $aFetch['userPassword'])) {

            // verifies if the session id is equal user's session
            if (session_id() != $aFetch['userSessionId'] && !$aPost) {
                $this->isLogged = false;
                $this->loginError = 'Wrong session ID.';

                // Remove qualquer sessão que possa existir sobre o usuário
                $this->logout();

                return;
            }

            // If there is a post
            if ($aPost) {
                
                // Rebuild session id
                session_regenerate_id();
                $session_id = session_id();

                // Send User data to the session
                $_SESSION['userData'] = $aFetch;

                // Updates password
                $_SESSION['userData']['userPassword'] = $userPassword;

                // Updates session id
                $_SESSION['userData']['userSessionId'] = $session_id;

                // Updates session id in database
                $sQuery = $this->db->query('UPDATE users SET userSessionId = ? WHERE user_id = ?', array($session_id, $iUserId));
            }

            // Get array with permissions
            $_SESSION['userData']['userPermissions'] = unserialize($aFetch['userPermissions']);

            // Configures property saying that the user is logged in
            $this->isLogged = true;

            // Set user data from session
            $this->userData = $_SESSION['userData'];

            // Verifies if exists a URL to redirects
            if (isset($_SESSION['goToURL'])) {
                // Instance that URL
                $sGoToURL = urldecode($_SESSION['goToURL']);

                // Removes URL from session
                unset($_SESSION['goToURL']);

                // Redireciona para a página
                //echo '<meta http-equiv="Refresh" content="0; url=' . $sGoToURL . '">';
                //echo '<script type="text/javascript">window.location.href = "' . $sGoToURL . '";</script>';
                header('Location: ' . $goToURL );
            }

            return true;
            
        } else {
            
            // User not logged
            $this->isLogged = false;
            // Password is not matching:
            $this->loginError = 'Password does not match.';
            $this->logout();
            return false;
        }
    }

    /**
     * Logout
     * @param bool $redirect if true, redirects user to login page
     * @final
     */
    protected function logout($redirect = false) {
        // Remove all data from $_SESSION['userData']
        $_SESSION['userData'] = array();

        // Only to make sure (it isn't really needed)
        unset($_SESSION['userData']);

        // Regenerates the session ID
        session_regenerate_id();

        if ($redirect === true) {
            // Send the user to the login page
            $this->goToLogin();
        }
    }

    /**
     * Go to login page
     */
    protected function goToLogin() {
        // Verifies if HOME URL is configured
        if (defined('HOME_URI')) {
            // Login URL
            $loginUri = HOME_URI . '/login/';

            // Get last user page
            $_SESSION['goToURL'] = urlencode($_SERVER['REQUEST_URI']);

            // Redirects
            //echo '<meta http-equiv="Refresh" content="0; url=' . $loginUri . '">';
            //echo '<script type="text/javascript">window.location.href = "' . $loginUri . '";</script>';
            header('Location: ' . $loginUri);
            return true;
        } else {
            return false;
        }

    }

    /**
     * Sends user to some page
     * @final
     */
    final protected function goToPage($pageUri = null) {
        if (isset($_GET['url']) && !empty($_GET['url']) && !$pageUri) {
            // Get original url string
            $pageUri = urldecode($_GET['url']);
        }

        if ($pageUri) {
            // Redireciona
            //echo '<meta http-equiv="Refresh" content="0; url=' . $pageUri . '">';
            //echo '<script type="text/javascript">window.location.href = "' . $pageUri . '";</script>';
            header('Location: ' . $pageUri);  //maybe this can be a better solution
        }
    }

    /**
     * Check the user permissions
     * @param string $required The required permission
     * @param array $userPermissions The permissions that the user has
     * @final
     */
    final protected function checkPermissions($required = 'any', $userPermissions = array('any')) {
        
        if (!is_array($userPermissions)) {
            return false;
        }

        // if user does not have that permission, returns false
        if (!in_array($required, $userPermissions)) {
            return false;
        } else {
            return true;
        }
    }

}
