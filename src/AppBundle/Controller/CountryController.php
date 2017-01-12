<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CountryController extends Controller


{

	/**
     * @Route("/poland", name="poland")
     */
	 
    public function poland()
    
			{
				
			$country = new \stdClass;
			$country->name = 'Poland';
			$country->lat = 52.2112;
			$country->lng = 21.4346;
			$country->zoom = 5;
			$country->entity = 'AppBundle:citiespoland';
			$country->comment = '- wszystkie miasta - GUS 2012';
			
			
			$response = $this->forward('AppBundle:Atlas:first', array('country'  => $country));
			
				
			return $response;
			
			}//poland
	
	
	
	
    
   
    /**
     * @Route("/uk", name="uk")
     */
	 
    public function uk()
    
			{
				
			$country = new \stdClass;
			$country->name = 'UK';
			$country->lat = 54.0;
			$country->lng = 0.0;
			$country->zoom = 5;
			$country->entity = 'AppBundle:citiesuk';
			$country->comment = '- 1000 największych miast brytyjskich - census 2000';
			
			
			$response = $this->forward('AppBundle:Atlas:first', array('country'  => $country));
			
				
			return $response;
			
			}//uk
	
	
	/**
     * @Route("/us", name="us")
     */
    
    public function us()
    
			{
		
			$country = new \stdClass;
			$country->name = 'US';
			$country->lat = 37.4;
			$country->lng = -98.4;
			$country->zoom = 4;
			$country->entity = 'AppBundle:citiesus';
			$country->comment = '- 1000 największych miast amerykańskich - census 2010';
			
			
			$response = $this->forward('AppBundle:Atlas:first', array('country'  => $country));

			
			return $response;

			}//us
    
    
    
    
    
}//class CountryController
?>
