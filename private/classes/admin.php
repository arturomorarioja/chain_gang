<?php

class Admin extends Database
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $username;
    protected string $hashedPassword;
    public string $password;
    public string $confirmedPassword;

    public function __construct(array $args=[])
    {
        parent::__construct();
        $this->firstName = $args['first_name'] ?? '';
        $this->lastName = $args['last_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->confirmedPassword = $args['confirmed_password'] ?? '';
    }

    public function fullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    protected function setHashedPassword(): void
    {
        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
    }

    /*******************************
     * Active record design pattern
     *******************************/

    static protected string $tableName = 'admins';
    static protected string $primaryKeyColumn = 'nAdminID';
    static protected array $columns = [
        'nAdminID' => 'id',
        'cFirstName' => 'firstName',
        'cLastName' => 'lastName',
        'cEmail' => 'email',
        'cUsername' => 'username',
        'cHashedPassword' => 'hashedPassword'
    ];

    /**
     * Validates all attributes before a create or update operation
     */
    protected function validate(): void
    {
        $this->validationErrors = [];

        ////
    }

    /**
     * The password is hashed before calling 
     * the parent's create() or update() method
     */
    protected function create(): bool
    {
        $this->setHashedPassword();
        return parent::create();
    }
    protected function update(): bool
    {
        $this->setHashedPassword();
        return parent::create();
    }
}