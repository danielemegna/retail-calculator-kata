<?php

class UnsupportedStateException extends Exception {

    public function __construct(string $stateCode) {
        parent::__construct("Unsupported state code [$stateCode]");
    }
}

