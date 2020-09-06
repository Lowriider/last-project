<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {


    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $mail;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=255)
     */
    private $message;

    private $to;
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */

    /**
     * Get the value of mail
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }


    /**
     * Get the value of to
     */ 
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set the value of to
     *
     * @return  self
     */ 
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }
}