<?php
//Verificacion para no acceder desde URL para mas seguridad
defined('BASEPATH') OR exit('No se permite el acceso directo al script');
//creamos clase usuario
class ModeloUsuario extends CI_Model {
    //metodo para obetener lista de usuarios
    public function obtenerUsuarios() {
        return $this->db->get('usuarios')->result(); //usuario nombre de tabla
    }
}