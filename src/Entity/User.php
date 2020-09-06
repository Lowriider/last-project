<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields={"email"}, message= "L'email indiqué est déjà utilisé")
 */

class User implements UserInterface
{
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire au moins 8 caractères")
     
     */
    private $password;

    /**
    * @Assert\EqualTo(propertyPath="password", message="Les mots de passe ne sont pas identiques")
    */
    public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity=RentAd::class, mappedBy="user", orphanRemoval=true)
     */
    private $rentAds;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    public function __construct()
    {
        $this->rentAds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function eraseCredentials()
    {
        
    }
    public function getSalt()
    {
        
    }

    /**
     * @return Collection|RentAd[]
     */
    public function getRentAds(): Collection
    {
        return $this->rentAds;
    }

    public function addRentAd(RentAd $rentAd): self
    {
        if (!$this->rentAds->contains($rentAd)) {
            $this->rentAds[] = $rentAd;
            $rentAd->setUser($this);
        }

        return $this;
    }

    public function removeRentAd(RentAd $rentAd): self
    {
        if ($this->rentAds->contains($rentAd)) {
            $this->rentAds->removeElement($rentAd);
            // set the owning side to null (unless already changed)
            if ($rentAd->getUser() === $this) {
                $rentAd->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
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
}
