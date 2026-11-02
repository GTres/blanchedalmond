<?php
/**
 * ============================================================
 * tema_hijo_functions.php_002
 * ============================================================
 * Funciones del tema hijo "Twenty Twenty-Five Child" para
 * el proyecto jltaexpress.com.
 *
 * Esta versión incluye TODO lo de _001 y además:
 *   1. Carga de las fuentes Google (Fira Sans + Newsreader)
 *   2. Carga del style.css del tema hijo (después del padre)
 *   3. Soporte de estilos en el editor de bloques
 *      (para que el editor muestre los colores y fuentes)
 * ============================================================
 */

/**
 * ------------------------------------------------------------
 * INICIO tema_hijo_functions.php_001
 * Entrega: 001
 * Cambios acumulados: 001 (versión inicial)
 *
 * Encola las fuentes y los estilos del tema hijo.
 * El hook 'wp_enqueue_scripts' con prioridad 20 garantiza que
 * nuestro CSS se cargue DESPUÉS del CSS del tema padre, para
 * poder sobrescribir sus estilos sin conflictos.
 * ------------------------------------------------------------
 */
function jltaexpress_enqueue_styles() {

    /**
     * ------------------------------------------------------
     * Carga de fuentes Google
     * ------------------------------------------------------
     * Fira Sans: fuente base del proyecto (UI, cuerpo, botones).
     * Newsreader: fuente serif italic usada en acentos y
     *             palabras destacadas dentro de los títulos.
     */
    wp_enqueue_style(
        'jltaexpress-fonts',
        'https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400;1,6..72,500&display=swap',
        array(),
        null
    );

    /**
     * ------------------------------------------------------
     * Carga del style.css del tema hijo
     * ------------------------------------------------------
     * get_stylesheet_uri() apunta al style.css del tema hijo
     * (no al del padre). Se carga después de las fuentes para
     * evitar dependencias innecesarias.
     *
     * La versión se lee dinámicamente del encabezado del tema
     * para que al actualizar la versión se rompa la caché del
     * navegador automáticamente.
     */
    wp_enqueue_style(
        'jltaexpress-child-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'jltaexpress_enqueue_styles', 20 );
/**
 * ------------------------------------------------------------
 * FIN tema_hijo_functions.php_001
 * ------------------------------------------------------------
 */


/**
 * ------------------------------------------------------------
 * INICIO tema_hijo_functions.php_002
 * Entrega: 002
 * Cambios acumulados: 001 (versión inicial), 002 (editor styles)
 *
 * Añade soporte para que el editor de bloques de WordPress
 * también cargue el style.css del tema hijo. Sin esto, el
 * editor muestra los bloques sin los colores ni las fuentes
 * personalizadas, lo cual dificulta la edición visual.
 *
 * Con esto, el editor y el frontend se ven iguales.
 * ------------------------------------------------------------
 */
function jltaexpress_add_editor_styles() {

    /**
     * Le dice a WordPress que el tema soporta estilos de editor.
     * Es necesario declararlo antes de poder usar add_editor_style().
     */
    add_theme_support( 'editor-styles' );

    /**
     * Carga el style.css del tema hijo dentro del editor.
     * La ruta es relativa a la raíz del tema hijo.
     */
    add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'jltaexpress_add_editor_styles' );
/**
 * ------------------------------------------------------------
 * FIN tema_hijo_functions.php_002
 * ------------------------------------------------------------
 */
 
 
 
 /**
 * ------------------------------------------------------------
 * INICIO tema_hijo_functions.php_003
 * Entrega: 003
 * Cambios acumulados: 001 (fuentes), 002 (estilos editor), 
 *                     003 (script de contadores)
 *
 * Encola el archivo JavaScript que anima los contadores.
 * ------------------------------------------------------------
 */
function jltaexpress_enqueue_counter_scripts() {
    // Solo cargarlo en el frontend, no en el admin
    if ( is_admin() ) return;

    wp_enqueue_script(
        'jltaexpress-contadores', // Handle único
        get_stylesheet_directory_uri() . '/js/contadores.js', // Ruta al archivo
        array(), // Dependencias (ninguna)
        wp_get_theme()->get('Version'), // Versión para caché
        true // Cargar en el footer (true) para no bloquear la carga
    );
}
add_action( 'wp_enqueue_scripts', 'jltaexpress_enqueue_counter_scripts' );
/**
 * ------------------------------------------------------------
 * FIN tema_hijo_functions.php_003
 * ------------------------------------------------------------
 */