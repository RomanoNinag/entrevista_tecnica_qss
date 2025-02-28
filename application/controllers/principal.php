<?php


class TestController extends CI_Controller {

    public function index() {
        $this->load->model('Usuario'); // Asegúrate de que este modelo existe
        $usuarios = $this->Usuario->get_usuarios(); // Reemplaza esto con tu método real

        echo '<pre>';
        print_r($usuarios);
        echo '</pre>';
    }
}
