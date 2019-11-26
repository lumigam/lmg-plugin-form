<?php
/*
* Plugin Name: lmg-plugin-form
* Author: Luismi G
* Description: Plugin que genera un formulario utilizando el shortcode [lmg_plugin_form]
*/

register_activation_hook( __FILE__, 'lmg_Aspirante_init' );

function lmg_Aspirante_init()
{

    global $wpdb;
    $tabla_aspirante = $wpdb->prefix . 'aspirante';
    $charset_collate = $wpdb->get_charset_collate();

    //Prepara la consulta que vamos a lanzar para crear la $tabla
    $query = "CREATE TABLE IF NOT EXISTS $tabla_aspirante(
      id mediumint (9) NOT NULL AUTO_INCREMENT,
      nombre varchar (40) NOT NULL,
      correo varchar (100) NOT NULL,
      nivel_html smallint (4) NOT NULL,
      nivel_css smallint (4) NOT NULL,
      nivel_js smallint (4) NOT NULL,
      operativo varchar (40) NOT NULL,
      aceptacion smallint (4) NOT NULL,
      created_at datetime NOT NULL,
      UNIQUE (id)
    ) $charset_collate";
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($query);

}



//Definde el shortcode que pinta el formulario
add_shortcode( 'lmg_plugin_form', 'LMG_plugin_form' );

function LMG_plugin_form () {

      // Carga esta hoja de estilo para poner más bonito el formulario
      wp_enqueue_style('css_aspirante', plugins_url('style.css', __FILE__));

      /* Antes de pintar el formulario, vamos a decirle que meta los datos en la BD
      como estamos en una funcion tenemos que traer aquí las mismas variables que están fuera donde hay que grabar los datos */
      global $wpdb;
      //comprobamos si hay datos en el formulario
      if (!empty ($_POST)
          AND $_POST['nombre'] != ''
          AND is_email($_POST['correo'])
          AND $_POST['nivel_html'] != ''
          AND $_POST['nivel_css'] != ''
          AND $_POST['nivel_js'] != ''
          AND $_POST['operativo'] != ''
          AND $_POST['aceptacion'] == "1"
          AND wp_verify_nonce($_POST['aspirante_nonce'], 'graba_aspirante')
        ){
        //Si viene con datos en nombre, los metemos en la tabla, tb creamos variables para sanear lo que viene en el form
        $tabla_aspirante = $wpdb->prefix . 'aspirante';
        $nombre = sanitize_text_field( $_POST['nombre'] );
        $correo = sanitize_text_field( $_POST['correo'] );
        //los de seleccion los saneamos a enteros
        $nivel_html = (int)$_POST['nivel_html'];
        $nivel_css = (int)$_POST['nivel_css'];
        $nivel_js = (int)$_POST['nivel_js'];
        $operativo = sanitize_text_field($_POST['operativo'] );
        $aceptacion = (int)$_POST['aceptacion'];
        //Modificacion el formato de la fecha
        $created_at = date('Y-m-d H:i:s');
        $wpdb->insert(
            $tabla_aspirante,
            array(
                'nombre' => $nombre,
                'correo' => $correo,
                'nivel_html' => $nivel_html,
                'nivel_css' => $nivel_css,
                'nivel_js' => $nivel_js,
                'operativo' => $operativo,
                'aceptacion' => $aceptacion,
                'created_at' => $created_at,
              )
            );
            echo "<p class='exito'><b>Tus datos han sido registrados</b>. Gracias
            por tu interés. En breve contactaré contigo.<p>";
      }

      // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
      // Cuando termine el formulario lo imprime con la función ob_get_clean
      ob_start( );
      ?>

      <form action="<?php get_the_permalink(); ?>" method="post" class="formulario" id="aspirform">
        <!-- La funcion wp_once comprueba que el formulario que se está procesando viene de nuestra web -->
        <?php wp_nonce_field('graba_aspirante', 'aspirante_nonce'); ?>
        <div class="form-input">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" required="required">
        </div></br>

        <div class="form-input">
          <label for="correo">Correo</label>
          <input type="correo" name="correo" id="correo" required>
        </div></br>

        <div class="form-input">
          <label for="nivel_html">¿Cuál es tu Nivel de HTML?</label>
          <input type="radio" name="nivel_html" value="1" required> Nada </br>
          <input type="radio" name="nivel_html" value="2" required> Estoy aprendiendo </br>
          <input type="radio" name="nivel_html" value="3" required> Tengo experiencia </br>
          <input type="radio" name="nivel_html" value="4" required> Lo domino al dedillo </br>
        </div></br>

        <div class="form-input">
          <label for="nivel_css">¿Cuál es tu Nivel de css?</label>
          <input type="radio" name="nivel_css" value="1" required> Nada </br>
          <input type="radio" name="nivel_css" value="2" required> Estoy aprendiendo </br>
          <input type="radio" name="nivel_css" value="3" required> Tengo experiencia </br>
          <input type="radio" name="nivel_css" value="4" required> Lo domino al dedillo </br>
        </div></br>

        <div class="form-input">
          <label for="nivel_js">¿Cuál es tu Nivel de JavasCript?</label>
          <input type="radio" name="nivel_js" value="1" required> Nada </br>
          <input type="radio" name="nivel_js" value="2" required> Estoy aprendiendo </br>
          <input type="radio" name="nivel_js" value="3" required> Tengo experiencia </br>
          <input type="radio" name="nivel_js" value="4" required> Lo domino al dedillo </br>
        </div></br>

        <div class="form-input">
          <label for="operativo">¿Qué sistema operativo usa?</label>
          <select name="operativo">
              <option value="Windows">Windows</option>
              <option value="MacOs">MacOs</option>
              <option value="Linux">Linux</option>
              <option value="Otro">Otro</option>
          </select>
        </div></br>

        <div class="form-input">
          <label for="aceptacion">La información facilitada se trata con respeto y admiración</label>
          <input type="checkbox" name="aceptacion" id="aceptacion" value="1"> Entiendo y acepto las condiciones
        </div></br>

        <div class="form-input">
          <input type="submit" value="Enviar">
        </div>
      </form>

      <?php
      return ob_get_clean();
}

