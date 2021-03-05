### 1
-        "sensio/distribution-bundle": "^5.0.19",
         "sensio/framework-extra-bundle": "^5.0.0",
         "symfony/monolog-bundle": "^3.1.0",
         "symfony/polyfill-apcu": "^1.0",
-        "symfony/swiftmailer-bundle": "^2.6.4",
-        "symfony/symfony": "3.4.*",
+        "symfony/swiftmailer-bundle": "^3",
+        "symfony/symfony": "^4.0",
         "twig/twig": "^1.0||^2.0"
     },
     "require-dev": {
-        "sensio/generator-bundle": "^3.0",
-        "symfony/phpunit-bridge": "^3.0"
+        "symfony/phpunit-bridge": "^4.0"


### 2
 php composer.phar update --with-all-dependencies
 php composer.phar require symfony/flex