<?php
namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;


      // Метод для вставки нового пользователя в таблицу users
    public static function create(string $name, string $email, string $hashPassword): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashPassword]);
    }

    //  Метод для получения данных пользователя по его email
    public static function getOneByEmail(string $email): self|null
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];
        return $obj;
    }

    //  Метод для получения данных пользователя по его идентификатору
    public static function getOneById(int $userId): self|null
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $data = $stmt->fetch();

        if ($data !== false) {
            $obj = new self();
            $obj->id = $data['id'];
            $obj->name = $data['name'];
            $obj->email = $data['email'];
            $obj->password = $data['password'];
            return $obj;
        }
        return null;
    }



    public function getEmail():string
    {
        return $this->email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }



}



