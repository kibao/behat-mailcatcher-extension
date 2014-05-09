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

Configuration
-------------

Default configuration:

```yaml
default:
    # ...
    extensions:
        Kibao\Behat\MailCatcherExtension\Extension:
            client:
                url:    http://localhost    # MailCatcher http url
                port:   1080                # MailCatcher http port
            purge_before_scenario:      true
            mailcatcher_client:         kibao.mailcatcher.client.default    # client service
            mailcatcher_connection:     kibao.mailcatcher.connection.guzzle # connection service
```

Usage
-----

First of all you need to have installed [MailCatcher](http://mailcatcher.me/).

There are few options:

1. Extending ``RawMailCatcherContext`` in your feature suite. It provides you
  preconfigured MailCatcher with basic methods. ``RawMailCatcherContext`` doesn't
  provide any step definitions, so you can extend it in many contexts.

2. Extending ``MailCatcherContext`` with one of your contexts. It provides you
  same things as ``RawMailCatcherContext`` and also predefined steps out of the box.

3. Adding ``MailCatcherContext`` as context in your suite.

    ```yaml
    default:
      suites:
        my_suite:
          contexts:
            - FeatureContext
            - Kibao\Behat\MailCatcherExtension\Context\MailCatcherContext
    ```

4. Implementing ``MailCatcherAwareContext`` with your context. Target context must
  implement ``setMailCatcher(ClientInterface $mailcatcher)``. This method would be
  automatically called immediately after each context creation before each scenario.
  ``$mailcatcher`` will be preconfigured client based on your settings.
