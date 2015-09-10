# wp-ppm
WordPress Plugin Package Manager

A simple plugin package manager for WordPress. This allows developers to create bespoke themes and include the required plugins for their environments to be installed via an automated script. Rather than installing the plugin directly, they just have to include the plugin and version within the jSON file, much like Composer and any other package manger.

To install plugins:

    php wp-ppm.phar install
    
To update all plugins to the latest stable version

    php wp-ppm.phar update
    
To update the WordPress plugin package manager itself:

    php wp-ppm.phar self-update
    
