<?php

namespace Anax\App;

/**
 * An App class to wrap the resources of the framework.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class App
{
    public function redirect($url)
    {
        $this->response->redirect($this->url->create($url));
        exit;
    }



    /**
     * Render a standard web page using a specific layout.
     */
    public function renderPage($data, $status = 200)
    {

        $this->view->add("incl/header", ["title" => [$data["title"], $data["style"], '../htdocs/img/pumpkin.jpg']]);
        $this->view->add("incl/side-bar1");
        foreach ($data["page"] as $value) {
            $this->view->add($value, ["resultset" => $data["res"]]);
        }
        // $this->view->add($data["page"], ["resultset" => $data["res"]]);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");


        $this->response->setBody([$this->view, "render"])
                        ->send($status);
        exit;
    }

    function get_gravatar($email, $s = 50, $d = 'mp', $r = 'g', $img = false, $atts = array())
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}
