import hashlib
import base64
from Crypto.Cipher import AES
from Crypto.Util.Padding import pad, unpad
import json
import time


class Top1:
    def __init__(self, key):
        self.key = hashlib.sha256(key.encode()).digest()
        self.block_size = AES.block_size

    def encrypt(self, data):
        data = json.dumps(data).encode('utf-8')
        iv = hashlib.sha256(str(time.time()).encode()).digest()[
            :self.block_size]
        cipher = AES.new(self.key, AES.MODE_CBC, iv)
        encrypted_data = cipher.encrypt(pad(data, self.block_size))
        return base64.b64encode(iv + encrypted_data).decode('utf-8')

    def decrypt(self, token):

        token = base64.b64decode(token)
        iv = token[:self.block_size]
        encrypted_data = token[self.block_size:]
        cipher = AES.new(self.key, AES.MODE_CBC, iv)
        try:
            decrypted_data = unpad(cipher.decrypt(
                encrypted_data), self.block_size)
            return json.loads(decrypted_data.decode('utf-8'))
        except ValueError:
            return None


# Ví dụ sử dụng
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
