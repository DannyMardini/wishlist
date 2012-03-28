#!/bin/bash
echo "Generating entities..."
php app/console generate:doctrine:entities Wishlist

echo "Dropping Database..."
php app/console doctrine:schema:drop --force

echo "Updating Database..."
php app/console doctrine:schema:update --force

if [ ! $? ]; then
    echo "Error updating database."
    exit 1
fi


echo "Loading Fixtures..."
php app/console doctrine:fixtures:load

if [ ! $? ]; then
    echo "Error loading fixtures."
    exit 1
fi

exit 0

