## bringticket API Examples

You can find complete API documentation at https://developer.bringticket.com/
To start copy "api.php.sample" to "api.php" and enter your API Token and Secret

All necessary functions to make a valid request can be found in "misc.php". 

### Files overview

|File                    |Purpose                                       |
|:-----------------------|:---------------------------------------------|
|api_get_events.php      | Returns a all events assigned to this account|
|api_get_cats.php        | Returns a all ticket categories for a event  |
|api_get_order.php       | Returns order status                |
|api_order_cancel.php    | cancel ticket orders |
|api_order_simple.php    | Create ticket order|
|api_order_pers.php      | Create personalised ticket order |
|misc.php                | Basic request function  |

## HTTP Headers

|Header                  |                                              |
|:-----------------------|:---------------------------------------------|
|X-API-KEY               | Your API Token                               |
|X-API-HASH              | Generated MAC with API Secret                |
|X-API-TIMESTAMP         | Current unix timestamp which has been used to generate MAC |

## Generate MAC

### PHP

```PHP
function generate_mac($endpoint, $unixTimestamp, $payload, $privateKey, $algo = "sha256") {
 	if(! is_string($payload)) {
 		throw new Exception("payload is not a string");
 	}
	$unhashed = $endpoint.$unixTimestamp.$payload;
	return hash_hmac($algo, $unhashed, $privateKey);
}
```

### Python

```Python
import hmac
import hashlib
import time

def generate_mac(endpoint, unix_timestamp, payload, private_key, algo = hashlib.sha256):
	unhashed = '{}{}{}'.format(endpoint, unix_timestamp, payload)
	return hmac.new(bytes(private_key, 'utf-8'), unhashed.encode('utf-8'), digestmod = hashlib.sha256).hexdigest()

endpoint = "/v1/order/cancel"
payload = "{\"orderId\" => 30233}"
api_secret = 'your_api_secret'
now = int(time.time())

print(generate_mac(endpoint, now, payload, api_secret))
```

### Bash

```bash
ENDPOINT=/v1/order/cancel
PAYLOAD='{"orderId" => 30233}'
TIMESTAMP=$(date +%s)
UNHASHED=${ENDPOINT}${TIMESTAMP}${PAYLOAD}
echo -n $UNHASHED | openssl sha256 -hmac "your_api_secret"
```