<?php
namespace Observer;
    interface iSubject{
        public function addSubscriber(iSubscriber $sub);
        public function removeSubscriber(iSubscriber $sub);
        public function notify(string $evento);
    }

    interface iSubscriber{
        public function update($info);
    }

?>