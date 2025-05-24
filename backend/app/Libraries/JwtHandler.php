<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler {
    private $key = 'my_secret_key';
    private $alg = 'HS256';

    public function encode($data) {
        return JWT::encode($data, $this->key, $this->alg);
    }

    public function validate($token) {
        try {
            $decoded = JWT::decode(str_replace('Bearer ', '', $token), new Key($this->key, $this->alg));
            return (array)$decoded;
        } catch (Exception $e) {
            return false;
        }
    }
}
