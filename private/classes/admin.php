<?php

class Admin extends Database
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $username;
    protected string $hashedPassword = '';
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

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->hashedPassword);
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
    protected bool $passwordRequired = true;
    private const STR_MIN_LENGTH = 2;
    private const STR_MAX_LENGTH = 64;
    private const EMAIL_MIN_LENGTH = 6;
    private const EMAIL_MAX_LENGTH = 320;
    private const PASSWORD_MIN_LENGTH = 8;
    private const PASSWORD_MAX_LENGTH = 72; // Maximum length for BCRYPT

    /**
     * Validates all attributes before a create or update operation
     */
    protected function validate(): void
    {
        $this->validationErrors = [];

        if (isBlank($this->firstName)) {
            $this->validationErrors[] = 'First name cannot be blank.';
        } elseif (!lengthBetween($this->firstName, self::STR_MIN_LENGTH, self::STR_MAX_LENGTH)) {
            $this->validationErrors[] = 'First name must be between ' . self::STR_MIN_LENGTH . ' and ' . self::STR_MAX_LENGTH . ' characters.';
        }
        if (isBlank($this->lastName)) {
            $this->validationErrors[] = 'Last name cannot be blank.';
        } elseif (!lengthBetween($this->lastName, self::STR_MIN_LENGTH, self::STR_MAX_LENGTH)) {
            $this->validationErrors[] = 'Last name must be between ' . self::STR_MIN_LENGTH . ' and ' . self::STR_MAX_LENGTH . ' characters.';
        }
        if (isBlank($this->email)) {
            $this->validationErrors[] = 'Email cannot be blank.';
        } elseif (!lengthBetween($this->email, self::EMAIL_MIN_LENGTH, self::EMAIL_MAX_LENGTH)) {
            $this->validationErrors[] = 'Email must be between ' . self::EMAIL_MIN_LENGTH . ' and ' . self::EMAIL_MAX_LENGTH . ' characters.';
        } elseif (!isValidEmail($this->email)) {
            $this->validationErrors[] = 'Invalid email address format.';
        }
        if (isBlank($this->username)) {
            $this->validationErrors[] = 'Username cannot be blank.';
        } elseif (!lengthBetween($this->username, self::STR_MIN_LENGTH, self::STR_MAX_LENGTH)) {
            $this->validationErrors[] = 'Username must be between ' . self::STR_MIN_LENGTH . ' and ' . self::STR_MAX_LENGTH . ' characters.';
        } elseif (debug_backtrace()[1]['function'] === 'create' && static::getByUsername($this->username)) {
            $this->validationErrors[] = "The username {$this->username} already exists.";
        }
        if ($this->passwordRequired) {
            if (isBlank($this->password)) {
                $this->validationErrors[] = 'Password cannot be blank.';
            } elseif (!lengthBetween($this->password, self::PASSWORD_MIN_LENGTH, self::PASSWORD_MAX_LENGTH)) {
                $this->validationErrors[] = 'Password must be between ' . self::PASSWORD_MIN_LENGTH . ' and ' . self::PASSWORD_MAX_LENGTH . ' characters.';
            } elseif (!preg_match('/[A-Z]/', $this->password)) {
                $this->validationErrors[] = 'Password must contain at least one uppercase letter.';
            } elseif (!preg_match('/[a-z]/', $this->password)) {
                $this->validationErrors[] = 'Password must contain at least one lowercase letter.';
            } elseif (!preg_match('/[0-9]/', $this->password)) {
                $this->validationErrors[] = 'Password must contain at least one number.';
            } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
                $this->validationErrors[] = 'Password must contain at least one special character.';
            }
            if ($this->password !== $this->confirmedPassword) {
                $this->validationErrors[] = 'Password and confirmed password must match.';
            }
        }
    }    

    /**
     * If the password is not required, it is removed from the list of attributes
     * @return The updated list of attributes
     */
    public function attributes(): array
    {
        $attributes = parent::attributes();
        if (!$this->passwordRequired) {
            unset($attributes['hashedPassword']);
        }
        return $attributes;
    }

    /**
     * If the password is not required, it is removed from the list of columns
     * @return The updated list of columns
     */
    protected function columnsForUpdate(): array
    {
        $columns = parent::columnsForUpdate();
        if (!$this->passwordRequired) {
            // The hashed password is removed from the list of columns
            $columns = array_filter(
                $columns, 
                fn($value, $key) => $key !== 'cHashedPassword', 
                ARRAY_FILTER_USE_BOTH
            );
        }
        return $columns;
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
        if ($this->password === '') {
            $this->passwordRequired = false;
        } else {        
            $this->setHashedPassword();
        }
        return parent::update();
    }

    /**
     * It retrieves an admin row by username
     * @param $username The username
     * @return<Admin> The corresponding Admin object if the username exists, 
     *         false otherwise
     */
    static public function getByUsername(string $username): Admin|false
    {
        $tableName = static::$tableName;
        $columns = static::columnsForSelect();
        $sql =<<<SQL
            SELECT $columns
            FROM $tableName
            WHERE cUsername = ?;
        SQL;
        $db = new static();
        $row = $db->execute($sql, [$username], true);
        if (!$row) {
            self::$lastErrorMessage = Database::$lastErrorMessage;
            return false;
        }
        return self::instantiate($row);
    }
}