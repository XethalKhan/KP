# Example API calls

**Method:** POST  
**Endpoint:** /sign-up

## XML API call example

### Headers

`Content-type: application/xml`

```
<?xml version="1.0"?>
<sign_up>
    <email>zika.ziki@example.loc</email>
    <password>12345678</password>
    <password_repeat>12345678</password_repeat>
</sign_up>
```

## Example body for JSON API call

### Headers

`Content-type: application/json`

```
{
    "email": "zika.ziki@example.loc",
    "password": "12345678",
    "password_repeat": "12345678"
}
```