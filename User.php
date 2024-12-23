<?php
class User
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new user
    public function createUser($matric, $name, $password, $role)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $matric, $name, $password, $role);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Read all users
    public function getUsers()
    {
        $sql = "SELECT matric, name, role FROM users";
        $result = $this->conn->query($sql);
        if ($result) {
            return $result;
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Read a single user by matric
    public function getUser($matric)
    {
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $matric);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Update a user's information
    public function updateUser($matric, $name, $role)
    {
        $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $name, $role, $matric);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Delete a user by matric
    public function deleteUser($matric)
    {
        $sql = "DELETE FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $matric);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }
        public function register($matric, $name, $password, $role) {
            // Check if the user already exists
            $sql = "SELECT matric FROM users WHERE matric = :matric";
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $matric);
                $stmt->execute();
                $stmt->store_result();
    
                if ($stmt->num_rows > 0) {
                    $stmt->close();
                    return "User already exists.";
                }
    
                $stmt->close();
            } else {
                return "Error: " . $this->conn->error;
            }
             // Create the user
        return $this->createUser($matric, $name, $password, $role);
    }
}
?>
