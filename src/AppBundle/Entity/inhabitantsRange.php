<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Callback;



/**
 * @Assert\Callback(methods={"checkCustomValidation"})
 */


class inhabitantsRange
{
    
	
	
	 /**
	 * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Range(
     *      min = 0,
     *      max = 9000000,
     *      minMessage = "Liczba musi być większa od {{ limit }}",
     *      maxMessage = "Liczba musi być mniejsza od {{ limit }}"
     * )
     */
	
	protected $minNumber;
	
	 /**
	 * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Range(
     *      min = 0,
     *      max = 9000000,
     *      minMessage = "Liczba musi być większa od {{ limit }}",
     *      maxMessage = "Liczba nie może być większa od {{ limit }}"
     * )
     */
	
	
    protected $maxNumber;

    public function getMinNumber()
    {
        return $this->minNumber;
    }

    public function setMinNumber($minNumber)
    {
        $this->minNumber = $minNumber;
    }

    public function getMaxNumber()
    {
        return $this->maxNumber;
    }

    public function setMaxNumber($maxNumber)
    {
        $this->maxNumber = $maxNumber;
    }
	
	public function checkCustomValidation(ExecutionContextInterface $context)
    {
        if ($this->getMaxNumber()-$this->getMinNumber()<0){
	
    $context->addViolationAt('maxNumber', 'maximum musi być mniejsze od minimum!');
	
	}
    }
	
}
?>