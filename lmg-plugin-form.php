<?php
/*
* Plugin Name: lmg-plugin-form
* Author: Luismi G
* Description: Plugin que genera un formulario utilizando el shortcode [lmg_plugin_form]
*/

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
