<?php
namespace AppBundle\Twig;

use Twig_SimpleFunction;


class AppExtension  extends \Twig_Extension
{
    public function getFunctions()
    {
        $mapping = array(
            'google_map1' => 'renderMap1',
            //'add_markers' => 'addMarkers',
            //'new12' => 'new1',
            
        );

        $functions = array();
        foreach ($mapping as $twig => $local) {
            $functions[] = new Twig_SimpleFunction($twig, array($this, $local), array('is_safe' => array('html')));
        }

        return $functions;
        
    }  
        
    public function renderMap1()
    {
      return '<script>
      
      var map;
      var markers = [];
      var cityData = [];
      function initMap() {
		  map = new google.maps.Map(document.getElementById("map"), {
              center: {lat: 52.2333, lng:21.0167},
              zoom:2
              });
		  
        
      }// initMap
      
      
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOShG3N6wwB6-Wi5Od1ET_Y52rExgQgJo&libraries=places&callback=initMap"
    async defer>
    
    
    
    </script>';
    }

   
    
    

    public function getName()
    {
        return 'app_extension';
    }

}
?>
