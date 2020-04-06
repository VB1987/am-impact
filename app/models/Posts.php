<?php
namespace Models;

class Posts extends AbstractModel {

    use \DatabaseTrait;

    public function getPostsByCommunity()
    {
        if($this->checkUserIsBlocked()) {
            return;
        }
        
        if($_SESSION['loggedIn']) {
            $communityID = $this->getMemberOfCommunitiesId();
            
            if(isset($communityID)) {
                $data = [];
                foreach ($communityID as $singleId) {
                    try {
                        $stmt = $this->db->prepare("
                            SELECT posts.id, posts.user_id, posts.post_title, posts.post_content, posts.post_date, posts.likes, posts.community_id FROM posts 
                            LEFT JOIN communities ON communities.id = posts.community_id
                            WHERE posts.community_id = ?
                        ");
                        $stmt->bindParam(1, $singleId);
                        $stmt->execute();
                        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
                        while($row = $stmt->fetch()) {
                            $data[] = $row;
                        }
                    }
                    catch(PDOException $e) {echo $e->getMessage();}
                }
                usort($data, function($a, $b) {
                    return strtotime($a['post_date']) - strtotime($b['post_date']);
                });

                $this->data = $data;
            }
        }
    }

    public function submitPost($args)
    {
        if($this->checkUserIsBlocked()) {
            return;
        }

        $userId = $this->getLoggedInUserId();
        $postDate = $this->getDate();
        $postTime = $this->getTime();
        
        try {
            $stmt = $this->db->prepare("
                INSERT INTO posts (user_id, post_title, post_content, post_date, post_time, community_id) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $args['data']['title']);
            $stmt->bindParam(3, $args['data']['content']);
            $stmt->bindParam(4, $postDate);
            $stmt->bindParam(5, $postTime);
            $stmt->bindParam(6, $args['data']['community id']);
            $stmt->execute();

            $this->sendMailtoMembers($args['data']['community_id']);

        } catch(PDOException $e) {
            echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
        }
    }

    public function joinCommunity($id)
    {
        if($this->checkUserIsBlocked()) {
            return;
        }

        $userId = $this->getLoggedInUserId();

        $communities = $this->getMemberOfCommunitiesId();

        if(!in_array($id, $communities)) {
            array_push($communities, $id);
            $communities = implode(',', $communities);
            
            try {
                $stmt = $this->db->prepare("
                    UPDATE users
                    SET community_id = ?
                    WHERE users.id = ?
                ");
                $stmt->bindParam(1, $communities);
                $stmt->bindParam(2, $userId);
                $stmt->execute();
            }
            catch(PDOException $e) {echo $e->getMessage();}
        }
    }

    public function leaveCommunity($id)
    {
        $userId = $this->getLoggedInUserId();

        $communities = $this->getMemberOfCommunitiesId();
        
        foreach($communities as $value) {
            if($value == $id) {
                continue;
            }
            $communitiesNew[] = $value;
        }
        
        $communitiesNew = implode(',', $communitiesNew);

        try {
            $stmt = $this->db->prepare("
                UPDATE users
                SET community_id = ?
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $communitiesNew);
            $stmt->bindParam(2, $userId);
            $stmt->execute();
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function likePost($id)
    {
        $userId = $this->getLoggedInUserId();
        $likes = $this->getLikes($id);
        $likedPosts = $this->getLikedPostsByUser();
        $postedBy = $this->getPostedBy($id);
        
        $likedPosts = explode(',', $likedPosts);

        if (!in_array($id, $likedPosts) && !$postedBy) {
            $this->addLikedPostsToUser($id);
            $likes++;

            try {
                $stmt = $this->db->prepare("
                    UPDATE posts
                    SET likes = ?
                    WHERE posts.id = ?
                ");
                $stmt->bindParam(1, $likes);
                $stmt->bindParam(2, $id);
                $stmt->execute();
            } catch(PDOException $e) {
                echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
            }
        }
    }

    public function getLikes($id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT posts.likes FROM posts
                WHERE posts.id = ?
            ");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            
            while($row = $stmt->fetch()) {
                $likes = $row;
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}
        
        if(isset($likes)) {
        
            return $likes['likes'];
        } else {
            return false;
        }
    }

    public function addLikedPostsToUser($id)
    {
        $userId = $this->getLoggedInUserId();

        try {
            $stmt = $this->db->prepare("
                SELECT liked_post_ids FROM users
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $userId);
            $stmt->execute();

            while($row = $stmt->fetch()) {
                $communities = $row['liked_post_ids'];
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}
        
        $communities = explode(',', $communities);

        if(!in_array($id, $communities)) {
            array_push($communities, $id);
            $communities = implode(',', $communities);
            
            try {
                $stmt = $this->db->prepare("
                    UPDATE users
                    SET liked_post_ids = ?
                    WHERE users.id = ?
                ");
                $stmt->bindParam(1, $communities);
                $stmt->bindParam(2, $userId);
                $stmt->execute();
            }
            catch(PDOException $e) {echo $e->getMessage();}
        }
    }

    public function getLikedPostsByUser()
    {
        $userId = $this->getLoggedInUserId();

        try {
            $stmt = $this->db->prepare("
                SELECT users.liked_post_ids FROM users
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $userId);
            $stmt->execute();

            while($row = $stmt->fetch()) {
                $likedPosts = $row['liked_post_ids'];
            }

            return $likedPosts;
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function getJoinedCommunitiesByUser()
    {
        $userId = $this->getLoggedInUserId();
        $communityIds = $this->getMemberOfCommunitiesId();
        
        if(isset($communityIds)) {
            $communities = [];
            foreach($communityIds as $singleId) {
                try {
                    $stmt = $this->db->prepare("
                    SELECT * FROM users
                        LEFT JOIN communities ON communities.id = $singleId
                        WHERE users.id = ?
                    ");
                    $stmt->bindParam(1, $userId);
                    $stmt->execute();
                    
                    while($row = $stmt->fetch()) {
                        $communities[] = $row;
                    }
                }
                catch(PDOException $e) {echo $e->getMessage();}
            }
        
            return $communities;
        }
    }

    public function checkUserIsBlocked()
    {
        $userId = $this->getLoggedInUserId();

        try {
            $stmt = $this->db->prepare("
                SELECT users.blocked FROM users
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $userId);
            $stmt->execute();

            while($row = $stmt->fetch()) {
                $blocked = $row['blocked'];
            }

            if($blocked == 1) {
                return true;
            } else {
                return false;
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function getMemberOfCommunitiesId()
    {
        $userId = $this->getLoggedInUserId();

        try {
            $stmt = $this->db->prepare("
                SELECT users.community_id FROM users
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            
            while($row = $stmt->fetch()) {
                $communities = $row['community_id'];
            }
            $communities = explode(',', $communities);
            
            foreach($communities as $value) {
                if($value === '') {
                    continue;
                }
                $communitiesNew[] = $value;
            }
            
            if(isset($communitiesNew)) {
                usort($communitiesNew, function($a, $b) {
                    return $a - $b;
                });
                
                return $communitiesNew;
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function getPostedBy($id)
    {   
        $userId = $this->getLoggedInUserId();

        try {
            $stmt = $this->db->prepare("
                SELECT posts.user_id FROM posts
                WHERE posts.id = ?
            ");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            
            while($row = $stmt->fetch()) {
                $postByUser = $row['user_id'];
            }
            
            if($postByUser === $userId) {
                return true;
            } else {
                return false;
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}   
    }

    public function sendMailtoMembers($communityId)
    {
        require_once 'resources/swift-mailer/lib/swift_required.php';

        $emails = $this->getCommunityMembersEmail($communityId);

        $msg = 'Er is een niewe post geplaats op een community waar u lid van bent.';

        // foreach($emails as $email) {
            // var_dump($email);
            // mail($email, 'New Post', $msg, 'From:vincent.braamburg@live.nl');
        // }
            // Nieuwe e-mail componeren
            $message = \Swift_Message::newInstance();
            // "Subject" instellen
            $message->setSubject('New post');
            // "From" instellen
            $message->setFrom(array('example@gmail.com'));
            // "To" instellen
            // $message->setTo(array($emails));
            $message->setTo($emails);
            // "Body" instellen
            $message->setBody($msg);
            // Een alternatieve "Body" instellen voor als HTML toegelaten wordt
            // $message->addPart('<q>Ik citeer hier een bericht.</q>','text/html');
            
            // De instellingen voor het mailen configureren
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com',465,'ssl');
            $transport->setUsername('example@gmail.com');
            $transport->setPassword('password');
            
            // De mailer opstellen op basis van de gezette instellingen
            $mailer	= \Swift_Mailer::newInstance($transport);
            
            // Het bericht daadwerkelijk versturen
            $result = $mailer->send($message);
    }

    public function getCommunityMembersEmail($communityId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, email, community_id FROM users
            ");
            $stmt->bindParam(1, $userId);
            $stmt->execute();

            while($row = $stmt->fetch()) {
                $users[] = $row;
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}

        foreach($users as $user) {
            $communityIds = explode(',', $user['community_id']);
        
            if(in_array($communityId, $communityIds)) {
                $emails[] = $user['email'];
            }
        }

        return $emails;
    }
}