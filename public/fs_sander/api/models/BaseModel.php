<?php

    class BaseModel{
        
        /**
         * asAssociativeArray
         *
         * @param  mixed $obj
         * @return void
         */
        public function asAssociativeArray(){
            return get_object_vars($this);
        }
    }