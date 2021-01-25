<?php
namespace App\Domain\Traits;


trait Hydrator {

   public function hydrate(array $datas){
       foreach ($datas as $key => $data) {
           $method = 'set'.ucfirst($key);
           if(is_callable([$this, $method])){
               $this->$method($data);
           }
       }
   }
}
