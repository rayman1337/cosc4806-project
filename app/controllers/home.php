<?php

class Home extends Controller {

    public function index() {
        $isLoggedIn = isset($_SESSION['auth']) && $_SESSION['auth'] === 1;

        $this->view('home/index', ['isLoggedIn' => $isLoggedIn]);
    }
}
