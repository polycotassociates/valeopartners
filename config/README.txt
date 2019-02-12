This directory structure contains the staging config for your site.

The "site" folder contains the .yml exports for the current version of the site.

from the web directory, export:

lando drush config-export --destination=../config/site

import:

lando drush config-import --source=../config/site
