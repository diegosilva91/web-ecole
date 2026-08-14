# Mi-empresa.com
### Instructions for Card test
Entry this number for each case
#### Succes Payment 
Visa	Any 3 digits	Any future date
```
4242424242424242
```
Set any CVV
### 3 Factors Auth
3D Secure 2 authentication must be completed for the payment to be successful. By default, your Radar rules will request 3D Secure authentication for this card.
```
4000000000003220
```
### Expired Date

```
4000000000005126
```
### Incorrect
If a CVC number is provided, the cvc_check fails. If your account is blocking payments that fail CVC code validation, the charge is declined.
```
4000000000000101
```
### Expired or cancelled Card

```
4000000000005126
```
### International pricing
Charge succeeds and domestic pricing is used (other test cards use international pricing). This card is only significant in countries with split pricing.
```
4000000000000093
```
### Postal Code Validation
The address_zip_check verification fails. If your account is blocking payments that fail postal code validation, the charge is declined.
```
4000000000000036
```
### Attemps Customer Fail
Attaching this card to a Customer object succeeds, but attempts to charge the customer fail.
``` 
4000000000000341
```

### Instructions for SEPA Account test
#### The charge status transitions from pending to succeed.
````
ES0700120345030000067890
````
#### The charge status transitions from pending to failed.
````
ES9121000418450200051332 
````
#### The charge status transitions from pending to succeeded, but a dispute is immediately created.
````
ES5000120345030000067892
````