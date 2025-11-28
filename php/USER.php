<?php

class UserModel {
    private $db;
    private $table;


    public function __construct(PDO $db, $table = 'usuarios') {
        $this->db = $db;
        $this->table = $table;
    }

    public function createUser(string $name, string $email, string $password, string $role = 'funcionario', ?string $cpf = null, ?string $birth = null): array {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'E-mail inválido.'];
        }

        if ($this->emailExists($email)) {
            return ['success' => false, 'message' => 'E-mail já cadastrado.'];
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO {$this->table} (name, email, password, cpf, data_nasc, cargo) VALUES (:name, :email, :password, :cpf, :data_nasc, :cargo)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $hash);
            $stmt->bindValue(':cpf', $cpf);
            $stmt->bindValue(':data_nasc', $birth);
            $stmt->bindValue(':cargo', $role);
            $ok = $stmt->execute();
            if ($ok) {
                return ['success' => true, 'id' => (int)$this->db->lastInsertId()];
            }
            return ['success' => false, 'message' => 'Não foi possível criar usuário.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro no banco de dados.', 'error' => $e->getMessage()];
        }
    }

    public function authenticate(string $email, string $password) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user) return false;

            $stored = $user['password'] ?? $user['senha'] ?? null;
            if (!$stored) return false;

            if (password_verify($password, $stored)) {
                unset($user['password']);
                unset($user['senha']);
                return $user;
            }

            if ($stored === $password) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $update = $this->db->prepare("UPDATE {$this->table} SET password = :ph WHERE email = :email");
                $update->execute([':ph' => $newHash, ':email' => $email]);
                unset($user['password']);
                unset($user['senha']);
                return $user;
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getById(int $id): ?array {
        try {
            $candidates = ['id', 'id_usuario'];
            foreach ($candidates as $col) {
                $sql = "SELECT * FROM {$this->table} WHERE {$col} = :id LIMIT 1";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) {
                        unset($row['password']);
                        unset($row['senha']);
                        return $row;
                    }
                }
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function setAvatar(int $id, string $avatarPath): bool {
        try {
            $sql = "UPDATE {$this->table} SET foto_perfil = :p WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':p', $avatarPath);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            try {
                $sql2 = "UPDATE {$this->table} SET profile_pic = :p WHERE id = :id";
                $stmt2 = $this->db->prepare($sql2);
                $stmt2->bindValue(':p', $avatarPath);
                $stmt2->bindValue(':id', $id, PDO::PARAM_INT);
                return $stmt2->execute();
            } catch (PDOException $e2) {
                return false;
            }
        }
    }

    public function emailExists(string $email): bool {
        try {
            $sql = "SELECT 1 FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>