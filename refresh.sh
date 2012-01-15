#!/bin/bash
set -e
php symfony doctrine:build --all --and-load --no-confirmation
php symfony cache:clear
echo "Successfully rebuilt DB and cleared the cache." 
exit
