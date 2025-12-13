<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;
    
    #[ORM\Column(type: "string", length: 180, unique: true)]
    private $username;
    
    #[ORM\Column(type: "json")]
    private $roles = [];      
   
    #[ORM\Column(type: "string")]
    #[Assert\Length(min: 6, max: 255, minMessage: 'La contraseña debe contener {{ limit }} caracteres al menos')]
    private $password;
  
    #[ORM\Column(type: "string", length: 20)]
    private $nombre;
    
    #[ORM\Column(type: "string", length: 20)]
    private $apellido1;
   
    #[ORM\Column(type: "string", length: 20)]
    private $apellido2;
 
    #[ORM\Column(type: "string", length: 30)]
    #[Assert\Email(message: 'The email {{ value }} is not a valid email.')]
    private $email;
   
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $foto;
   
    #[ORM\Column(type: "string", length: 30, nullable: true)]
    private $departamento;    
  
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\EqualTo(propertyPath: "password", message: "Las contraseñas no coinciden.")]
    private $confirmPassword;     

    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }             
    
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }


    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }        

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): self
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(string $apellido2): self
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getDepartamento(): ?string
    {
        return $this->departamento;
    }

    public function setDepartamento(string $departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }   

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(?string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }       
}
