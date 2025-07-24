<?php
class Note {
    private $db;

    public function __construct() {
        require_once 'app/database.php';
        $this->db = db_connect();
    }

    public function getAllByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM notes WHERE user_id = ? AND deleted = 0 ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM notes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createNote($userId, $subject) {
        $stmt = $this->db->prepare("INSERT INTO notes (user_id, subject) VALUES (?, ?)");
        return $stmt->execute([$userId, $subject]);
    }

    public function updateNote($id, $subject, $completed) {
        $stmt = $this->db->prepare("UPDATE notes SET subject = ?, completed = ? WHERE id = ?");
        return $stmt->execute([$subject, $completed, $id]);
    }

    public function deleteNote($id) {
        $stmt = $this->db->prepare("UPDATE notes SET deleted = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

   public function getAll() {
    $db = db_connect();
    $stmt = $db->query("SELECT * FROM notes WHERE deleted = 0 ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getUserWithMostNotes() {
    $db = db_connect();
    $stmt = $db->query("
        SELECT users.username, COUNT(notes.id) as total
        FROM notes
        JOIN users ON notes.user_id = users.id
        WHERE notes.deleted = 0
        GROUP BY users.username
        ORDER BY total DESC
        LIMIT 1
    ");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function getDeleted() {
        $stmt = $this->db->prepare("SELECT * FROM notes WHERE deleted = 1 ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
