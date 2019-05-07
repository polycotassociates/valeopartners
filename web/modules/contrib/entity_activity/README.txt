CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Similar modules
 * Installation
 * Configuration
 * Troubleshooting
 * FAQ
 * Maintainers
 * Sponsoring

INTRODUCTION
------------

Entity activity allow to configure and generate any kind of notifications / logs
on any content entity type for each of theses operations : create, update and
delete.

REQUIREMENTS
------------

Entity Activity requires the Token module, and the Core module Text.

SIMILAR MODULES
-------------------

You can use the message stack and the flag module to implement similar
behavior on a Drupal project. Where as these two modules can do a lot more than
a notification/log system, Entity Activity module is completely focused on this
feature, and by this fact is easier to install and configure.

INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module. See:
   https://www.drupal.org/docs/8/extending-drupal-8/installing-modules
   for further information.

CONFIGURATION
-------------

All the configuration happens under /admin/config/content/entity-activity.

General settings:
 * Configure the content entity type on wich you want enable subscription.
 * Configure a purge if needed for the logs generated

Generators and Logs generators :
 * Create and configure as many as you need config entities Generators. Each of
   theses config entities created have all the plugins "Log generator" available
   on the project. Enable and configure the relevant plugins for each config
   entity generator.

Configure Content entity types.
  * For each of the content entity types enabled in the general settings, you
    can enabled the extra field "Subscribe on" in the relevant view mode. This
    extra field will allow user to subscribe on each entities.

Configure Log entities
  * You can enable on the log entity (manage display mode) the extra field
    "Remove log". This extra field allow owner of logs to delete them from their
    account.
  * The status base field "Read" can be configured with the formatter
    "Log Read / Unread". This formatter exposes a widget which allow users
    to mark the logs as read / unread.

Configure subscription entities
  * You can enable on the subscription entity (manage display mode) the extra
    field "Remove subscription". This extra field allow owner of a subscription
    to delete it.

Log and subscription entity type
  Globally you can add and configure others fields on theses entity types. As
  you can do for node. But you have to then to manage how theses fields will be
  set programmatically. Relevant Events are dispatched for each hook during
  the CRUD cycle (presave, postsave, update, insert, delete, etc.)

Multilingual support
  Subscriptions are multilingual aware. So a user can subscribe on content for
  each translations available. Log messages are generated in the current
  language when the operation is performed. You can force a log message to be
  generated in the user's preferred language (if set), by checking the
  corresponding option in the general settings. Warning. This option is costly
  in performance because each log message must be regenerated for each owner of
  a subscription. Use it only if you really need log messages to be generated
  in the user's preferred language.

Plugin type "Log generator"
  You can add your own plugin and override some of the methods responsible
  to generate the logs if the needs of a project are too specific. The module
  ship by default 4 plugins, for each main content entity type of Drupal Core :
  Node, User, Taxonomy term, Comment.

Permissions
  * Configure the permissions provided by the module to allow users to
    (un)subscribe on entities, to view / remove their subscription and their
    logs which have been generated according their subscriptions.

This module ship with some useful widgets :
  * A user's log block : display a counter of unread logs, and embed the latest
      X unread logs.
  * A Views area Plugin to display the total unread logs on views based on the
      Log entity type.
  * A Views area Plugin which provide a button which allow to mark all the
      unread logs as read. Only on views based on the Log entity type of course.

TROUBLESHOOTING
---------------


FAQ
---

* Can I have logs generated for new content ? And how users can subscribe to be
  notified of new content ?

  The only way to be notified of new content is to subscribed to related
  entities (author, taxonomy term, etc) and then configure a generator based
  on the entities referenced by the relevant field. Users who subscribed to
  theses related entites will be the notified of new content.
  There is no way actually to be globally notified.

MAINTAINERS
-----------

Current maintainer:
 * flocondetoile
   - https://drupal.org/u/flocondetoile
   - https://www.flocondetoile.fr

SPONSORING
-----------

The initial development was sponsored by :
 * Gallimedia - https://www.gallimedia.com
