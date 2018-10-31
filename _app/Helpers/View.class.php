<?php

/**
 * View [ HELPER MVC ]
 * Responsável por carregar o template, povoar e exibir, povoar e incluir arquivos PHP no sistema.
 * Arquitetura MCV
 * 
 * @copyright (c) 2015, Rafael Osaku
 */
class View {

    private $Data;
    private $Keys;
    private $Values;
    private $Template;
    
    /**
     * <b>Carregar Template View:</b> informe o caminho e o nome do arquivo que deseja carregar como view.
     * Não precisa informar extenção. Oarquivo deve ter o formato view<b>.tpl.html</b>
     * @param STRING $Template = Caminho / Nome do arquivo
     */
    public function Load($Template) {
        $this->Template = REQUIRE_PATH . DIRECTORY_SEPARATOR . '_tpl' . DIRECTORY_SEPARATOR . (string) $Template;
        $this->Template = file_get_contents($this->Template . '.tpl.html');
        return $this->Template;
    }
    
    public function Show(array $Data, $View) {
        $this->setKeys($Data);
        $this->setValues();
        $this->ShowView($View);
    }
    
    public function Request($File, array $Data){
        extract($Data);
        require "{$File}.inc.php";
    }
    
    //PRIVATES
    
    private function setKeys($Data) {
        $this->Data = $Data;
        $this->Data['HOME'] = HOME;
        $this->Keys = explode('&', '#' . implode("#&#", array_keys($this->Data)) . '#');
        $this->Keys[] = '#HOME#';
    }
    
    private function setValues() {
        $this->Values = array_values($this->Data);
    }
    
    private function ShowView($View){
        $this->Template = $View;
        echo str_replace($this->Keys, $this->Values, $this->Template);
    }

}
