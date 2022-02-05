<?php 

namespace App\Controller;

class Controller {

  protected $data, $output, $nameTemplate;

  protected function getTemplateWithRightPath($templete){
    return DIR_App . "View\\" . $templete . '.php';
  }

  public function header()
  {
  }

  public function home()
  {
    $this->nameTemplate = 'home';
    $this->render();
  }

  public function footer()
  {
    echo 'eu sou um footer';
  }

  public function notFound(){
    echo 'notfound';
  }

  public function render(){
    if (empty($this->nameTemplate)) {
      throw new \Exception('Error: Não foi acrescentado o metodo "setView" no construct do Controller');
  }
    $this->header();
    $this->renderTemplete('header');
    $this->renderTemplete($this->nameTemplate);
    $this->footer();
    $this->renderTemplete('footer');
  }
  
  public function renderTemplete($viewTemplete)
  {
    $template = $this->getTemplateWithRightPath($viewTemplete);
    if (!file_exists($template)) {
        throw new \Exception('Error: Não foi possivel encontrar a view "' . $this->nameTemplate . '"!');
    }
    if(is_array($this->data)) {
     extract($this->data);
    }
    ob_start();
    require($template);
    $this->data = ob_get_contents();
    $this->data = preg_replace("/\s\s+/", ' ', str_replace("\n", '', $this->data));
    return $this->data;
  }
}

?>