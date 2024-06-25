# Ví dụ sử dụng - Example
### Python
```python
if __name__ == "__main__":
    secret_key = "example_secret_key"
    data = {
        "userId": 1,
        "userName": "phukhuong",
        "timestamp": time.time()
    }

    crypto = Top1(secret_key)
    encrypted_token = crypto.encrypt(data)
    print(f"Encrypted token: {encrypted_token}")

    decrypted_data = crypto.decrypt(encrypted_token)
    print(f"Decrypted data: {decrypted_data}")
```
### Php
```php
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


```
