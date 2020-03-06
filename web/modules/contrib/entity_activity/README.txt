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

Entity Activity requires the Token module, and the Core modules Text and
Serialization.

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
 * Configure the content entity type on which you want enable subscription.
 * Configure a purge if needed for the logs generated.

 The content entity type supported are those which implements
 ContentEntityTypeInterface and which have a canonical link template.
 Custom modules can alter the supported content entity type to add entity type
 which have not a canonical link template by subscribing to the event
 'entity_activity.support_entity_type'. Custom modules are then responsible to
 generate subscriptions to these additionnal entity type supported (as contact
 message or flagging for example).
 See the issue https://www.drupal.org/project/entity_activity/issues/3063918 for
 a complete example.

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

List subscriptions per entity
  On each content entity enable for Entity Activity, this module a Local Task
  named "Subscribers" on their canonical route. This allows users with relevant
  permissions ("view entities subscribers" or "view entities subscribers on
  editable entities") to see per entity all the subscriptions related.

  The default list use the view mode "default" to render subscriptions. You can
  change this default view mode by another with a setting in the settings.php
  file.

  @code
  $settings['entity_activity']['list_subscribers_view_mode'] = 'VIEW_MODE_ID';
  @endcode

  You can of course override the twig template in your theme and customize the
  listing as you need. All subscriptions entities are available as variable.


MAIL DIGEST FEATURE

Since the beta8 version, the module ships a new sub module Entity Activity Mail.
A blog post introduces this feature.

Entity activity Mail allow to configure, generate and send by mail a report of
logs according a frequency a user can configure from its profile. In others
words, this module provide a Mail Digest Feature for the Entity Activity module.

All the configuration happens under
/admin/config/content/entity-activity/mail-settings.


General settings:
  * You can enable / disable sending logs report by mail.
  * You can configure to only send by mail the unread logs. Otherwise all logs
  not already sent will be included into the report.
  * You can configure to mark as read the logs sent by mail.
  * Configure the time the cron will run every day. Because cron jobs can be
  costly in performance, tt is highly recommended to configure the site cron at
  least every hour, and to run the cron from your server.
  * You can log any report sent with the corresponding option.

Mail settings
 You can configure the following options for the emails sent.
  * The mail from used (default to site mail if empty)
  * A body (token supported for the user entity) displayed above the logs
  included into the report
  * A footer (token supported for the user entity) displayed below the logs
  included into the report

  This settings can be translated. The user's preferred language will be used to
  render the mail.

  You should consider to install the Swiftmailer module to send logs report with
  HTML mail. Otherwise logs report mails will be sent as plain text.

Theming

  You can override the template used to render the logs template. An array of
  all the log entities included in the report is available in the template,
  giving you the possibility to fully customize the report rendering.
  A renderable array of the log entities (rendered in the view mode mail, added
  by this module) is also included in the template (used as the default).


Permissions

  Configure the permissions provided by the module to allow users to configure Entity Activity Mail
  Usage

Frequency

  Users must select a frequency from their profile. If none frequency is
  selected, the user will not receive any logs report by mail. The user can
  choose as frequency :

    *Immediately : An email is sent for each log created for the user
    *Daily : A daily report will be sent to the user.
    *Weekly : A weekly report will be sent to the user.
    *Monthly : A monthly report will be sent to the user.


MASS SUBSCRIBE FEATURE

Since the beta12 version, the module ships a new sub module Entity Activity Mass
Subscribe.

This module allow users with relevant permissions ("mass subscribe users" or "mass
subscribe users on editable entities") to access for each content entity, on
their canonical page, to a local task named "Mass subscribe".

This local task permit to mass subscribe users to this related entity following
three methods :

  * per role
  * per user (selecting one or more users with an entity reference field)
  * per list (selecting users in a table select filterable)

Each method has it own permission, so you can give access to mass subscribe per
role and per method.

Also, as you can mass subscribe users on an entity, a reverse option is
available on the form, allowing you to mass *unsubscribe* users from the entity.


TROUBLESHOOTING
---------------


FAQ
---

* Can I have logs generated for new content ? And how users can subscribe to be
  notified of new content ?

  The only way to be notified of new content is to subscribed to related
  entities (author, taxonomy term, etc) and then configure a generator based
  on the entities referenced by the relevant field. Users who subscribed to
  theses related entities will be the notified of new content.
  There is no way actually to be globally notified. This need a "global"
  subscription which could be implemented if needed in the futur.

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