add_action( "admin_menu", "lmg_form_menu" );

//Agrega menú en el Panel de Administración de WP

function lmg_form_menu (){

    add_menu_page( "Formulario de Aspirantes", "Aspirantes", "manage_options", "lmg_form_menu", "lmg_form_admin", "dashicons-feedback", 75 );

}

function lmg_form_admin (){

    global $wpdb;
    $tabla_aspirante = $wpdb->prefix . "aspirante";
    $aspirante = $wpdb->get_results("SELECT * FROM $tabla_aspirante");
    echo '<div class="wrap"> <h1>Lista de la Tabla</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th width = "30%">Nombre</th><th width = "20%">Correo</th>';
    echo '<th>HTML</th><th>CSS</th><th>JavasCript</th><th>Operativo<th/>';
    echo '</tr></thead>';
    echo '<tbody id="the-list"';
    foreach ($aspirante as $aspirante) {
      $nombre = esc_textarea( $aspirante->nombre );
      $correo = esc_textarea( $aspirante->correo );
      $nivel_html = int( $aspirante->nivel_html );
      $nivel_css = int( $aspirante->nivel_css );
      $nivel_js = int( $aspirante->nivel_js );
      $nivel_html = int( $aspirante->nivel_html );
      $operativo = esc_textarea( $aspirante->operativo );
      $total = $nivel_html + $nivel_css + $nivel_js;

      echo "<tr><td><a href='#' title='$operativo'>$nombre</a></td>";
      echo "<td>$correo</td><td>$nivel_html</td><td>$nivel_css</td></td>$nivel_js</td>";
      echo "<td>$total</td></tr>";

    }

    echo "</tbody></table></div>";

}

?>
