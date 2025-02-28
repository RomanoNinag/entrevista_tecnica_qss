<?php
//Verificacion para no acceder desde URL para mas seguridad
defined('BASEPATH') OR exit('No se permite el acceso directo al script');
//creamos clase ciudad
class ModeloCiudadUsuario extends CI_Model {
    
    public function Guardar_Ciudad_Usuario($IdUsuario, $IdCiudad) {
        $datos = [
            'IdUsuario' => $IdUsuario,
            'IdCiudad' => $IdCiudad
        ];
        return $this->db->insert('ciudades_usuarios', $datos);   //para insertar en usuario ciudad
    } 
    //Para mostrar las actualizaciones 
    public function obtenerCiudadUsuario() {
        $this->db->select('u.IdUsuario AS IdUsuario, u.nombre AS NombreUsuario, uc.IdCiudad, c.Ciudad AS NombreCiudad');
        $this->db->from('ciudades_usuarios uc');
        $this->db->join('Usuarios u', 'uc.IdUsuario = u.IdUsuario');
        $this->db->join('Ciudades c', 'uc.IdCiudad = c.IdCiudad');
        //INNER JOIN RESULTADO
        $query = $this->db->get();
        return $query->result_array(); 
    }

}