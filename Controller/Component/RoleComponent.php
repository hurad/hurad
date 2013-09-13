<?php

App::uses('Component', 'Controller');

/**
 * Class RoleComponent
 */
class RoleComponent extends Component
{

    public function checkAuthorization($user)
    {
        $controller = Inflector::camelize(Router::getParam());
        if (is_callable(array($this, 'check' . $controller . 'Authorization'))) {
            return $this->{'check' . $controller . 'Authorization'}($user);
        } else {
            return false;
        }
    }

    private function checkPostsAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
                return $this->allowAuth();
                break;
            case "editor":
                return $this->allowAuth();
                break;
            case "author":
                return $this->denyAuth(array('admin_edit', 'admin_delete', 'admin_filter', 'admin_process'));
                break;
            case "user":
                return $this->allowAuth(array('index', 'view', 'viewById'));
                break;
        }
    }

    private function checkCategoriesAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
            case "editor":
                return $this->allowAuth();
                break;
            case "author":
            case "user":
                return $this->allowAuth(array('index'));
                break;
        }
    }

    private function checkTagsAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
            case "editor":
                return $this->allowAuth();
                break;
            case "author":
            case "user":
                return $this->allowAuth(array('index'));
                break;
        }
    }

    private function checkLinksAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
            case "editor":
                return $this->allowAuth();
                break;
            case "author":
            case "user":
                return $this->allowAuth(array('index'));
                break;
        }
    }

    private function checkLinkcatsAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
            case "editor":
                return $this->allowAuth();
                break;
            case "author":
            case "user":
                return $this->denyAuth();
                break;
        }
    }

    private function checkPagesAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
            case "editor":
                return $this->allowAuth();
                break;
            case "author":
            case "user":
                return $this->allowAuth(array('index', 'view'));
                break;
        }
    }

    private function checkCommentsAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
            case "editor":
                return $this->allowAuth();
                break;
            case "author":
            case "user":
                return $this->allowAuth(array('index', 'add', 'reply'));
                break;
        }
    }

    private function checkThemesAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
                return $this->allowAuth();
                break;
            case "editor":
            case "author":
            case "user":
                return $this->denyAuth();
                break;
        }
    }

    private function checkWidgetsAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
                return $this->allowAuth();
                break;
            case "editor":
            case "author":
            case "user":
                return $this->denyAuth();
                break;
        }
    }

    private function checkMenusAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
                return $this->allowAuth();
                break;
            case "editor":
            case "author":
            case "user":
                return $this->denyAuth();
                break;
        }
    }

    private function checkPluginsAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
                return $this->allowAuth();
                break;
            case "editor":
            case "author":
            case "user":
                return $this->denyAuth();
                break;
        }
    }

    private function checkUsersAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
                return $this->allowAuth();
                break;
            case "editor":
            case "author":
            case "user":
                return $this->denyAuth(array('admin_delete', 'admin_add', 'admin_index'));
                break;
        }
    }

    private function checkOptionsAuthorization($user)
    {
        switch ($user['role']) {
            case "administrator":
                return $this->allowAuth();
                break;
            case "editor":
            case "author":
            case "user":
                return $this->denyAuth();
                break;
        }
    }

    /**
     * @param null|array|string $methods
     *
     * @return bool
     */
    private function denyAuth($methods = null)
    {
        if (is_null($methods)) {
            return false;
        }

        $methods = array($methods);

        if (is_array($methods)) {
            if (in_array(Router::getParam("action"), $methods)) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * @param null|array|string $methods
     *
     * @return bool
     */
    private function allowAuth($methods = null)
    {
        if (is_null($methods)) {
            return true;
        }

        $methods = array($methods);

        if (is_array($methods)) {
            if (in_array(Router::getParam("action"), $methods)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}