<?php

class User
{
    protected int $id;
    protected string $namePrefix = '';
    protected string $first_name = '';
    protected string $last_name = '';
    protected string $username = '';
    protected string $email = '';
    protected bool $email_valid;
    protected array $address = [];
    protected string $phone = '';
    protected string $phoneExtension = '';
    protected string $website = '';
    protected array $company = [];
    protected array $prefix_list = [
        'mrs.',
        'mr.',
        'miss.',
        'dr.'
    ];

    public function __construct($data)
    {
        //set data
        $this->setId($data['id']);
        $this->setName($data['name']);
        $this->setUsername($data['username']);
        $this->setEmail($data['email']);
        $this->validateEmail($data['email']);
        $this->setAddress($data['address']);
        $this->filterPhoneNumber($data['phone']);
        $this->setWebsite($data['website']);
        $this->setCompany($data['company']);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getNamePrefix().' '.$this->first_name.' '.$this->last_name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $name = explode(' ', $name);
        if ((isset($name[0])) && (!in_array(strtolower($name[0]), $this->prefix_list)))
        {
            $this->first_name = $name[0];
            $this->last_name = $name[1];
        }
        else if ((isset($name[0])) && (in_array(strtolower($name[0]), $this->prefix_list)))
        {
            $this->namePrefix = $name[0];
            $this->first_name = isset($name[1])?$name[1]:'';
            $this->last_name = isset($name[2])?$name[2]:'';
        }
        else
        {
            $this->first_name = $name;
        }

        return $this;
    }


    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }


    /**
     * @return User
     */
    public function setFirstName($firstname)
    {
        $this->first_name = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }


    /**
     * @return User
     */
    public function setLastName($lastname)
    {
        $this->last_name = $lastname;
        return $this;
    }


    /**
     * @return string
     */
    public function getNamePrefix()
    {
        return $this->namePrefix;
    }


    /**
     * @return User
     */
    public function setNamePrefix($namePrefix)
    {
        $this->namePrefix = $namePrefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function getEmailValid()
    {
        return $this->email_valid;
    }

    /**
     * @param bool $boolean
     * @return User
     */
    public function setEmailValid($boolean)
    {
        $this->email_valid = $boolean;
        return $this;
    }

    /**
     * @return array
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param array $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneExtension()
    {
        return $this->phoneExtension;
    }

    /**
     * @param string $extension
     * @return User
     */
    public function setPhoneExtension($extension)
    {
        $this->phoneExtension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return User
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return array
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param array $company
     * @return User
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @param string $email
     * @return User
     */
    public function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email_valid = true;
        }
        else {
            $this->email_valid = false;
        }
        return $this;
    }

    /**
     * @param string $number
     * @return User
     */
    public function filterPhoneNumber($number)
    {
        $extension = '';
        $extPosition = strrpos($number, 'x', -1);
        if ($extPosition != '')
        {
            $extension = substr($number, $extPosition+1);
            $this->setPhoneExtension($extension);
            $onlyNumber = substr($number, 0, $extPosition);
        }
        else
        {
            $onlyNumber = substr($number, 0);
        }

        //eliminate non-numeric characters
        $cleanNumber = preg_replace("/[^0-9]/", "", $onlyNumber);
        $this->setPhone($cleanNumber);

        return $this;
    }
}