#!/bin/bash
# This script contains all of the tasks that need to be run by cron jobs hourly
set -e
touch /home/ubuntu/cronttest

cd /var/www/wishenda/

php app/console --env=prod wishenda:recycle-password-tokens #remove reset password tokens after 24 hours

php app/console --env=prod wishenda:sendinvites 10 # add emails to the queue to be sent

php app/console --env=prod swiftmailer:spool:send # this sends emails waiting to be sent
