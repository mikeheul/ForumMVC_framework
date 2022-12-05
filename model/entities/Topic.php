<?php
    namespace Model\Entities;

    use App\Entity;

    final class Topic extends Entity{

        private int $id;
        private string $title;
        private User $user;
        private \DateTime $dateTopic;
        private bool $locked;
        private int $nbPosts; // non mappé
        private Category $category;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId(): int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of title
         */ 
        public function getTitle(): string
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setTitle($title)
        {
                $this->title = $title;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getUser(): User
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }

        

        /**
         * Get the value of dateTopic
         */ 
        public function getDateTopic(): \DateTime
        {
                return $this->dateTopic;
        }

        /**
         * Set the value of dateTopic
         *
         * @return  self
         */ 
        public function setDateTopic($dateTopic)
        {
                $this->dateTopic = new \DateTime($dateTopic);

                return $this;
        }

        /**
         * Get the value of locked        */ 
        public function getLocked(): bool
        {
                return $this->locked;
        }

        /**
         * Set the value of locked        *
         * @return  self
         */ 
        public function setlocked($locked)        
        {
                $this->locked = $locked;
                return $this;
        }

        /**
         * Get the value of nbPosts
         */ 
        public function getNbPosts(): int
        {
                return $this->nbPosts;
        }

        /**
         * Set the value of nbPosts
         *
         * @return  self
         */ 
        public function setNbPosts($nbPosts)
        {
                $this->nbPosts = $nbPosts;

                return $this;
        }

        /**
         * Get the value of category
         */ 
        public function getCategory(): Category
        {
                return $this->category;
        }

        /**
         * Set the value of category
         *
         * @return  self
         */ 
        public function setCategory($category)
        {
                $this->category = $category;

                return $this;
        }
        
        public function __toString()
        {
                return $this->title;
        }
    }
