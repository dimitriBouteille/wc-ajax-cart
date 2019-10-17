# Wordpress Ajax Cart for Woocommerce

![Wordpress Version Tested](https://img.shields.io/wordpress/plugin/tested/bbpress)
![Version de Woocommerce](https://img.shields.io/badge/woocommerce-3.7.1%20tested-success)

Librairie Wordpress qui permet de créer un panier en Ajax pour le plugin [Woocommerce](https://fr.wordpress.org/plugins/woocommerce/). 
Pour le moment, la librairie contient que la partie back-end, c'est-à-dire le PHP. 
La partie en Javascript reste à la charge du développeur.

À l'heure d'aujourd'hui, seules les actions suivantes sont supportées par la librairie :
- Ajout et réduction de la quantité d'un produit
- Suppression d'un produit du panier
- Ajout d'un code promo
- Suppression d'un code promo

### Installation

Si vous utilisez composer :

```
composer require dbout/dbout-wc-ajax-cart
```

Si vous n'utilisez pas composer, importez la classe `Dbout\Woocommerce\WcAjaxCart\WcAjaxCart` dans le fichier `functions.php` de votre thème :

```php
<?php

require_once DIR_TO_PATH.'/WcAjaxCart.php';

use Dbout\Woocommerce\WcAjaxCart;
WcAjaxCart::getInstance()->loadFiles();
```

### Utilisation

Afin d'enregistrer les actions ajax dans Wordpress, ajoutez ces quelques lignes en haut du fichier `functions.php` de votre thème :

```php
<?php

use Dbout\Woocommerce\WcAjaxCart\WcAjaxCart;
WcAjaxCart::getInstance()->register();
```

Et voilà, les actions ajax sont enregistrées dans Wordpress !

Afin de gérer au mieux les URL(endpoints) des actions, la librairie propose plusieurs fonctions d'aides pour chaque action :

- __ajaxCartAddQuantityUrl(string $itemId)__ : Retourne l'URL qui permet d'augmenter la quantité d'un produit.

- __ajaxCartRemoveQuantityUrl(string $itemId)__ : Retourne l'URL qui permet de réduire la quantité d'un produit.

- __ajaxCartRemoveCouponUrl(string $coupon)__ : Retourne l'URL qui permet de supprimer un code promo.

- __ajaxCartAddCouponUrl(string $coupon = null)__ : Retourne l'URL qui permet d'ajouter un code promo.

##### Réponse Ajax

Par défaut, l'ensemble des actions retournent un objet `Dbout\Woocommerce\WcAjaxCart\Response\InterfaceWcAjaxCartResponse` qui une fois envoyé au navigateur a le format suivant :

    {
        "status": {
            "code": 200,
            "error_message": null
        },
        "results": {}
    }
    
Il est possible de modifier la structure de la réponse, à l'aide de deux filtres (filter en Wordpress) :

- __dbout_wc_ajax_cart_response__ : Qui est appelé juste avant l'envoi de la réponse au navigateur. 
```php
add_filter('dbout_wc_ajax_cart_response', function($response, $action) {

    // Do someting ..
    
    return $response;
});
```

- __dbout_wc_ajax_cart_response_success__ : Qui est appelé uniquement lorsque l'action a correctement abouti.
```php
add_filter('dbout_wc_ajax_cart_response_success', function($response, $action) {

    // Do someting ..
    
    return $response;
});
```
