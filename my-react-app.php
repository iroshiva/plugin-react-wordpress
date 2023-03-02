<?php

/**
 * Plugin Name: Test React WP
 * Plugin URI: a url
 * Description: A react application
 * Version: 0.1
 * Text Domain: my-react-app
 * Author: Jean Weil
 * Author URI: https://jean-weil.fr
 */

// fonction qui permet de renouveler le [contenthash] généré par webpack
// permet le renouvellement systématique du js et css compilé si changement 
// règle le problème de la mise en cache des assets => change à chaque nouvelle version 
function get_path_asset($name)
{
    // un fichier JSON est généré par le plugin webpack-assets-manifest
    // avec tous les assets (nom d'origine: nom d'export)
    // le js et css ont un contenthash en nom d'export
    // chemin du manifest.json
    $assetManifest = plugin_dir_path(__FILE__) . 'frontend/build/asset-manifest.json';
    static $hash = null;
    static $hashFiles = null;

    if (null === $hash) {
        // récupération du contenu du manifest.json
        $hash = file_exists($assetManifest) ? json_decode(file_get_contents($assetManifest), true) : [];
        $hashFiles = $hash["files"];
    }


    // permet de voir si le nom d'origine ($name) est présent
    if (array_key_exists($name, $hashFiles)) {
        return $hashFiles[$name];
    }

    // si non il retourne le nom d'origine $name
    return $name;
}

// First register resources with init
function my_react_app_init()
{
    // $path = "/frontend/build/static";
    $path = "/frontend/build/";
    // if(getenv('WP_ENV')=="development") {
    //     $path = "/frontend/build/static";
    // }
    wp_register_script("my_react_app_js", plugins_url($path . get_path_asset('main.js'), __FILE__), array(), "1.0", false);
    wp_register_style("my_react_app_css", plugins_url($path . get_path_asset('main.css'), __FILE__), array(), "1.0", "all");
}

add_action('init', 'my_react_app_init');

// Function for the short code that call React app
// retourne la div sur laquelle est branchée react
function my_react_app()
{
    wp_enqueue_script("my_react_app_js", '1.0', true);
    wp_enqueue_style("my_react_app_css");
    return "<div id=\"my_react_app\"></div>";
}

// le premier my_react_app va être le nom du shortcode à mettre dans gutenberg !!!
// le deuxième éxécute la fonction ci-dessus
add_shortcode('my_react_app', 'my_react_app');
