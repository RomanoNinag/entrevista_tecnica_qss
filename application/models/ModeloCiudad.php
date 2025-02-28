<?php
// Verificación para no acceder desde URL para más seguridad
defined('BASEPATH') OR exit('No se permite el acceso directo al script');

// Creamos la clase Ciudad
class ModeloCiudad extends CI_Model {
    // Método para obtener la lista de ciudades
    public function get_ciudades() {
        return $this->db->get('ciudades')->result(); // 'ciudad' es el nombre de la tabla en la base de datos
    }

    // Método para guardar la relación ciudad-usuario
    public function Guardar_Ciudad($nombre, $IdCiudad) {
       
        // Verificar si la ciudad ya existe
        $this->db->where('Ciudad', $nombre);
        $query = $this->db->get('ciudades');

        // Si la ciudad no existe, insertarla
        if ($query->num_rows() == 0) {
            $data = array(
                'IdCiudad' => $IdCiudad,
                'Ciudad' => $nombre,
            );
            return $this->db->insert('ciudades', $data); 
        } else {
            // La ciudad ya existe
            return false; 
        }
    }

}
