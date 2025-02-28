    <?php defined('BASEPATH') OR exit('No direct script access allowed');

class DatosController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session'); // Carga la biblioteca de sesión
        $this->load->database(); // Carga la configuración de la base de datos
        $this->load->model('ModeloUsuario'); // Modelo para usuarios
        $this->load->model('ModeloCiudadUsuario'); // Modelo para la relación usuario-ciudad
        $this->load->model('ModeloCiudad'); // Modelo para ciudades
    }

    public function index() {
        $data['listaUsuarios'] = $this->ModeloUsuario->obtenerUsuarios(); 
        $this->load->view('vista_formulario', $data); 
    }

    // Método para procesar la carga de un archivo CSV
    public function cargarArchivo() {
        if (isset($_FILES['archivo_csv']) && $_FILES['archivo_csv']['error'] == 0) {
            // Extraer extensión del archivo cargado
            $infoArchivo = pathinfo($_FILES['archivo_csv']['name']);
            $extensionArchivo = strtolower($infoArchivo['extension']);

            // Validar que el archivo sea formato CSV
            if ($extensionArchivo !== 'csv') {
                $this->load->view('error_no_csv'); 
                return;
            }
            
            // Leer el contenido del archivo
            $rutaArchivo = $_FILES['archivo_csv']['tmp_name']; 
            $archivoAbierto = fopen($rutaArchivo, 'r'); 
            if ($archivoAbierto) {
                // Verificar si el archivo está vacío
                if (filesize($rutaArchivo) === 0) {
                    fclose($archivoAbierto);
                    $this->load->view('error_archivo_vacio'); 
                    return;
                }
                
                echo 'Archivo CSV procesado correctamente';
                $listaCiudades = [];
                while (($fila = fgetcsv($archivoAbierto, 500, "\t")) !== false) {
                    if (!empty($fila[0]) && !empty($fila[2])) {
                        $listaCiudades[] = [
                            'nombreCiudad' => $fila[2], 
                            'idCiudad' => $fila[0]  
                        ];
                    }
                } 

                fclose($archivoAbierto); 
                
                // Si se encontraron ciudades en el CSV, pasarlas a la vista
                if ($listaCiudades) {
                    $data['ciudades'] = $listaCiudades; 
                    $data['listaUsuarios'] = $this->ModeloUsuario->obtenerUsuarios(); 
                    $this->load->view('vista_formulario', $data); 
                } else {
                    echo 'No hay ciudades disponibles en el archivo.'; 
                }
            } else {
                echo 'Error al intentar abrir el archivo.'; 
            }
        } else {
            echo 'Archivo no válido, asegúrese de cargar un CSV válido.'; 
        }
    }

    // Método para guardar la información procesada
    public function guardarDatos() {

        // Capturar los datos enviados desde el formulario
        $usuarioId = $this->input->post('usuarioId'); 
        $ciudadId = $this->input->post('ciudadId'); 
        $nombreCiudad = $this->input->post('nombreCiudad');

        // Guardar la ciudad en la base de datos
        if ($this->ModeloCiudad->Guardar_Ciudad($nombreCiudad, $ciudadId)) {
            // Si la ciudad fue guardada, registrar la relación usuario-ciudad
            if ($this->ModeloCiudadUsuario->Guardar_Ciudad_Usuario($usuarioId, $ciudadId)) {
                $this->load->view('succes'); 
            } else {
                echo 'Ocurrió un error al registrar la ciudad.'; 
            }
        } else {
            echo 'Error al guardar los datos en la base de datos.'; 
        }
    }

    // Método para mostrar la relación usuario-ciudad
    public function listarCiudadesUsuarios() {
        // Obtener datos de la relación usuario-ciudad
        $data['ciudadUsuarios'] = $this->ModeloCiudadUsuario->obtenerCiudadUsuario();
        $this->load->view('vista_formulario', $data); 
    }
}
