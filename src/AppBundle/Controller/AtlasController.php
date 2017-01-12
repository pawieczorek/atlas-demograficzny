<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use EasyRdf_Sparql_Client;
use EasyRdf_Namespace;
use EasyRdf_Literal;
use AppBundle\Entity\inhabitantsRange;
use AppBundle\Form\InhabitantsRangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;



class AtlasController extends Controller


{
	
	/**
     * @Route("/atlas")
     */
    public function atlas()
    
	{
        
        return $this->render('main.html.twig');
    
	}//atlas
	
	
	/**
	 *
	 * @Route("/firstAction", options={"expose"=true}, name="firstAction")
	 * 
	 *
	 */
	 
	
	public function firstAction(Request $request)
			
			{   
			$entity = new inhabitantsRange();
			$form = $this->createCreateForm($entity);
			$form->handleRequest($request);

			if ($request->isXmlHttpRequest())
					
					{
						
					if ($form->isValid()) 
							{
							
							$countryEntity = $request->get('countryentity');		

							$response = $this->sqlAction($countryEntity, $entity->getMinNumber(), $entity->getMaxNumber() );
							
							return $response;
							
							}//if

					else 
							{
								
							$response = new JsonResponse(
									array(
									
								'message' => 'Error',
								'form' => $this->renderView('form.html.twig',
										array(
									'entity' => $entity,
									'form' => $form->createView(),
								))), 400);
							 return $response;	
								
							}//else	
								
					}//if

					
			if (!$request->isXmlHttpRequest())
			
					{
					$country = $request->get('country');
					}

					
			return $this->render('map1.html.twig', array(
													'form' => $form->createView(),
													'country' => $country));
				
			}//firstAction
	 

	private function createCreateForm($entity)

			{
				
			$form = $this->createFormBuilder($entity)
			->add('minNumber', 'integer')
			->add('maxNumber', 'integer')
			->getForm();


			return $form;

			}//createCreateForm


//-----------------------------------------------------------------------------------------		
	
    
    
    /**
     * @Route("/ajaxAction2",options={"expose"=true}, name="ajax_Action2")
     */
	 
    public function ajaxAction2(Request $request)
			
			{
		  
			$city=$request->get('city'); 
		   
			EasyRdf_Namespace::set ('owl', 'http://www.w3.org/2002/07/owl#');
			EasyRdf_Namespace::set ('xsd', 'http://www.w3.org/2001/XMLSchema#');
			EasyRdf_Namespace::set ('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
			EasyRdf_Namespace::set ('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
			EasyRdf_Namespace::set ('foaf', 'http://xmlns.com/foaf/0.1/');
			EasyRdf_Namespace::set ('dc', 'http://purl.org/dc/elements/1.1/');
			EasyRdf_Namespace::set ('rrr', 'http://dbpedia.org/resource/');
			EasyRdf_Namespace::set ('dbpedia2', 'http://dbpedia.org/property/');
			EasyRdf_Namespace::set ('dbpedia', 'http://dbpedia.org/');
			EasyRdf_Namespace::set ('skos', 'http://www.w3.org/2004/02/skos/core#');
		
			$sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
			$result = $sparql->query(
			'SELECT ?opis WHERE {'.
			' {<http://dbpedia.org/resource/'.$city.'> rdfs:comment ?opis.FILTER (LANG(?opis)="en")}}'    
			);
			
			if( isset($result[0]) && ($result[0]!=null) )
				
				{	
				$opis=$result[0]->opis->getValue();		
				}
			
			else
		
				{
				$opis = 'Nie znaleziono odpowiedniego opisu';	
				}
		
		
			$response = array('code' => 100, 'success' => true, 'data'=>$opis);
			
			return new JsonResponse($response);
				 
			}//ajaxAction2
    
    
	/**
     * @Route("/zakresAction",options={"expose"=true}, name="zakresAction")
     */
    public function zakresAction(Request $request)
	

			{
			
			$zakresy=array("1"=>"100000",
						   "2"=>"200000",
						   "5"=>"500000");
							  
			$z=$request->get('zakres');
			$zakres=$zakresy[$z];
			
			$entity=$request->get('entity');
			
			$response = $this->forward('AppBundle:Atlas:sql', array(
			'entity'  => $entity,
			'minNumber'  => $zakres,
			'maxNumber'  => '9000000'
			));

			return $response;
			
			}//zakresAction
			
			
		
		
	/**
	 * @Route("/sqlAction", name="sqlAction")
	 */
	
	
	
	public function sqlAction($entity, $minNumber, $maxNumber )
	
		{
		
		$repository = $this->getDoctrine()
		->getRepository($entity);

		$query = $repository->createQueryBuilder('c')
							->where('c.populacja > :minNumber AND :maxNumber > c.populacja')
							->setParameter('minNumber', $minNumber)
							->setParameter('maxNumber', $maxNumber)
							->orderBy('c.populacja', 'DESC')
							->getQuery();

		$cities = $query->getResult();
		
		$resultArray=array();
				
		foreach ($cities as $row) 
				
				{
					   
				$ile = $row->getPopulacja();
				
				if (($ile>1) && ($ile<=10000)){$zakres=7;};
				if (($ile>10000) && ($ile<=50000)){$zakres=6;};
				if (($ile>50000) && ($ile<=100000)){$zakres=5;};
				if (($ile>100000) && ($ile<=200000)){$zakres=4;};
				if ($ile>200000 && $ile<=500000){$zakres=3;};
				if ($ile>500000 && $ile<=1000000){$zakres=2;};
				if ($ile>1000000 && $ile<=10000000){$zakres=1;};
			   
			   
			   
				$arr=array("miasto"=>$row->getMiasto(),
							 "ile"=>$row->getPopulacja(),
							 "lat"=>$row->getLat(),
							 "long"=>$row->getLng(),
							 "zakres"=>$zakres  );
							 
				$resultArray[]=$arr;
						 
				}//foreach
       
       
		
		
        $response = array('message' => 'Success!',
							'code' => 100,
							'success' => true,
							'data'=>$resultArray);
        
		return new JsonResponse($response);


    
		}//sql    
    
    
}//class AtlasController
?>
