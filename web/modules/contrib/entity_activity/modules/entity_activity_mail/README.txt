CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Similar modules
 * Installation
 * Configuration
 * Usage
 * Troubleshooting
 * FAQ
 * Maintainers
 * Sponsoring

INTRODUCTION
------------

Entity activity Mail allow to configure, generate and send by mail a report of
logs according a frequency a user can configure from its profile. In others
words, this module provide a Mail Digest Feature for the Entity Activity module.

REQUIREMENTS
------------

Entity Activity Mail requires the Entity Activity module.

SIMILAR MODULES
-------------------

N/A

INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module. See:
   https://www.drupal.org/docs/8/extending-drupal-8/installing-modules
   for further information.

CONFIGURATION
-------------

All the configuration happens under
/admin/config/content/entity-activity/mail-settings.

General settings:
 * You can enable / disable sending logs report by mail.
 * You can configure to only send by mail the unread logs. Otherwise all logs
   not already sent will be included into the report.
 * Configure the time the cron will run every day. Because cron jobs can be
   costly in performance, tt is highly recommended to configure the site cron
   at least every hour, and to run the cron from your server.
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

  You should consider to install the Swiftmailer module to send logs report
  with HTML mail. Otherwise logs report mails will be sent as plain text.

Theming
  You can override the template used to render the logs template. An array of
  all the log entities included in the report is available in the twig template,
  giving you the possibility to fully customize the report rendering.
  A renderable array of the log entities (rendered in the view mode mail, added
  by this module) is also included in the template (used as the default).

Permissions
  * Configure the permissions provided by the module to allow users to configure
    Entity Activity Mail

USAGE
-----

 * Users must select a frequency from their profile. If none frequency is
   selected, the user will not receive any logs report by mail. The user can
   choose as frequency :

   - Immediately : An email is sent for each log created for the user
   - Daily : A daily report email will be sent to the user.
   - Weekly : A weekly report email will be sent to the user.
   - Monthly : A monthly report email will be sent to the user.

TROUBLESHOOTING
---------------


FAQ
---


RECOMMENDATION
--------------

 * It is highly recommended to configure the site cron at least every hour, and
   to run the cron from your server. Cron jobs launched can be costly in
   performance.
 *  You should consider to install the Swiftmailer module to send logs report
    with HTML mail. Otherwise logs report mails will be sent as plain text.


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
