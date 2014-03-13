#!/bin/bash
#This script will refresh your database fixture and entities.
set -e

ShowUsage()
{
    cat << EOF
    usage: $0

    Update database with changes using Doctrine.
EOF
}

while getopts ":h" OPTION
do
    case $OPTION in
        h)
            ShowUsage
            exit
            ;;
        ?)
            echo "Unknown option - $OPTION"
            ShowUsage
            exit
            ;;
    esac
done

echo "Generating entities..."
php app/console generate:doctrine:entities Wishlist --no-debug

echo "Updating Database..."
php app/console --env=prod doctrine:schema:update --force --no-debug

echo "Updating assets..."
php app/console assetic:dump --env=prod --no-debug -v

exit 0

