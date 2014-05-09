MailCatcher Extension
==================
[![Build Status](https://travis-ci.org/kibao/behat-mailcatcher-extension.svg?branch=master)](https://travis-ci.org/kibao/behat-mailcatcher-extension)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kibao/behat-mailcatcher-extension/badges/quality-score.png?s=d544d02de38918a960dd4f64e167aec97f8c09bb)](https://scrutinizer-ci.com/g/kibao/behat-mailcatcher-extension/)

[MailCatcher](http://mailcatcher.me) is a super simple SMTP server which catches any message sent to it.

MailCatcherExtension provides:

* ``Kibao\Behat\MailCatcherExtension\Context\MailCatcherAwareContext``, which provides
  MailCatcher ``Client`` instance for your context.
* ``MailCatcherContext`` context which provides base step definitions for your contexts.

Installation
------------

This extension requires:

* Behat 3.0+


### Through Composer


1. Add MailCatcherExtension to your composer.json:

    ```js
    {
        "require-dev": {
            ...
            "kibao/mailcatcher": "*@dev",
            "kibao/behat-mailcatcher-extension": "0.2.*@dev"
        }
    }
    ```

2. Install or update vendors:

    ```bash
    $ composer update kibao/mailcatcher kibao/behat-mailcatcher-extension
    ```

3. Activate extension in your ``behat.yml``:

    ```yaml
   default:
       # ...
       extensions:
            Kibao\Behat\MailCatcherExtension\Extension: ~
    ```
