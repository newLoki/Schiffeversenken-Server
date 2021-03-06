<?php
/**
 * @Table(name="accounts")
 * @Entity(repositoryClass="Custom_Repository_AccountRepository")
 */
class Custom_Entity_Account {

    /**
     * @var integer $id
     * @Id @Column(type="integer") 
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string $nickname
     * @Column(type="string")
     */
    private $nickname;
    
    /**
     * @var string $email
     * @Column(type="string")
     */
    private $email;
    
    /**
     * @var string $password
     * @Column(type="string")
     */
    private $password;
    
    /**
     * @var string $created_at
     * @Column(type="datetime")
     */
    private $created_at;

    /**
     * @var string $image
     * @Column(type="string")
     */
    private $image;

    /**
     * @var string $firstname
     * @Column(type="string")
     */
    private $firstname;

    /**
     * @var string $lastname
     * @Column(type="string")
     */
    private $lastname;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setNickname($name)
    {
        $this->nickname = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getNickname()
    {
        return $this->nickname;
    }
    
    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password, $hash)
    {
        if (empty($hash)) {
            throw new Exception('Hash required (2nd argument): use $object->setPassword($password, $hash)');
        }
        
        $this->password = hash('SHA256', $hash . $password);
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Set created_at
     *
     * @param \datetime $created_at
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * Get created_at
     *
     * @return \datetime $created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}