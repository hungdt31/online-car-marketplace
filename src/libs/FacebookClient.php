<?php
class FacebookClient
{
    private $fb;
    private $helper;
    public function __construct()
    {
        $this->fb = new Facebook\Facebook([
            'app_id' => getenv("FACEBOOK_APP_ID"), // Replace {app-id} with your app id
            'app_secret' => getenv("FACEBOOK_APP_SECRET"),
            'default_graph_version' => 'v18.0',
        ]);
        $this->helper = $this->fb->getRedirectLoginHelper();
    }
    public function getLoginUrl()
    {
        $permissions = ['email', 'public_profile']; // Optional permissions
        return $this->helper->getLoginUrl(_WEB_ROOT . "/auth/facebook-redirect", $permissions);
    }
    public function getHelper()
    {
        return $this->helper;
    }
    public function getOAuth2Client()
    {
        return $this->fb->getOAuth2Client();
    }
    public function getUserInfo() {
        try {
            $this->fb->setDefaultAccessToken($_SESSION['fb_access_token']);
            $response = $this->fb->get('/me?fields=id,name,first_name,last_name,email,picture');
            return $response->getGraphUser();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
}