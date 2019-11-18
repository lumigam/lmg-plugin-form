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
    $query = "CREATE TABLE IF NOT EXITS $tabla_aspirante(
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      nombre varchar (40) NOT NULL,
      correo varchar (100) NOT NULL,
      nivel_html smallint (4) NOT NULL,
      nivel_css smallint (4) NOT NULL,
      nivel_js samllint (4) NOT NULL,
      created_at datetime NOT NULL,
      UNIQUE (id)
    ) $charset_collate";
    include_once ABSPATH . 'wp-admin/includes/upgrades.php';
    dbDelta($query);

}



//Definde el shortcode que pinta el formulario
add_shortcode( 'lmg_plugin_form', 'LMG_plugin_form' );

function LMG_plugin_form () {

      ob_start( );
      ?>

      <form action="<?php get_the_permalink(); ?>" method="post" class="formulario">

        <div class="form-input">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" required="required">
        </div>

        <div class="form-input">
          <label for="correo">Correo</label>
          <input type="email" name="Correo" id="correo" required>
        </div>

        <div class="form-input">
          <label for="Nivel Html">¿Cuál es tu Nivel de HTML?</label>
          <input type="radio" name="nivel_html" value="1" required> Nada </br>
          <input type="radio" name="nivel_html" value="2" required> Estoy aprendiendo </br>
          <input type="radio" name="nivel_html" value="3" required> Tengo experiencia </br>
          <input type="radio" name="nivel_html" value="4" required> Lo domino al dedillo </br>
        </div>

        <div class="form-input">
          <label for="nivel_css">¿Cuál es tu Nivel de css?</label>
          <input type="radio" name="nivel_css" value="1" required> Nada </br>
          <input type="radio" name="nivel_css" value="2" required> Estoy aprendiendo </br>
          <input type="radio" name="nivel_css" value="3" required> Tengo experiencia </br>
          <input type="radio" name="nivel_css" value="4" required> Lo domino al dedillo </br>
        </div>

        <div class="form-input">
          <label for="nivel_js">¿Cuál es tu Nivel de JavasCript?</label>
          <input type="radio" name="nivel_js" value="1" required> Nada </br>
          <input type="radio" name="nivel_js" value="2" required> Estoy aprendiendo </br>
          <input type="radio" name="nivel_js" value="3" required> Tengo experiencia </br>
          <input type="radio" name="nivel_js" value="4" required> Lo domino al dedillo </br>
        </div>

        <div class="form-input">
          <label for="aceptacion">La información facilitada se trata con respeto y admiración</label>
          <input type="checkbox" name="aceptacion" id="aceptacion" value="1" required> Entiendo y acepto las condiciones
        </div>

        <div class="form-input">
          <input type="submit" value="Enviar">
        </div>
      </form>
      <?php
      return ob_get_clean();
}

?>
