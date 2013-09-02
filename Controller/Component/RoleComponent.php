<?php

App::uses('Component', 'Controller');

/**
 * Description of RoleComponent
 *
 * @todo Complete phpDoc
 * @author mohammad
 */
class RoleComponent extends Component
{

    public function checkAuthorization($user)
    {
        switch (Router::getParam()) {
            case "posts":
                return $this->checkPostsAuthorization($user);
                break;
            case "categories":
                return $this->checkCategoriesAuthorization($user);
                break;
            case "tags":
                return $this->checkTagsAuthorization($user);
                break;
            case "links":
                return $this->checkLinksAuthorization($user);
                break;
            case "linkcats":
                return $this->checkLinkcatsAuthorization($user);
                break;
            case "pages":
                return $this->checkPagesAuthorization($user);
                break;
            case "comments":
                return $this->checkCommentsAuthorization($user);
                break;
            case "themes":
                return $this->checkThemesAuthorization($user);
                break;
            case "widgets":
                return $this->checkWidgetsAuthorization($user);
                break;
            case "menus":
                return $this->checkMenusAuthorization($user);
                break;
            case "plugins":
                return $this->checkPluginsAuthorization($user);
                break;
            case "users":
                return $this->checkUsersAuthorization($user);
                break;
            case "options":
                return $this->checkOptionsAuthorization($user);
                break;
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

    private function denyAuth($methods = null)
    {
        if (is_null($methods)) {
            return false;
        } elseif (is_array($methods)) {
            if (in_array(Router::getParam("action"), $methods)) {
                return false;
            } else {
                return true;
            }
        }
    }

    private function allowAuth($methods = null)
    {
        if (is_null($methods)) {
            return true;
        } elseif (is_array($methods)) {
            if (in_array(Router::getParam("action"), $methods)) {
                return true;
            } else {
                return false;
            }
        }
    }

}