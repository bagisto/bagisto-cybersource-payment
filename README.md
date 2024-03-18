### 1. Introduction:

Bagisto Cybersource Payment Gateway is an advanced and feature-rich module that will integrate your Bagisto store with the Cybersource payment gateway. This module work with checkout for payment in Bagisto. This module allows the admin to collect online payments from the customer's accounts. The customers can make payments through card information. The admin can easily link the Bagisto store with the Cybersource payment gateway.


Bagisto Cybersource Payment Extension Features:

* Admin must register himself on Cybersource website to get profile id, access key and secret key.
* Enable/disable the payment solution.
* Set Cybersource payment gateway module title.
* Provide secure, trusted and fast payment to the customers.
* The customer can select the Cybersource payment method available on the checkout page.
* Check placed orders details like invoices and transaction.
* Secure Acceptance Hosted Checkout Integration


### 2. Requirements:

* **Bagisto**: v2.0.0.

### 3. Installation:

* Unzip the respective extension zip and then merge "packages" folder into project root directory.

* Goto config/app.php file and add following line under 'providers'.

~~~
Webkul\CyberSource\Providers\CyberSourceServiceProvider::class,
~~~

* Goto composer.json file and add following line under 'psr-4'

~~~
"Webkul\\CyberSource\\": "packages/Webkul/CyberSource/src"
~~~

* Goto app/Http/Middleware/VerifyCsrfToken.php file and add following line under '$except' variables

~~~
protected $except = [
    'checkout/cyber-source/*',
];
~~~

* Run these commands below to complete the setup

~~~
composer dump-autoload
~~~

~~~
php artisan route:cache
~~~

### 4. Cybersource Dashboard:

* Goto Cybersource Dashboard and follow below steps after creating an account 

* Add below details inside Payment Configuration -> Secure Acceptance Settings -> Edit Profile -> Customer Response -> Transaction Response Page -> Select Hosted By You

~~~
Domain/checkout/cyber-source/response
~~~

* Goto Cybersource Dashboard, add below details inside Payment Configuration -> Secure Acceptance Settings -> Edit Profile -> Customer Response -> Custom Cancel Response Page -> Select Hosted By You

~~~
Domain/checkout/cyber-source/cancel
~~~

> Your Bagisto instance is now ready to accept payments from CyberSource.