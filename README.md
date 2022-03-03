# nextcloud-app-nkhooks
Webhooks on demand

# Installation

+ Clone this repo into your app directory.
+ Build.
+ Enable/Install using occ

```bash
git clone git@github.com:reekol/nextcloud-app-nkhooks.git /var/www/{myNextcloudHome}/public/apps/nkhooks
cd /var/www/{myNextcloudHome}/public/apps/nkhooks
make
sudo -u apache php8 /var/www/{myNextcloudHome}/public/occ app:enable nkhooks
sudo -u apache php8 /var/www/{myNextcloudHome}/public/occ app:install nkhooks

```
