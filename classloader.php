<?php
// fichier classloader.php
class classLoader{
    public static $Instance;
    private $Ext=array('.class.php','.inc.php');

    private function __construct($incPath='lib'){
        set_include_path(get_include_path().PATH_SEPARATOR.$incPath);
        spl_autoload_extensions(implode(', ',$this->Ext));
        spl_autoload_register(array($this, 'loadClass'));
    }

    private function loadClass($class){
// utilisation de namespaces, plus facile à digérer que des magouilles à l'instanciation
        $class=strtolower(str_replace('\\', '/', $class)); // backslashes des namespaces

        spl_autoload($class);
    }

    public static function init(){ // pas un singleton mais une possibilité d'instancier mon loader
        if(self::$Instance==NULL)   self::$Instance=new self();
        return self::$Instance;
    }
}
?>