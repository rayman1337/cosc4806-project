<?php
class Home extends Controller {
    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $isLoggedIn = isset($_SESSION['auth']) && $_SESSION['auth'] === 1;
        $this->view('home/index', ['isLoggedIn' => $isLoggedIn]);
    }
}