<?php
define('PublicPemKey', '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAukCxUaStoQdcnONPCSNN
Yby9F7ZQtcKtqCdHv3Evy6GMT9+Ruh/RztP5Q8ZBOq4P1BlsXpKaDBGaCRdyVbDk
AXEbkvL2ZC21sb1KZo3CqVbnjjiCcd+PjeeH+AQZJ0vM4oUaP9yr6CZ2/LJYKoIQ
4tkjiGQXYpIDzls8gU5hkfBzrz4M6dZZ1R4EHwfsb7rZpcACrdLKcJHYw3sAPtVa
a3C0Eunnlf6rFK/LFYPcIVxrGELSB1VaPPLJE3tMwW0LJquCo7NrQQuQ03s7fuqW
euboDDj0u40A9CA8B+2CqNcjsKxXlYOyG8VKOrr0XVPGuiWVyon/dU5VCn2tA6po
xwIDAQAB
-----END PUBLIC KEY-----');

define('PrivatePemKey', '-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC6QLFRpK2hB1yc
408JI01hvL0XtlC1wq2oJ0e/cS/LoYxP35G6H9HO0/lDxkE6rg/UGWxekpoMEZoJ
F3JVsOQBcRuS8vZkLbWxvUpmjcKpVueOOIJx34+N54f4BBknS8zihRo/3KvoJnb8
slgqghDi2SOIZBdikgPOWzyBTmGR8HOvPgzp1lnVHgQfB+xvutmlwAKt0spwkdjD
ewA+1VprcLQS6eeV/qsUr8sVg9whXGsYQtIHVVo88skTe0zBbQsmq4Kjs2tBC5DT
ezt+6pZ65ugMOPS7jQD0IDwH7YKo1yOwrFeVg7IbxUo6uvRdU8a6JZXKif91TlUK
fa0DqmjHAgMBAAECggEAcBEG4FIO6uosDnYzExN7twhCWqcnTwYxSRFBeW5YTNUK
QPELlQsaSbF/tQjwLKeY/IzDiO/64rIglcHW2LqTpk5xQe0Q1dwvDCASSTyY2R1i
PE/CJVRX4xFh3ZhRrjRMtitSTQSxJwEl7Qw+Qm16TZRLbgCTlYq34Y1CDaeky5L0
sljRSK8MC6BXLL5d04eTjPGZUh4LOFt1Cp39LStyWE1lE3KOIfivXZEv61SI+cUq
u5HtvgOW8lVz1+zrKbdxVjMzWcB9XiRcadwSsKUbKThPDTAJm7bALEQft4oVkdE5
gw9+S5Fy6RgzBfcAW0cTc3G3IcGvY0QTWEHos0ki6QKBgQDa7lFcreCsYiM1cid6
t+bvuHnJMWigeYs3X4cweT9/zG3Rv/7/eth4Sokpitmytu/H5yoolrKoPpXhPilg
4atA95YyEVGKqIcegXqr+iaYNFlSckQBkLlir0EIUTgfitwpELfhsmWhQ4dTunO0
7nsoi7OC7oSBTJIjUHRw5+Nf5QKBgQDZyetO2cCvVX2NLuboFNLL79MgMDwjyCzQ
XcJAubu+nb2SoPrn3nGHl+R+XVCg100aOYnFOEAJR4TZkV6ZiBWy5+UMqLdHdTIu
uVN6zEN6eO9C+WOWmWCCRnrf1sR3qj3t2mi5TnOlpRWMnXde/tLPLgrBf5OC6wgs
RXAK8xsjOwKBgQCHflb8dOBHz7TarvugB5D1a8ZzrhCCwLZYXtbcOS4DehG9boXy
t6ShTf/1pel1oaJkpbyBwkJvvcwkysPxIblLS++4rN86YXK+foPdS8P3Du75B57v
GRKi8LPe4eVKIDaBc8dZ937Of2yRdSOHJtEyFsPSlKuNGkaXdIOcHOerwQKBgCsA
X2G2RQFZk+yochco5WY2+CzG2VkHUTHjEVPOWG+Onbux5Via5zeqmgcJTb40RJkE
+1rhfGNYp7Z9qXwPDpnAh800EtwdG8d1+DGq2zf3YOaMb0lxB0kxuVkxAqHOD2RD
V6IfB16RdevJu6QaFG2r3ZvPIMUcuwRiwXin/5e5AoGAHYj36k3qyKgHJONGTzOB
DCn2fS506HhE0E03z2a/RwNbOGm477r/O2FxxYJomOTsHtdeoJFkwX5psBUGK0vq
uCZSCD3yS0VRqwmMOAOa6CIdV3IYwS2I7WbXQO40tvHNi+UP5oEHx+XduEvmu6jn
+MvKPdQNyNiYLYY13ShN32s=
-----END PRIVATE KEY-----
');

class RSATool {
    static function encryptByPublicKey($data) {
        $encrypted = '';
        openssl_public_encrypt($data, $encrypted, PublicPemKey);
        return base64_encode($encrypted);
    }

    static function encryptByPrivateKey($data) {
        $encrypted = '';
        openssl_private_encrypt($data, $encrypted, PrivatePemKey);
        return base64_encode($encrypted);
    }

    static function decryptByPublicKey($data) {
        $decrypted = '';
        openssl_public_decrypt(base64_decode($data), $decrypted, PublicPemKey);
        return $decrypted;
    }

    static function decryptByPrivateKey($data) {
        $decrypted = '';
        openssl_private_decrypt(base64_decode($data), $decrypted, PrivatePemKey);
        return $decrypted;
    }
}