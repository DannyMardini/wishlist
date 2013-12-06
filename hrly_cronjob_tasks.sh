#!/bin/bash
# This script contains all of the tasks that need to be run by cron jobs hourly
set -e

app/console wishenda:recycle-password-tokens #remove reset password tokens after 24 hours

app/console wishenda:sendinvites 10 # add emails to the queue to be sent

app/console swiftmailer:spool:send # this sends emails waiting to be sent
