<?php
class Top1 {
    private $key;
    private $block_size;

    public function __construct($key) {
        $this->key = hash('sha256', $key, true);
        $this->block_size = 16; // AES block size is 16 bytes
    }

    public function encrypt($data) {
        $data = json_encode($data);
        $iv = substr(hash('sha256', time()), 0, $this->block_size);
        $cipher = openssl_encrypt($this->pad($data), 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $cipher);
    }

    public function decrypt($token) {
        $token = base64_decode($token);
        $iv = substr($token, 0, $this->block_size);
        $encrypted_data = substr($token, $this->block_size);
        $decrypted_data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);
        return json_decode($this->unpad($decrypted_data), true);
    }

    private function pad($data) {
        $pad_length = $this->block_size - (strlen($data) % $this->block_size);
        return $data . str_repeat(chr($pad_length), $pad_length);
    }

    private function unpad($data) {
        $pad_length = ord(substr($data, -1));
        return substr($data, 0, -$pad_length);
    }
}

// Ví dụ sử dụng
$key = "example_secret_key"; // Chuỗi đầu vào để tạo khóa mã hóa
$data = array(
    "userId" => 123,
    "userName" => "example_user",
    "timestamp" => time()
);

$crypto = new Top1($key);
$encrypted_token = $crypto->encrypt($data);
echo "Encrypted token: " . $encrypted_token . "\n";

$decrypted_data = $crypto->decrypt($encrypted_token);
echo "Decrypted data: ";
print_r($decrypted_data);
?>
