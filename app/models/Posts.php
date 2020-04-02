<?php
namespace Models;

class Posts extends AbstractModel {

    use \DatabaseTrait;

    public function getPostsByCommunity()
    {
        if($_SESSION['loggedIn']) {
            $userData = \json_decode($_SESSION['userData']);
            $communityID = $userData->community_id;
            try {
                $stmt = $this->db->prepare("
                    SELECT * FROM posts 
                    LEFT JOIN communities ON communities.id = posts.community_id
                    WHERE posts.community_id = ?
                ");
                $stmt->bindParam(1, $communityID);
                $stmt->execute();
                $stmt->setFetchMode(\PDO::FETCH_ASSOC);
                $data = [];
                while($row = $stmt->fetch()) {
                    // $row['title'] = $row['post_title'];
                    // $row['content'] = $row['post_content'];
                    $data[] = $row;
                }
                $this->data = $data;
                // var_dump($this->data);
            }
            catch(PDOException $e) {echo $e->getMessage();}
        }
    }

    public function submitPost($args)
    {
        $userData = json_decode($_SESSION['userData']);
        $postDate = $this->getDateAndTime();
        try {
            $stmt = $this->db->prepare("
                INSERT INTO posts (user_id, post_title, post_content, post_date, community_id) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->bindParam(1, $userData->id);
            $stmt->bindParam(2, $args['data']['title']);
            $stmt->bindParam(3, $args['data']['content']);
            $stmt->bindParam(4, $postDate);
            $stmt->bindParam(5, $userData->community_id);
            $stmt->execute();
        } catch(PDOException $e) {
            echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
        }
    }

    public function joinCommunity($id)
    {
        try {
            $user = $this->db->prepare("
                SELECT users.community_id FROM users
                WHERE users.id = ?
            ");
            $user->bindParam(1, $id);
            $user->execute();
            $communities = [];
            while($row = $user->fetch()) {
                $communities[] = $row;
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}

        array_push($communities, $id);

        try {
            $stmt = $this->db->prepare("
                UPDATE users
                SET community_id = ?
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $communities);
            $stmt->bindParam(2, $id);
            $stmt->execute();
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function leaveCommunity($id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE users
                SET community_id = ?
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $communities);
            $stmt->bindParam(2, $id);
            $stmt->execute();
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }
}