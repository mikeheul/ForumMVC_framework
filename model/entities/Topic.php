<?php
    namespace Model\Entities;

    use App\Entity;

    final class Topic extends Entity{

        private $id;
        private $title;
        private $user;
        private $dateTopic;
        private $locked;
        private $nbPosts;
        private $category;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
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
        public function getTitle()
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
        public function getUser()
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
        public function getDateTopic()
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
        public function getLocked()
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
        public function getNbPosts()
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
        public function getCategory()
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
