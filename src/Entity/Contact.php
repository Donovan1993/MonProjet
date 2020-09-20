<?php
//  src/Entity/Contact.php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

class Contact
{

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $Prenom;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $Nom;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     * pattern="/[0-9]{10}/"
     * )
     */
    private $Telephone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email
     */
    private $Email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $Message;

    /**
     * @var Logement|null
     */
    private $logement;


    public function getPrenom(): string
    {
        return (string) $this->Prenom;
    }

    public function setPrenom($Prenom)
    {
        $this->Prenom = $Prenom;
    }


    public function getEmail(): string
    {
        return (string) $this->Email;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
    }


    public function getNom(): string
    {
        return (string) $this->Nom;
    }

    public function setNom($Nom)
    {
        $this->Nom = $Nom;
    }


    public function getTelephone(): string
    {
        return (string) $this->Telephone;
    }

    public function setTelephone($Telephone)
    {
        $this->Telephone = $Telephone;
    }


    public function getMessage(): string
    {
        return (string) $this->Message;
    }

    public function setMessage($Message)
    {
        $this->Message = $Message;
    }

    public function getLogement()
    {
        return $this->logement;
    }

    public function setLogement($logement)
    {
        $this->logement = $logement;
    }
}
