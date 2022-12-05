<?php
    namespace Model\Entities;

    use App\Entity;

    final class Category extends Entity{

        private int $id;
        private string $categoryName;

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
         * Get the value of categoryName
         */ 
        public function getCategoryName(): string
        {
                return $this->categoryName;
        }

        /**
         * Set the value of categoryName
         *
         * @return  self
         */ 
        public function setCategoryName($categoryName)
        {
                $this->categoryName = $categoryName;

                return $this;
        }
        
        public function __toString()
        {
            return $this->categoryName;
        }

    }